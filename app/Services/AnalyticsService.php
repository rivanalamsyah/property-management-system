<?php

namespace App\Services;

use App\Models\BoardingHouse;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Complaint;
use App\Enums\PaymentStatus;
use App\Enums\InvoiceStatus;
use App\Enums\ComplaintStatus;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public function getKPIs(array $filters): array
    {
        $tenantId = tenant()->id;
        $houseId = $filters['boarding_house_id'] ?? null;

        $housesQuery = BoardingHouse::where('tenant_id', $tenantId);
        if ($houseId) {
            $housesQuery->where('id', $houseId);
        }
        $totalHouses = $housesQuery->count();

        $roomsQuery = Room::whereHas('boardingHouse', function ($q) use ($tenantId, $houseId) {
            $q->where('tenant_id', $tenantId);
            if ($houseId) {
                $q->where('id', $houseId);
            }
        });
        
        $totalRooms = (clone $roomsQuery)->count();
        $occupiedRooms = (clone $roomsQuery)->where('status', 'occupied')->count();
        $vacantRooms = $totalRooms - $occupiedRooms;
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0;

        // Active tenants
        $activeTenants = Resident::where('tenant_id', $tenantId)
            ->whereHas('contracts', function ($q) use ($houseId) {
                $q->where('status', 'active');
                if ($houseId) {
                    $q->where('boarding_house_id', $houseId);
                }
            })
            ->count();

        // Expiring Contracts in 30 days
        $expiringContracts = Contract::where('tenant_id', $tenantId)
            ->where('status', 'active')
            ->whereDate('end_date', '<=', now()->addDays(30))
            ->whereDate('end_date', '>=', now())
            ->when($houseId, function ($q) use ($houseId) {
                $q->where('boarding_house_id', $houseId);
            })
            ->count();

        // Outstanding Bills
        $outstandingBills = Invoice::where('tenant_id', $tenantId)
            ->whereIn('status', [InvoiceStatus::PENDING, InvoiceStatus::SENT, InvoiceStatus::VIEWED, InvoiceStatus::OVERDUE])
            ->when($houseId, function ($q) use ($houseId) {
                $q->where('boarding_house_id', $houseId);
            })
            ->sum('grand_total');

        // Revenue
        $paymentsQuery = Payment::where('tenant_id', $tenantId)
            ->where('status', PaymentStatus::COMPLETED)
            ->when($houseId, function ($q) use ($houseId) {
                $q->where('boarding_house_id', $houseId);
            });

        $monthlyRevenue = (clone $paymentsQuery)->whereMonth('payment_date', date('m'))
            ->whereYear('payment_date', date('Y'))
            ->sum('amount_paid');
        $annualRevenue = (clone $paymentsQuery)->whereYear('payment_date', date('Y'))
            ->sum('amount_paid');
        $totalRevenue = (clone $paymentsQuery)->sum('amount_paid');

        // Collection Rate
        $collectionRate = 0.00;
        $totalBilled = $totalRevenue + $outstandingBills;
        if ($totalBilled > 0) {
            $collectionRate = round(($totalRevenue / $totalBilled) * 100, 1);
        }

        // Pending Complaints
        $pendingComplaints = Complaint::where('tenant_id', $tenantId)
            ->whereIn('status', [ComplaintStatus::OPEN, ComplaintStatus::REVIEWED, ComplaintStatus::ASSIGNED, ComplaintStatus::IN_PROGRESS, ComplaintStatus::WAITING_PARTS])
            ->when($houseId, function ($q) use ($houseId) {
                $q->where('boarding_house_id', $houseId);
            })
            ->count();

        return [
            'totalHouses' => $totalHouses,
            'totalRooms' => $totalRooms,
            'occupiedRooms' => $occupiedRooms,
            'vacantRooms' => $vacantRooms,
            'occupancyRate' => $occupancyRate,
            'activeTenants' => $activeTenants,
            'expiringContracts' => $expiringContracts,
            'outstandingBills' => $outstandingBills,
            'monthlyRevenue' => $monthlyRevenue,
            'annualRevenue' => $annualRevenue,
            'pendingComplaints' => $pendingComplaints,
            'collectionRate' => $collectionRate,
        ];
    }

    public function getMonthlyRevenueTrend(array $filters): array
    {
        $tenantId = tenant()->id;
        $houseId = $filters['boarding_house_id'] ?? null;
        $year = $filters['year'] ?? date('Y');

        // Use DB-driver-aware month extraction for MySQL/SQLite compatibility
        $driver = config('database.default');
        $monthExpr = $driver === 'sqlite'
            ? DB::raw('strftime("%m", payment_date) as month')
            : DB::raw('LPAD(MONTH(payment_date), 2, "0") as month');

        $payments = Payment::where('tenant_id', $tenantId)
            ->where('status', PaymentStatus::COMPLETED)
            ->whereYear('payment_date', $year)
            ->when($houseId, function ($q) use ($houseId) {
                $q->where('boarding_house_id', $houseId);
            })
            ->select(
                $monthExpr,
                DB::raw('SUM(amount_paid) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Populate all 12 months with 0.00 if missing
        $trend = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthPad = str_pad($i, 2, '0', STR_PAD_LEFT);
            $match = $payments->firstWhere('month', $monthPad);
            $trend[date('F', mktime(0, 0, 0, $i, 1))] = $match ? (float) $match->total : 0.00;
        }

        return $trend;
    }

    public function getRevenueByProperty(array $filters): array
    {
        $tenantId = tenant()->id;

        // Single query: group payments by boarding_house_id to avoid N+1
        $revenueByHouse = Payment::where('tenant_id', $tenantId)
            ->where('status', PaymentStatus::COMPLETED)
            ->select('boarding_house_id', DB::raw('SUM(amount_paid) as total'))
            ->groupBy('boarding_house_id')
            ->pluck('total', 'boarding_house_id')
            ->toArray();

        // Fetch all property names in a single query
        $properties = BoardingHouse::where('tenant_id', $tenantId)
            ->pluck('name', 'id')
            ->toArray();

        $data = [];
        foreach ($properties as $id => $name) {
            $data[$name] = isset($revenueByHouse[$id]) ? (float) $revenueByHouse[$id] : 0.00;
        }

        return $data;
    }

    public function getTenantDemographics(array $filters): array
    {
        $tenantId = tenant()->id;
        $houseId = $filters['boarding_house_id'] ?? null;

        $residentsQuery = Resident::where('tenant_id', $tenantId)
            ->whereHas('contracts', function ($q) use ($houseId) {
                $q->where('status', 'active');
                if ($houseId) {
                    $q->where('boarding_house_id', $houseId);
                }
            });

        $genders = (clone $residentsQuery)
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get()
            ->pluck('total', 'gender')
            ->toArray();

        $occupations = (clone $residentsQuery)
            ->select('occupation', DB::raw('count(*) as total'))
            ->groupBy('occupation')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->pluck('total', 'occupation')
            ->toArray();

        return [
            'genders' => $genders,
            'occupations' => $occupations,
        ];
    }

    public function getMaintenanceIssues(array $filters): array
    {
        $tenantId = tenant()->id;
        $houseId = $filters['boarding_house_id'] ?? null;

        $issues = Complaint::where('tenant_id', $tenantId)
            ->when($houseId, function ($q) use ($houseId) {
                $q->where('boarding_house_id', $houseId);
            })
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'category')
            ->toArray();

        return $issues;
    }

    /**
     * Generates a coordinate points path string for premium inline SVGs.
     * Fits points inside $width x $height dimensions.
     */
    public function generateSVGCoordinates(array $dataPoints, int $width = 500, int $height = 150): array
    {
        if (empty($dataPoints)) {
            return ['points' => '', 'areaPoints' => ''];
        }

        $maxVal = max($dataPoints);
        if ($maxVal <= 0) {
            $maxVal = 1;
        }

        $count = count($dataPoints);
        $xOffset = $count > 1 ? $width / ($count - 1) : $width;

        $coords = [];
        $i = 0;
        foreach ($dataPoints as $key => $val) {
            $x = $i * $xOffset;
            // In SVGs, Y=0 is top. Subtract from height to place Y=0 at bottom.
            $y = $height - (($val / $maxVal) * ($height - 15)) - 10;
            $coords[] = "{$x},{$y}";
            $i++;
        }

        $pointsStr = implode(' ', $coords);
        
        // Build closed area polygon coordinates by drawing down to bottom corners
        $areaCoords = $coords;
        $areaCoords[] = ($width) . ",{$height}";
        $areaCoords[] = "0,{$height}";
        $areaPointsStr = implode(' ', $areaCoords);

        return [
            'points' => $pointsStr,
            'areaPoints' => $areaPointsStr,
            'maxVal' => $maxVal,
        ];
    }
}
