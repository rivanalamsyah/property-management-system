<?php

namespace App\Livewire\Analytics;

use App\Models\BoardingHouse;
use App\Models\SavedReport;
use App\Services\AnalyticsService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AnalyticsDashboard extends Component
{
    public string $boarding_house_id = '';
    public string $year = '';
    public string $activeTab = 'financials'; // financials, occupancy, tenants, maintenance

    // Save report form
    public string $reportName = '';
    public string $reportDescription = '';
    public bool $showSaveModal = false;

    protected $queryString = [
        'boarding_house_id' => ['except' => ''],
        'year' => ['except' => ''],
        'activeTab' => ['except' => 'financials'],
    ];

    public function mount(): void
    {
        $this->year = date('Y');
    }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function exportCSV(AnalyticsService $service)
    {
        $filters = [
            'boarding_house_id' => $this->boarding_house_id,
            'year' => $this->year,
        ];

        $data = $service->getMonthlyRevenueTrend($filters);
        
        $csvHeader = ['Month', 'Revenue (IDR)'];
        $csvData = [];
        foreach ($data as $month => $val) {
            $csvData[] = [$month, $val];
        }

        $callback = function () use ($csvHeader, $csvData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        $fileName = 'revenue-report-' . date('Y-m-d') . '.csv';
        return response()->streamDownload($callback, $fileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    public function saveCurrentReport(): void
    {
        $this->validate([
            'reportName' => ['required', 'string', 'max:100'],
            'reportDescription' => ['nullable', 'string', 'max:250'],
        ]);

        try {
            SavedReport::create([
                'tenant_id' => tenant()->id,
                'name' => $this->reportName,
                'description' => $this->reportDescription,
                'report_type' => $this->activeTab,
                'filters' => [
                    'boarding_house_id' => $this->boarding_house_id,
                    'year' => $this->year,
                ],
                'user_id' => Auth::id(),
            ]);

            $this->showSaveModal = false;
            $this->reset(['reportName', 'reportDescription']);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Report filters saved to presets successfully!']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function render(AnalyticsService $service)
    {
        $filters = [
            'boarding_house_id' => $this->boarding_house_id,
            'year' => $this->year,
        ];

        // Fetch aggregation calculations
        $kpis = $service->getKPIs($filters);
        $revenueTrend = $service->getMonthlyRevenueTrend($filters);
        $propertyRevenues = $service->getRevenueByProperty($filters);
        $demographics = $service->getTenantDemographics($filters);
        $maintenanceIssues = $service->getMaintenanceIssues($filters);

        // SVG Coordinate mapping
        $svgCoords = $service->generateSVGCoordinates(array_values($revenueTrend));

        $boardingHouses = BoardingHouse::all();

        return view('livewire.analytics.analytics-dashboard', [
            'kpis' => $kpis,
            'revenueTrend' => $revenueTrend,
            'propertyRevenues' => $propertyRevenues,
            'demographics' => $demographics,
            'maintenanceIssues' => $maintenanceIssues,
            'svgCoords' => $svgCoords,
            'boardingHouses' => $boardingHouses,
        ])->layout('layouts.app');
    }
}
