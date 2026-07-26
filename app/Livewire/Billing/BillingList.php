<?php

namespace App\Livewire\Billing;

use App\Models\BoardingHouse;
use App\Models\Contract;
use App\Models\Invoice;
use App\Services\BillingService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BillingList extends Component
{
    use WithPagination;

    // Search & filters
    public string $search = '';
    public string $filterBoardingHouse = '';
    public string $filterStatus = '';
    public string $filterStartDate = '';
    public string $filterEndDate = '';

    // Bulk Generator Wizard parameters
    public bool $showBulkModal = false;
    public string $bulkBoardingHouseId = '';
    public string $bulkPeriodStart = '';
    public string $bulkPeriodEnd = '';
    public string $bulkDueDate = '';
    public array $bulkPreviews = []; // Array of arrays containing preview records

    // Delete parameters
    public bool $showDeleteModal = false;
    public ?string $deletingId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterBoardingHouse' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterStartDate' => ['except' => ''],
        'filterEndDate' => ['except' => ''],
    ];

    public function mount(): void
    {
        if (!Auth::user()->can('viewAny', Invoice::class)) {
            abort(403, 'Unauthorized.');
        }

        $firstHouse = BoardingHouse::first();
        if ($firstHouse) {
            $this->bulkBoardingHouseId = $firstHouse->id;
        }
        $this->bulkPeriodStart = date('Y-m-01');
        $this->bulkPeriodEnd = date('Y-m-t');
        $this->bulkDueDate = date('Y-m-10');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterBoardingHouse(): void
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

    public function openBulkModal(): void
    {
        $this->showBulkModal = true;
        $this->previewBulkGeneration();
    }

    public function previewBulkGeneration(): void
    {
        if (empty($this->bulkBoardingHouseId) || empty($this->bulkPeriodStart) || empty($this->bulkPeriodEnd)) {
            $this->bulkPreviews = [];
            return;
        }

        // Query active contracts in selected boarding house that don't already have an invoice for this period
        $contracts = Contract::with(['room', 'resident'])
            ->where('boarding_house_id', $this->bulkBoardingHouseId)
            ->where('status', 'active')
            ->whereDoesntHave('invoices', function ($q) {
                $q->where('billing_period_start', $this->bulkPeriodStart)
                  ->where('billing_period_end', $this->bulkPeriodEnd);
            })
            ->get();

        $this->bulkPreviews = [];
        foreach ($contracts as $ctr) {
            $this->bulkPreviews[] = [
                'contract_id' => $ctr->id,
                'contract_number' => $ctr->contract_number,
                'resident_name' => $ctr->resident->name,
                'room_number' => $ctr->room ? $ctr->room->room_number : '-',
                'monthly_rent' => $ctr->monthly_rent,
            ];
        }
    }

    public function generateBulkInvoices(BillingService $service): void
    {
        if (empty($this->bulkPreviews)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'No invoices available to generate.']);
            return;
        }

        $this->validate([
            'bulkBoardingHouseId' => ['required', 'uuid', 'exists:boarding_houses,id'],
            'bulkPeriodStart' => ['required', 'date'],
            'bulkPeriodEnd' => ['required', 'date', 'after:bulkPeriodStart'],
            'bulkDueDate' => ['required', 'date'],
        ]);

        $successCount = 0;
        $errorCount = 0;

        foreach ($this->bulkPreviews as $preview) {
            try {
                $contract = Contract::findOrFail($preview['contract_id']);
                $service->createInvoiceFromContract(
                    contract: $contract,
                    periodStart: $this->bulkPeriodStart,
                    periodEnd: $this->bulkPeriodEnd,
                    dueDate: $this->bulkDueDate
                );
                $successCount++;
            } catch (\Exception $e) {
                $errorCount++;
            }
        }

        $this->showBulkModal = false;
        $this->dispatch('toast', [
            'type' => 'success', 
            'message' => "Bulk billing completed! Generated {$successCount} invoices." . ($errorCount > 0 ? " Failed: {$errorCount} invoices." : "")
        ]);
        $this->resetPage();
    }

    public function confirmDelete(string $id): void
    {
        $invoice = Invoice::findOrFail($id);

        if (Auth::user()->cannot('delete', $invoice)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Only draft or cancelled/voided invoices can be deleted.']);
            return;
        }

        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteInvoice(BillingService $service): void
    {
        if ($this->deletingId) {
            $invoice = Invoice::findOrFail($this->deletingId);

            if (Auth::user()->cannot('delete', $invoice)) {
                $this->dispatch('toast', ['type' => 'error', 'message' => 'Unauthorized action.']);
                return;
            }

            try {
                $service->deleteInvoice($invoice);
                $this->dispatch('toast', ['type' => 'success', 'message' => 'Invoice deleted successfully.']);
            } catch (\Exception $e) {
                $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
            }

            $this->showDeleteModal = false;
            $this->deletingId = null;
        }
    }

    public function render()
    {
        $query = Invoice::with(['boardingHouse', 'room', 'resident', 'contract'])
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('invoice_number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('resident', function ($rq) {
                            $rq->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('room', function ($rq) {
                            $rq->where('room_number', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('boardingHouse', function ($rq) {
                            $rq->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filterBoardingHouse, function ($q) {
                $q->where('boarding_house_id', $this->filterBoardingHouse);
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->when($this->filterStartDate, function ($q) {
                $q->whereDate('invoice_date', '>=', $this->filterStartDate);
            })
            ->when($this->filterEndDate, function ($q) {
                $q->whereDate('invoice_date', '<=', $this->filterEndDate);
            });

        // Dashboard Metrics (filtered to active workspace scope, cached for 60 seconds)
        $tenantId = tenant() ? tenant()->id : 'global';
        $metrics = cache()->remember("billing_metrics:{$tenantId}", 60, function () {
            return [
                'revenueTotal' => Invoice::where('status', 'paid')->sum('grand_total'),
                'outstandingTotal' => Invoice::whereIn('status', ['pending', 'sent', 'viewed'])->sum('grand_total'),
                'overdueTotal' => Invoice::where('status', 'overdue')->sum('grand_total'),
                'paidCountThisMonth' => Invoice::where('status', 'paid')
                    ->whereMonth('invoice_date', date('m'))
                    ->whereYear('invoice_date', date('Y'))
                    ->count(),
                'pendingPaymentsCount' => Invoice::whereIn('status', ['pending', 'sent', 'viewed'])->count(),
                'penaltyCollected' => Invoice::where('status', 'paid')->sum('penalty'),
            ];
        });

        $boardingHouses = BoardingHouse::all();

        return view('livewire.billing.billing-list', [
            'invoices' => $query->latest()->paginate(10),
            'revenueTotal' => $metrics['revenueTotal'],
            'outstandingTotal' => $metrics['outstandingTotal'],
            'overdueTotal' => $metrics['overdueTotal'],
            'paidCountThisMonth' => $metrics['paidCountThisMonth'],
            'pendingPaymentsCount' => $metrics['pendingPaymentsCount'],
            'penaltyCollected' => $metrics['penaltyCollected'],
            'boardingHouses' => $boardingHouses,
        ])->layout('layouts.app');
    }
}
