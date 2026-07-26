<?php

namespace App\Livewire\Announcement;

use App\Enums\AnnouncementStatus;
use App\Models\BoardingHouse;
use App\Models\Announcement;
use App\Models\AnnouncementReadReceipt;
use App\Models\Resident;
use App\Models\Room;
use App\Services\AnnouncementService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AnnouncementList extends Component
{
    use WithPagination, WithFileUploads;

    // Search and filters
    public string $search = '';
    public string $filterCategory = '';
    public string $filterPriority = '';
    public string $filterStatus = '';

    // Create Modal fields
    public bool $showCreateModal = false;
    
    public string $title = '';
    public string $summary = '';
    public string $content = '';
    public string $category = 'general';
    public string $priority = 'normal';
    
    public string $targetType = 'all'; // all, boarding_house, floor, room, selected_tenants
    public ?string $boarding_house_id = null;
    public array $selectedFloors = [];
    public array $selectedRooms = [];
    public array $selectedResidents = [];

    public string $publishOption = 'now'; // now, later
    public ?string $publishAtDate = null;
    public ?string $expiresAtDate = null;
    public bool $isPinned = false;
    public $attachmentFile = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterPriority' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function mount(): void
    {
        if (!Auth::user()->can('viewAny', Announcement::class)) {
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

    public function openCreateModal(): void
    {
        $this->showCreateModal = true;
    }

    public function storeAnnouncement(AnnouncementService $service): void
    {
        $rules = [
            'title' => ['required', 'string', 'max:150'],
            'summary' => ['nullable', 'string', 'max:250'],
            'content' => ['required', 'string', 'max:5000'],
            'category' => ['required', 'string', 'in:general,maintenance,water_shutdown,cleaning,rent_reminder,emergency,holiday,promotional,other'],
            'priority' => ['required', 'string', 'in:low,normal,important,high,emergency'],
            'targetType' => ['required', 'string', 'in:all,boarding_house,floor,room,selected_tenants'],
            'boarding_house_id' => ['nullable', 'required_if:targetType,boarding_house', 'exists:boarding_houses,id'],
            'selectedFloors' => ['nullable', 'array'],
            'selectedRooms' => ['nullable', 'array'],
            'selectedResidents' => ['nullable', 'array'],
            'publishOption' => ['required', 'string', 'in:now,later'],
            'publishAtDate' => ['nullable', 'required_if:publishOption,later', 'date', 'after_or_equal:today'],
            'expiresAtDate' => ['nullable', 'date', 'after:publishAtDate'],
            'attachmentFile' => ['nullable', 'file', 'max:5120'], // Max 5MB file
        ];

        $this->validate($rules);

        try {
            $attachmentPath = null;
            $attachmentName = null;
            if ($this->attachmentFile) {
                $attachmentPath = $this->attachmentFile->store('announcements', 'public');
                $attachmentName = $this->attachmentFile->getClientOriginalName();
            }

            $filters = [];
            if ($this->targetType === 'floor') {
                $filters['floors'] = array_map('intval', $this->selectedFloors);
            } elseif ($this->targetType === 'room') {
                $filters['rooms'] = $this->selectedRooms;
            } elseif ($this->targetType === 'selected_tenants') {
                $filters['residents'] = $this->selectedResidents;
            }

            $publishAt = $this->publishOption === 'now' ? now() : $this->publishAtDate;

            $status = AnnouncementStatus::PUBLISHED;
            if ($this->publishOption === 'later') {
                $status = AnnouncementStatus::SCHEDULED;
            }

            $service->createAnnouncement([
                'tenant_id' => tenant()->id,
                'boarding_house_id' => $this->boarding_house_id,
                'title' => $this->title,
                'summary' => $this->summary,
                'content' => $this->content,
                'category' => $this->category,
                'priority' => $this->priority,
                'status' => $status,
                'target_type' => $this->targetType,
                'target_filters' => $filters,
                'publish_at' => $publishAt,
                'expires_at' => $this->expiresAtDate,
                'pinned_at' => $this->isPinned ? now() : null,
                'author_id' => Auth::id(),
                'attachment_path' => $attachmentPath,
                'attachment_name' => $attachmentName,
            ]);

            $this->showCreateModal = false;
            $this->reset([
                'title', 'summary', 'content', 'category', 'priority', 
                'targetType', 'selectedFloors', 'selectedRooms', 
                'selectedResidents', 'publishOption', 'publishAtDate', 
                'expiresAtDate', 'isPinned', 'attachmentFile'
            ]);

            $this->dispatch('toast', ['type' => 'success', 'message' => 'Announcement posted and broadcasted successfully!']);
            $this->resetPage();
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        $query = Announcement::with(['boardingHouse', 'author'])
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('content', 'like', '%' . $this->search . '%')
                        ->orWhere('announcement_number', 'like', '%' . $this->search . '%');
                });
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

        // Metrics Calculators
        $publishedCount = Announcement::where('status', AnnouncementStatus::PUBLISHED)->count();
        $scheduledCount = Announcement::where('status', AnnouncementStatus::SCHEDULED)->count();
        $draftCount = Announcement::where('status', AnnouncementStatus::DRAFT)->count();

        $receipts = AnnouncementReadReceipt::count();
        $read = AnnouncementReadReceipt::whereNotNull('read_at')->count();
        $readRate = $receipts > 0 ? round(($read / $receipts) * 100, 1) : 0;

        $boardingHouses = BoardingHouse::all();
        $residents = Resident::orderBy('name')->get();
        $rooms = Room::where('boarding_house_id', $this->boarding_house_id)->orderBy('room_number')->get();

        return view('livewire.announcement.announcement-list', [
            'announcements' => $query->latest()->paginate(10),
            'publishedCount' => $publishedCount,
            'scheduledCount' => $scheduledCount,
            'draftCount' => $draftCount,
            'readRate' => $readRate,
            'boardingHouses' => $boardingHouses,
            'residents' => $residents,
            'rooms' => $rooms,
        ])->layout('layouts.app');
    }
}
