<?php

namespace App\Livewire\Complaint;

use App\Models\BoardingHouse;
use App\Models\Complaint;
use App\Models\Resident;
use App\Models\Room;
use App\Services\ComplaintService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ComplaintList extends Component
{
    use WithPagination;

    // Search and filters
    public string $search = '';
    public string $filterBoardingHouse = '';
    public string $filterCategory = '';
    public string $filterPriority = '';
    public string $filterStatus = '';

    // View toggle (table or kanban)
    public string $viewMode = 'table'; 

    // Create Complaint Modal fields
    public bool $showCreateModal = false;
    public string $boarding_house_id = '';
    public string $room_id = '';
    public string $resident_id = '';
    public string $category = 'electricity';
    public string $priority = 'normal';
    public string $subject = '';
    public string $description = '';
    public string $internal_notes = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterBoardingHouse' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterPriority' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'viewMode' => ['except' => 'table'],
    ];

    public function mount(): void
    {
        if (!Auth::user()->can('viewAny', Complaint::class)) {
            abort(403, 'Unauthorized.');
        }

        $firstHouse = BoardingHouse::first();
        if ($firstHouse) {
            $this->boarding_house_id = $firstHouse->id;
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

    public function updatedFilterCategory(): void
    {
        $this->resetPage();
    }

    public function updatedFilterPriority(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function toggleViewMode(string $mode): void
    {
        $this->viewMode = $mode;
    }

    public function updatedResidentId(): void
    {
        if ($this->resident_id) {
            $res = Resident::find($this->resident_id);
            if ($res) {
                $this->room_id = $res->room_id ?? '';
                $this->boarding_house_id = $res->boarding_house_id ?? '';
            }
        }
    }

    public function openCreateModal(): void
    {
        $this->showCreateModal = true;
    }

    public function storeComplaint(ComplaintService $service): void
    {
        $this->validate([
            'boarding_house_id' => ['required', 'uuid', 'exists:boarding_houses,id'],
            'room_id' => ['required', 'uuid', 'exists:rooms,id'],
            'resident_id' => ['required', 'uuid', 'exists:residents,id'],
            'category' => ['required', 'string', 'in:electricity,water,bathroom,ac,internet,furniture,door,roof,kitchen,security,cleaning,other'],
            'priority' => ['required', 'string', 'in:low,normal,high,critical,emergency'],
            'subject' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:1000'],
            'internal_notes' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $complaint = $service->createComplaint([
                'tenant_id' => tenant()->id,
                'boarding_house_id' => $this->boarding_house_id,
                'room_id' => $this->room_id,
                'resident_id' => $this->resident_id,
                'category' => $this->category,
                'priority' => $this->priority,
                'subject' => $this->subject,
                'description' => $this->description,
                'internal_notes' => $this->internal_notes,
            ]);

            $this->showCreateModal = false;
            $this->reset(['subject', 'description', 'internal_notes']);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'New complaint case registered successfully!']);
            $this->resetPage();
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        $query = Complaint::with(['boardingHouse', 'room', 'resident', 'maintenanceTask'])
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('complaint_number', 'like', '%' . $this->search . '%')
                        ->orWhere('subject', 'like', '%' . $this->search . '%')
                        ->orWhereHas('resident', function ($rq) {
                            $rq->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('room', function ($rq) {
                            $rq->where('room_number', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filterBoardingHouse, function ($q) {
                $q->where('boarding_house_id', $this->filterBoardingHouse);
            })
            ->when($this->filterCategory, function ($q) {
                $q->where('category', $this->filterCategory);
            })
            ->when($this->filterPriority, function ($q) {
                $q->where('priority', $this->filterPriority);
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            });

        // Metrics calculators
        $openCount = Complaint::whereIn('status', ['open', 'reviewed'])->count();
        $highPriorityCount = Complaint::whereIn('priority', ['high', 'critical', 'emergency'])
            ->where('status', '!=', 'closed')
            ->count();
        $inProgressCount = Complaint::where('status', 'in_progress')->count();
        $completedCount = Complaint::where('status', 'completed')->count();

        $boardingHouses = BoardingHouse::all();
        $residents = Resident::orderBy('name')->get();
        
        $availableRooms = Room::where('boarding_house_id', $this->boarding_house_id)->orderBy('room_number')->get();

        // For Kanban View
        $kanbanComplaints = [];
        if ($this->viewMode === 'kanban') {
            $allComplaints = (clone $query)->get();
            $kanbanComplaints = [
                'open' => $allComplaints->filter(fn($c) => in_array($c->status->value, ['open', 'reviewed'])),
                'assigned' => $allComplaints->filter(fn($c) => in_array($c->status->value, ['assigned', 'waiting_parts'])),
                'in_progress' => $allComplaints->filter(fn($c) => $c->status->value === 'in_progress'),
                'completed' => $allComplaints->filter(fn($c) => in_array($c->status->value, ['completed', 'verified', 'closed'])),
            ];
        }

        return view('livewire.complaint.complaint-list', [
            'complaints' => $query->latest()->paginate(10),
            'openCount' => $openCount,
            'highPriorityCount' => $highPriorityCount,
            'inProgressCount' => $inProgressCount,
            'completedCount' => $completedCount,
            'boardingHouses' => $boardingHouses,
            'residents' => $residents,
            'availableRooms' => $availableRooms,
            'kanbanComplaints' => $kanbanComplaints,
        ])->layout('layouts.app');
    }
}
