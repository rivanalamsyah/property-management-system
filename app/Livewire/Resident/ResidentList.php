<?php

namespace App\Livewire\Resident;

use App\Models\BoardingHouse;
use App\Models\Resident;
use App\Models\Room;
use App\Services\ResidentService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ResidentList extends Component
{
    use WithPagination;

    // Filters & Search
    public string $search = '';
    public string $filterBoardingHouse = '';
    public string $filterStatus = '';

    // Deletes
    public bool $showDeleteModal = false;
    public ?string $deletingId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterBoardingHouse' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function mount(): void
    {
        if (!Auth::user()->can('viewAny', Resident::class)) {
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

    public function confirmDelete(string $id): void
    {
        $resident = Resident::findOrFail($id);
        
        if (Auth::user()->cannot('delete', $resident)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Active residents cannot be deleted. Checkout first.']);
            return;
        }

        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteResident(ResidentService $service): void
    {
        if ($this->deletingId) {
            $resident = Resident::findOrFail($this->deletingId);

            if (Auth::user()->cannot('delete', $resident)) {
                $this->dispatch('toast', ['type' => 'error', 'message' => 'Unauthorized action.']);
                return;
            }

            try {
                $service->deleteResident($resident);
                $this->dispatch('toast', ['type' => 'success', 'message' => 'Resident record deleted.']);
            } catch (\Exception $e) {
                $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
            }

            $this->showDeleteModal = false;
            $this->deletingId = null;
        }
    }

    public function render()
    {
        $query = Resident::with('boardingHouse', 'room')
            ->when($this->search, function ($q) {
                $q->where(function($sq) {
                    $sq->where('name', 'like', '%' . $this->search . '%')
                       ->orWhere('nik', 'like', '%' . $this->search . '%')
                       ->orWhere('phone', 'like', '%' . $this->search . '%')
                       ->orWhere('whatsapp', 'like', '%' . $this->search . '%')
                       ->orWhere('email', 'like', '%' . $this->search . '%')
                       ->orWhereHas('room', function($rq) {
                           $rq->where('room_number', 'like', '%' . $this->search . '%');
                       });
                });
            })
            ->when($this->filterBoardingHouse, function ($q) {
                $q->where('boarding_house_id', $this->filterBoardingHouse);
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            });

        // Analytics
        $totalCount = Resident::count();
        $activeCount = Resident::where('status', 'active')->count();
        $formerCount = Resident::where('status', 'former')->count();
        $reservedCount = Resident::where('status', 'reserved')->count();
        $movingOutCount = Resident::where('status', 'moving_out')->count();
        $latePaymentCount = Resident::where('status', 'late_payment')->count();

        // Room Occupancy calculations
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0;

        // Average Stay Duration calculations (Former Tenants)
        $formerResidents = Resident::where('status', 'former')
            ->whereNotNull('check_in_date')
            ->whereNotNull('check_out_date')
            ->get();

        $avgStay = 0;
        if ($formerResidents->count() > 0) {
            $totalDays = $formerResidents->sum(function($r) {
                return $r->check_in_date->diffInDays($r->check_out_date);
            });
            $avgStay = round($totalDays / $formerResidents->count()); // Average stay in days
        }

        $boardingHouses = BoardingHouse::all();

        return view('livewire.resident.resident-list', [
            'residents' => $query->latest()->paginate(10),
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'formerCount' => $formerCount,
            'reservedCount' => $reservedCount,
            'movingOutCount' => $movingOutCount,
            'latePaymentCount' => $latePaymentCount,
            'occupancyRate' => $occupancyRate,
            'avgStay' => $avgStay,
            'boardingHouses' => $boardingHouses,
        ])->layout('layouts.app');
    }
}
