<?php

namespace App\Livewire\Room;

use App\Models\BoardingHouse;
use App\Models\Facility;
use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RoomList extends Component
{
    use WithPagination;

    // Search and Filters
    public string $search = '';
    public string $filterBoardingHouse = '';
    public string $filterStatus = '';
    public string $filterType = '';
    public string $filterFloor = '';
    public ?float $filterMinPrice = null;
    public ?float $filterMaxPrice = null;
    public array $filterFacilities = [];

    // Sorting
    public string $sortBy = 'room_number';
    public string $sortDir = 'asc';

    // Selection
    public array $selectedIds = [];
    public bool $selectAll = false;

    // Modals
    public bool $showDeleteModal = false;
    public ?string $deletingId = null;
    
    public bool $showBulkStatusModal = false;
    public string $bulkStatus = 'available';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterBoardingHouse' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterType' => ['except' => ''],
        'filterFloor' => ['except' => ''],
        'filterMinPrice' => ['except' => null],
        'filterMaxPrice' => ['except' => null],
        'sortBy' => ['except' => 'room_number'],
        'sortDir' => ['except' => 'asc'],
    ];

    public function mount(): void
    {
        if (!Auth::user()->can('viewAny', Room::class)) {
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

    public function updatedFilterType(): void
    {
        $this->resetPage();
    }

    public function updatedFilterFloor(): void
    {
        $this->resetPage();
    }

    public function updatedFilterMinPrice(): void
    {
        $this->resetPage();
    }

    public function updatedFilterMaxPrice(): void
    {
        $this->resetPage();
    }

    public function updatedFilterFacilities(): void
    {
        $this->resetPage();
    }

    public function updatedSelectAll(bool $value): void
    {
        if ($value) {
            $this->selectedIds = Room::pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedIds = [];
        }
    }

    public function setSort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }

    public function confirmDelete(string $id): void
    {
        $room = Room::findOrFail($id);
        if (Auth::user()->cannot('delete', $room)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Unauthorized action or occupied room.']);
            return;
        }

        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteRoom(RoomService $service): void
    {
        if ($this->deletingId) {
            $room = Room::findOrFail($this->deletingId);

            if (Auth::user()->cannot('delete', $room)) {
                $this->dispatch('toast', ['type' => 'error', 'message' => 'Unauthorized action.']);
                return;
            }

            try {
                $service->deleteRoom($room);
                $this->dispatch('toast', ['type' => 'success', 'message' => 'Room deleted successfully.']);
            } catch (\Exception $e) {
                $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
            }

            $this->showDeleteModal = false;
            $this->deletingId = null;
        }
    }

    // Bulk Actions
    public function triggerBulkStatus(): void
    {
        if (empty($this->selectedIds)) {
            $this->dispatch('toast', ['type' => 'warning', 'message' => 'Please select rooms first.']);
            return;
        }
        $this->showBulkStatusModal = true;
    }

    public function applyBulkStatus(RoomService $service): void
    {
        $updated = $service->bulkUpdateStatus($this->selectedIds, $this->bulkStatus);
        
        $this->showBulkStatusModal = false;
        $this->selectedIds = [];
        $this->selectAll = false;

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => "Successfully updated {$updated} rooms status to: {$this->bulkStatus}.",
        ]);
    }

    public function applyBulkDelete(RoomService $service): void
    {
        if (empty($this->selectedIds)) {
            $this->dispatch('toast', ['type' => 'warning', 'message' => 'Please select rooms first.']);
            return;
        }

        $deleted = $service->bulkDelete($this->selectedIds);

        $this->selectedIds = [];
        $this->selectAll = false;

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => "Successfully deleted {$deleted} rooms. Occupied rooms were bypassed.",
        ]);
    }

    public function exportSelected(RoomService $service)
    {
        if (empty($this->selectedIds)) {
            $this->dispatch('toast', ['type' => 'warning', 'message' => 'Please select rooms first.']);
            return;
        }

        $csv = $service->bulkExportCsv($this->selectedIds);
        $fileName = 'rooms-export-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function render()
    {
        $query = Room::with('boardingHouse', 'facilities')
            ->when($this->search, function ($q) {
                $q->where(function($sq) {
                    $sq->where('room_number', 'like', '%' . $this->search . '%')
                       ->orWhere('room_name', 'like', '%' . $this->search . '%')
                       ->orWhere('room_code', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterBoardingHouse, function ($q) {
                $q->where('boarding_house_id', $this->filterBoardingHouse);
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->when($this->filterType, function ($q) {
                $q->where('room_type', $this->filterType);
            })
            ->when($this->filterFloor, function ($q) {
                $q->where('floor', $this->filterFloor);
            })
            ->when($this->filterMinPrice, function ($q) {
                $q->where('monthly_rent', '>=', $this->filterMinPrice);
            })
            ->when($this->filterMaxPrice, function ($q) {
                $q->where('monthly_rent', '<=', $this->filterMaxPrice);
            })
            ->when(!empty($this->filterFacilities), function ($q) {
                foreach ($this->filterFacilities as $facId) {
                    $q->whereHas('facilities', function($fq) use ($facId) {
                        $fq->where('facility_id', $facId);
                    });
                }
            })
            ->orderBy($this->sortBy, $this->sortDir);

        // Stats calculation
        $totalCount = Room::count();
        $availableCount = Room::where('status', 'available')->count();
        $occupiedCount = Room::where('status', 'occupied')->count();
        $reservedCount = Room::where('status', 'reserved')->count();
        $maintenanceCount = Room::where('status', 'maintenance')->count();
        
        $occupancyRate = $totalCount > 0 ? round(($occupiedCount / $totalCount) * 100, 1) : 0;
        $monthlyRevenuePotential = Room::sum('monthly_rent');
        $currentRevenue = Room::where('status', 'occupied')->sum('monthly_rent');

        // Dropdown filter items
        $boardingHouses = BoardingHouse::all();
        $allFacilities = Facility::forCurrentTenant()->where('is_active', true)->get();

        return view('livewire.room.room-list', [
            'rooms' => $query->paginate(10),
            'totalCount' => $totalCount,
            'availableCount' => $availableCount,
            'occupiedCount' => $occupiedCount,
            'reservedCount' => $reservedCount,
            'maintenanceCount' => $maintenanceCount,
            'occupancyRate' => $occupancyRate,
            'monthlyRevenuePotential' => $monthlyRevenuePotential,
            'currentRevenue' => $currentRevenue,
            'boardingHouses' => $boardingHouses,
            'allFacilities' => $allFacilities,
        ])->layout('layouts.app');
    }
}
