<?php

namespace App\Livewire\Contract;

use App\Models\BoardingHouse;
use App\Models\Contract;
use App\Services\ContractService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ContractList extends Component
{
    use WithPagination;

    // Search and Filters
    public string $search = '';
    public string $filterBoardingHouse = '';
    public string $filterStatus = '';
    public string $filterStartDate = '';
    public string $filterEndDate = '';

    // Deletes
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
        if (!Auth::user()->can('viewAny', Contract::class)) {
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

    public function confirmDelete(string $id): void
    {
        $contract = Contract::findOrFail($id);

        if (Auth::user()->cannot('delete', $contract)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Only draft or cancelled contracts can be deleted.']);
            return;
        }

        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteContract(ContractService $service): void
    {
        if ($this->deletingId) {
            $contract = Contract::findOrFail($this->deletingId);

            if (Auth::user()->cannot('delete', $contract)) {
                $this->dispatch('toast', ['type' => 'error', 'message' => 'Unauthorized action.']);
                return;
            }

            try {
                $service->deleteContract($contract);
                $this->dispatch('toast', ['type' => 'success', 'message' => 'Contract draft deleted.']);
            } catch (\Exception $e) {
                $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
            }

            $this->showDeleteModal = false;
            $this->deletingId = null;
        }
    }

    public function render()
    {
        $query = Contract::with(['boardingHouse', 'room', 'resident'])
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('contract_number', 'like', '%' . $this->search . '%')
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
                $q->whereDate('start_date', '>=', $this->filterStartDate);
            })
            ->when($this->filterEndDate, function ($q) {
                $q->whereDate('end_date', '<=', $this->filterEndDate);
            });

        // Analytics metrics
        $totalCount = Contract::count();
        $draftCount = Contract::where('status', 'draft')->count();
        $activeCount = Contract::where('status', 'active')->count();
        $expiringCount = Contract::where('status', 'expiring_soon')->count();
        $expiredCount = Contract::where('status', 'expired')->count();
        
        $revenue = Contract::where('status', 'active')->sum('monthly_rent');
        $avgDuration = round(Contract::avg('duration_months') ?? 0, 1);

        $boardingHouses = BoardingHouse::all();

        return view('livewire.contract.contract-list', [
            'contracts' => $query->latest()->paginate(10),
            'totalCount' => $totalCount,
            'draftCount' => $draftCount,
            'activeCount' => $activeCount,
            'expiringCount' => $expiringCount,
            'expiredCount' => $expiredCount,
            'revenue' => $revenue,
            'avgDuration' => $avgDuration,
            'boardingHouses' => $boardingHouses,
        ])->layout('layouts.app');
    }
}
