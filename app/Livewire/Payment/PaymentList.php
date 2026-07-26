<?php

namespace App\Livewire\Payment;

use App\Models\BoardingHouse;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentList extends Component
{
    use WithPagination;

    // Search and filters
    public string $search = '';
    public string $filterBoardingHouse = '';
    public string $filterMethod = '';
    public string $filterStatus = '';
    public string $filterStartDate = '';
    public string $filterEndDate = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterBoardingHouse' => ['except' => ''],
        'filterMethod' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterStartDate' => ['except' => ''],
        'filterEndDate' => ['except' => ''],
    ];

    public function mount(): void
    {
        if (!Auth::user()->can('viewAny', Payment::class)) {
            abort(403, 'Unauthorized.');
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterBoardingHouse(): void
    {
        $this->resetPage();
    }

    public function updatedFilterMethod(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStartDate(): void
    {
        $this->resetPage();
    }

    public function updatedFilterEndDate(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Payment::with(['boardingHouse', 'resident', 'invoice', 'contract'])
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('transaction_number', 'like', '%' . $this->search . '%')
                        ->orWhere('reference_number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('resident', function ($rq) {
                            $rq->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('boardingHouse', function ($rq) {
                            $rq->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('invoice', function ($iq) {
                            $iq->where('invoice_number', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filterBoardingHouse, function ($q) {
                $q->where('boarding_house_id', $this->filterBoardingHouse);
            })
            ->when($this->filterMethod, function ($q) {
                $q->where('payment_method', $this->filterMethod);
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->when($this->filterStartDate, function ($q) {
                $q->whereDate('payment_date', '>=', $this->filterStartDate);
            })
            ->when($this->filterEndDate, function ($q) {
                $q->whereDate('payment_date', '<=', $this->filterEndDate);
            });

        // Dashboard Metrics (filtered to active tenant)
        $totalPayments = Payment::where('status', 'completed')->sum('amount_paid');
        $todayPayments = Payment::where('status', 'completed')
            ->whereDate('payment_date', date('Y-m-d'))
            ->sum('amount_paid');
        $monthlyRevenue = Payment::where('status', 'completed')
            ->whereMonth('payment_date', date('m'))
            ->whereYear('payment_date', date('Y'))
            ->sum('amount_paid');

        $pendingVerificationCount = Payment::where('status', 'waiting_verification')->count();
        $failedCount = Payment::where('status', 'failed')->count();
        $outstandingBalance = Invoice::whereIn('status', ['pending', 'sent', 'viewed', 'overdue'])->sum('grand_total');

        $collectionRate = 0;
        $totalBilled = $totalPayments + $outstandingBalance;
        if ($totalBilled > 0) {
            $collectionRate = round(($totalPayments / $totalBilled) * 100, 1);
        }

        $boardingHouses = BoardingHouse::all();

        return view('livewire.payment.payment-list', [
            'payments' => $query->latest()->paginate(10),
            'totalPayments' => $totalPayments,
            'todayPayments' => $todayPayments,
            'monthlyRevenue' => $monthlyRevenue,
            'pendingVerificationCount' => $pendingVerificationCount,
            'failedCount' => $failedCount,
            'outstandingBalance' => $outstandingBalance,
            'collectionRate' => $collectionRate,
            'boardingHouses' => $boardingHouses,
        ])->layout('layouts.app');
    }
}
