<?php

namespace App\Livewire\Room;

use App\Models\BoardingHouse;
use App\Models\Facility;
use App\Models\Room;
use App\Models\RoomImage;
use App\Services\RoomService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class RoomForm extends Component
{
    use WithFileUploads;

    public ?string $roomId = null;
    public string $activeTab = 'profile';

    // Room Fields
    public string $boarding_house_id = '';
    public string $room_number = '';
    public string $room_name = '';
    public int $floor = 1;
    public string $building_block = '';
    public string $room_type = 'Standard';
    public float $monthly_rent = 1000000.00;
    public float $security_deposit = 0.00;
    public string $room_size = '';
    public int $max_occupants = 1;
    public string $gender_restriction = 'any';
    public string $status = 'available';
    public string $description = '';
    public string $internal_notes = '';
    public bool $is_published = true;

    // Active tenant override flag
    public bool $overrideActiveCheck = false;

    // Gallery uploads
    public $galleryUpload = null;
    public string $galleryLabel = '';

    // Selected facilities mapping
    public array $selectedFacilities = [];

    // Search facility inside form
    public string $facilitySearch = '';

    public function mount(?string $id = null): void
    {
        $this->roomId = $id;

        if ($id) {
            $room = Room::findOrFail($id);

            if (Auth::user()->cannot('view', $room)) {
                abort(403, 'Unauthorized.');
            }

            $this->boarding_house_id = $room->boarding_house_id;
            $this->room_number = $room->room_number;
            $this->room_name = $room->room_name ?? '';
            $this->floor = $room->floor;
            $this->building_block = $room->building_block ?? '';
            $this->room_type = $room->room_type;
            $this->monthly_rent = (float) $room->monthly_rent;
            $this->security_deposit = (float) $room->security_deposit;
            $this->room_size = $room->room_size ?? '';
            $this->max_occupants = $room->max_occupants;
            $this->gender_restriction = $room->gender_restriction;
            $this->status = $room->status;
            $this->description = $room->description ?? '';
            $this->internal_notes = $room->internal_notes ?? '';
            $this->is_published = $room->is_published;

            // Load facilities pivot links
            $this->selectedFacilities = $room->facilities()->pluck('facility_id')->map(fn($id) => (string)$id)->toArray();
        } else {
            // Check auth gate
            if (Auth::user()->cannot('create', Room::class)) {
                abort(403, 'Unauthorized.');
            }

            // Pre-select first boarding house
            $firstHouse = BoardingHouse::first();
            if ($firstHouse) {
                $this->boarding_house_id = $firstHouse->id;
            }
        }
    }

    public function setTab(string $tab): void
    {
        if (!$this->roomId && $tab !== 'profile') {
            $this->dispatch('toast', ['type' => 'warning', 'message' => 'Silakan simpan profil terlebih dahulu sebelum mengonfigurasi detail.']);
            return;
        }
        $this->activeTab = $tab;
    }

    public function saveProfile(RoomService $service): void
    {
        $rules = [
            'boarding_house_id' => ['required', 'uuid', 'exists:boarding_houses,id'],
            'room_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms')
                    ->where('boarding_house_id', $this->boarding_house_id)
                    ->ignore($this->roomId),
            ],
            'room_name' => ['nullable', 'string', 'max:255'],
            'floor' => ['required', 'integer', 'min:1'],
            'building_block' => ['nullable', 'string', 'max:50'],
            'room_type' => ['required', 'string', 'in:Standard,Deluxe,Suite,VIP'],
            'monthly_rent' => ['required', 'numeric', 'min:0'],
            'security_deposit' => ['required', 'numeric', 'min:0'],
            'room_size' => ['nullable', 'string', 'max:50'],
            'max_occupants' => ['required', 'integer', 'min:1'],
            'gender_restriction' => ['required', 'string', 'in:any,male,female'],
            'status' => ['required', 'string', 'in:available,occupied,reserved,maintenance,cleaning,unavailable,inactive'],
            'description' => ['nullable', 'string', 'max:1000'],
            'internal_notes' => ['nullable', 'string', 'max:1000'],
            'is_published' => ['boolean'],
        ];

        $this->validate($rules);

        $data = [
            'boarding_house_id' => $this->boarding_house_id,
            'room_number' => $this->room_number,
            'room_name' => $this->room_name,
            'floor' => $this->floor,
            'building_block' => $this->building_block,
            'room_type' => $this->room_type,
            'monthly_rent' => $this->monthly_rent,
            'security_deposit' => $this->security_deposit,
            'room_size' => $this->room_size,
            'max_occupants' => $this->max_occupants,
            'gender_restriction' => $this->gender_restriction,
            'status' => $this->status,
            'description' => $this->description,
            'internal_notes' => $this->internal_notes,
            'is_published' => $this->is_published,
        ];

        try {
            if ($this->roomId) {
                $room = Room::findOrFail($this->roomId);
                
                if (Auth::user()->cannot('update', $room)) {
                    abort(403, 'Akses ditolak.');
                }

                $service->updateRoom($room, $data, $this->overrideActiveCheck);
                $this->dispatch('toast', ['type' => 'success', 'message' => 'Konfigurasi kamar berhasil diperbarui!']);
            } else {
                if (Auth::user()->cannot('create', Room::class)) {
                    abort(403, 'Akses ditolak.');
                }
                $room = $service->createRoom($data);
                $this->roomId = $room->id;
                
                $this->dispatch('toast', ['type' => 'success', 'message' => 'Profil kamar berhasil dibuat. Melanjutkan ke konfigurasi...']);
                $this->redirect(route('rooms.edit', $room->id));
            }
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function saveFacilities(RoomService $service): void
    {
        $room = Room::findOrFail($this->roomId);
        if (Auth::user()->cannot('update', $room)) {
            abort(403, 'Akses ditolak.');
        }

        $service->syncFacilities($room, $this->selectedFacilities);

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Fasilitas kamar berhasil diperbarui!']);
    }

    public function uploadGalleryImage(RoomService $service): void
    {
        $room = Room::findOrFail($this->roomId);
        if (Auth::user()->cannot('update', $room)) {
            abort(403, 'Akses ditolak.');
        }

        $this->validate([
            'galleryUpload' => ['required', 'image', 'max:2048'],
            'galleryLabel' => ['nullable', 'string', 'max:100'],
        ]);

        $path = $this->galleryUpload->store('rooms', 'public');
        
        $isFirst = $room->images()->count() === 0;
        $service->addRoomImage($room, $path, $isFirst, $this->galleryLabel);

        $this->reset(['galleryUpload', 'galleryLabel']);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Gambar berhasil ditambahkan ke galeri kamar.']);
    }

    public function setAsCover(int $id, RoomService $service): void
    {
        $room = Room::findOrFail($this->roomId);
        if (Auth::user()->cannot('update', $room)) {
            abort(403, 'Akses ditolak.');
        }

        $image = RoomImage::findOrFail($id);
        $service->setCoverImage($image);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Berhasil mengatur gambar sampul.']);
    }

    public function deleteGalleryImage(int $id, RoomService $service): void
    {
        $room = Room::findOrFail($this->roomId);
        if (Auth::user()->cannot('update', $room)) {
            abort(403, 'Akses ditolak.');
        }

        $image = RoomImage::findOrFail($id);
        $service->removeRoomImage($image);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Gambar galeri berhasil dihapus.']);
    }

    public function moveGalleryUp(int $id, RoomService $service): void
    {
        $room = Room::findOrFail($this->roomId);
        if (Auth::user()->cannot('update', $room)) {
            abort(403, 'Akses ditolak.');
        }

        $image = RoomImage::findOrFail($id);
        $previous = RoomImage::where('room_id', $this->roomId)
            ->where('display_order', '<', $image->display_order)
            ->orderBy('display_order', 'desc')
            ->first();

        if ($previous) {
            $oldOrder = $image->display_order;
            $image->update(['display_order' => $previous->display_order]);
            $previous->update(['display_order' => $oldOrder]);
        }
    }

    public function moveGalleryDown(int $id, RoomService $service): void
    {
        $room = Room::findOrFail($this->roomId);
        if (Auth::user()->cannot('update', $room)) {
            abort(403, 'Akses ditolak.');
        }

        $image = RoomImage::findOrFail($id);
        $next = RoomImage::where('room_id', $this->roomId)
            ->where('display_order', '>', $image->display_order)
            ->orderBy('display_order', 'asc')
            ->first();

        if ($next) {
            $oldOrder = $image->display_order;
            $image->update(['display_order' => $next->display_order]);
            $next->update(['display_order' => $oldOrder]);
        }
    }

    public function regenerateQrCode(RoomService $service): void
    {
        $room = Room::findOrFail($this->roomId);
        if (Auth::user()->cannot('update', $room)) {
            abort(403, 'Akses ditolak.');
        }

        $service->generateQrCode($room);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Kode QR berhasil dibuat ulang secara lokal!']);
    }

    public function render()
    {
        $room = $this->roomId ? Room::findOrFail($this->roomId) : null;
        $gallery = $room ? $room->images : collect();

        // Load active facilities filtered by search
        $facilities = Facility::forCurrentTenant()
            ->where('is_active', true)
            ->when($this->facilitySearch, function($q) {
                $q->where('name', 'like', '%' . $this->facilitySearch . '%');
            })
            ->orderBy('category')
            ->orderBy('display_order')
            ->get();

        $boardingHouses = BoardingHouse::all();

        return view('livewire.room.room-form', [
            'room' => $room,
            'boardingHouses' => $boardingHouses,
            'allFacilities' => $facilities,
            'galleryList' => $gallery,
        ])->layout('layouts.app');
    }
}
