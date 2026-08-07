<?php

namespace App\Livewire\BoardingHouse;

use App\Models\BoardingHouse;
use App\Services\BoardingHouseService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BoardingHouseList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';
    public string $filterCity = '';

    public bool $showDeleteModal = false;
    public ?string $deletingId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterCity' => ['except' => ''],
    ];

    public function mount(): void
    {
        if (!Auth::user()->can('viewAny', BoardingHouse::class)) {
            abort(403, 'Unauthorized.');
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatedFilterCity(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(string $id): void
    {
        $boardingHouse = BoardingHouse::findOrFail($id);
        
        if (Auth::user()->cannot('delete', $boardingHouse)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Only the owner can delete boarding houses.']);
            return;
        }

        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteBoardingHouse(BoardingHouseService $service): void
    {
        if ($this->deletingId) {
            $boardingHouse = BoardingHouse::findOrFail($this->deletingId);
            
            if (Auth::user()->cannot('delete', $boardingHouse)) {
                $this->dispatch('toast', ['type' => 'error', 'message' => 'Unauthorized action.']);
                return;
            }

            $service->deleteBoardingHouse($boardingHouse);

            $this->showDeleteModal = false;
            $this->deletingId = null;

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Boarding house deleted successfully.',
            ]);
        }
    }

    public function render()
    {
        $query = BoardingHouse::withCount(['facilities', 'rules', 'galleries'])
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->when($this->filterCity, function ($q) {
                $q->where('city', 'like', '%' . $this->filterCity . '%');
            });

        // Summary calculations
        $totalCount = BoardingHouse::count();
        $activeCount = BoardingHouse::where('status', 'active')->count();
        $fullCount = BoardingHouse::where('status', 'full')->count();
        $inactiveCount = BoardingHouse::where('status', 'inactive')->count();

        // Get unique cities for filter dropdown
        $cities = BoardingHouse::select('city')
            ->distinct()
            ->whereNotNull('city')
            ->orderBy('city')
            ->pluck('city')
            ->toArray();

        return view('livewire.boarding-house.boarding-house-list', [
            'boardingHouses' => $query->latest()->paginate(10),
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'fullCount' => $fullCount,
            'inactiveCount' => $inactiveCount,
            'cities' => $cities,
        ])->layout('layouts.app');
    }
}
