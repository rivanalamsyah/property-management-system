<?php

namespace App\Livewire\BoardingHouse;

use App\Models\BoardingHouse;
use App\Models\BoardingHouseGallery;
use App\Models\BoardingHouseRule;
use App\Models\Facility;
use App\Services\BoardingHouseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class BoardingHouseForm extends Component
{
    use WithFileUploads;

    public ?string $boardingHouseId = null;
    public string $activeTab = 'profile';

    // Profile fields
    public string $name = '';
    public string $address = '';
    public string $province = '';
    public string $city = '';
    public string $district = '';
    public string $postal_code = '';
    public ?float $latitude = null;
    public ?float $longitude = null;
    public string $whatsapp_number = '';
    public string $email = '';
    public string $operating_hours = '';
    public string $status = 'active';
    public bool $is_public = true;
    public string $description = '';
    
    // File inputs
    public $logoUpload = null;
    public $coverUpload = null;
    public $galleryUpload = null;

    // Settings fields
    public string $check_in_time = '14:00';
    public string $check_out_time = '12:00';
    public int $billing_due_day = 5;
    public array $accepted_payment_channels = ['cash', 'bank_transfer'];
    public string $currency = 'IDR';
    public string $timezone = 'Asia/Jakarta';
    public string $date_format = 'd/m/Y';
    public string $number_format = 'id_ID';
    public string $invoice_prefix = 'INV-KOS';
    public string $invoice_notes = '';
    public string $booking_policy = '';
    public string $cancellation_policy = '';

    // Facilities fields
    public array $selectedFacilities = [];
    public array $featuredFacilities = [];

    // Rules form fields
    public string $ruleCategory = 'General';
    public string $ruleTitle = '';
    public string $ruleDescription = '';
    public string $ruleIcon = 'key';
    public bool $ruleIsActive = true;
    public bool $ruleIsVisiblePublic = true;
    public ?int $editingRuleId = null;

    public bool $showRuleModal = false;

    // Gallery properties
    public ?string $galleryLabel = '';

    public function mount(?string $id = null): void
    {
        $this->boardingHouseId = $id;

        if ($id) {
            $boardingHouse = BoardingHouse::findOrFail($id);
            
            if (Auth::user()->cannot('view', $boardingHouse)) {
                abort(403, 'Unauthorized.');
            }

            // Fill profile fields
            $this->name = $boardingHouse->name;
            $this->address = $boardingHouse->address;
            $this->province = $boardingHouse->province;
            $this->city = $boardingHouse->city;
            $this->district = $boardingHouse->district;
            $this->postal_code = $boardingHouse->postal_code;
            $this->latitude = $boardingHouse->latitude ? (float) $boardingHouse->latitude : null;
            $this->longitude = $boardingHouse->longitude ? (float) $boardingHouse->longitude : null;
            $this->whatsapp_number = $boardingHouse->whatsapp_number;
            $this->email = $boardingHouse->email ?? '';
            $this->operating_hours = $boardingHouse->operating_hours ?? '';
            $this->status = $boardingHouse->status;
            $this->is_public = $boardingHouse->is_public;
            $this->description = $boardingHouse->description ?? '';

            // Fill settings
            $this->check_in_time = $boardingHouse->getSetting('check_in_time', '14:00');
            $this->check_out_time = $boardingHouse->getSetting('check_out_time', '12:00');
            $this->billing_due_day = (int) $boardingHouse->getSetting('billing_due_day', 5);
            $this->accepted_payment_channels = $boardingHouse->getSetting('accepted_payment_channels', ['cash', 'bank_transfer']);
            $this->currency = $boardingHouse->getSetting('currency', 'IDR');
            $this->timezone = $boardingHouse->getSetting('timezone', 'Asia/Jakarta');
            $this->date_format = $boardingHouse->getSetting('date_format', 'd/m/Y');
            $this->number_format = $boardingHouse->getSetting('number_format', 'id_ID');
            $this->invoice_prefix = $boardingHouse->getSetting('invoice_prefix', 'INV-KOS');
            $this->invoice_notes = $boardingHouse->getSetting('invoice_notes', '');
            $this->booking_policy = $boardingHouse->getSetting('booking_policy', '');
            $this->cancellation_policy = $boardingHouse->getSetting('cancellation_policy', '');

            // Load linked facilities
            $this->selectedFacilities = $boardingHouse->facilities()->pluck('facility_id')->map(fn($id) => (string)$id)->toArray();
            $this->featuredFacilities = $boardingHouse->facilities()->wherePivot('is_featured', true)->pluck('facility_id')->map(fn($id) => (string)$id)->toArray();
        } else {
            // New entry policy check
            if (Auth::user()->cannot('create', BoardingHouse::class)) {
                abort(403, 'Unauthorized.');
            }
        }
    }

    public function setTab(string $tab): void
    {
        if (!$this->boardingHouseId && $tab !== 'profile') {
            $this->dispatch('toast', ['type' => 'warning', 'message' => 'Please save the profile first before configuring other sections.']);
            return;
        }
        $this->activeTab = $tab;
    }

    public function saveProfile(BoardingHouseService $service): void
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'whatsapp_number' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'operating_hours' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:active,full,inactive'],
            'is_public' => ['boolean'],
            'description' => ['nullable', 'string', 'max:1000'],
            'logoUpload' => ['nullable', 'image', 'max:1024'], // 1MB
            'coverUpload' => ['nullable', 'image', 'max:2048'], // 2MB
        ];

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'address' => $this->address,
            'province' => $this->province,
            'city' => $this->city,
            'district' => $this->district,
            'postal_code' => $this->postal_code,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'whatsapp_number' => $this->whatsapp_number,
            'email' => $this->email,
            'operating_hours' => $this->operating_hours,
            'status' => $this->status,
            'is_public' => $this->is_public,
            'description' => $this->description,
        ];

        if ($this->logoUpload) {
            $data['logo'] = $this->logoUpload->store('logos', 'public');
        }

        if ($this->coverUpload) {
            $data['cover_image'] = $this->coverUpload->store('covers', 'public');
        }

        if ($this->boardingHouseId) {
            $boardingHouse = BoardingHouse::findOrFail($this->boardingHouseId);
            
            // Authorization checks
            if (Auth::user()->cannot('update', $boardingHouse)) {
                abort(403, 'Unauthorized.');
            }

            // Cleanup old files if replaced
            if ($this->logoUpload && $boardingHouse->logo) {
                Storage::disk('public')->delete($boardingHouse->logo);
            }
            if ($this->coverUpload && $boardingHouse->cover_image) {
                Storage::disk('public')->delete($boardingHouse->cover_image);
            }

            $service->updateBoardingHouse($boardingHouse, $data);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Profile details updated!']);
        } else {
            $boardingHouse = $service->createBoardingHouse($data);
            $this->boardingHouseId = $boardingHouse->id;
            
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Boarding house profile registered!']);
            $this->redirect(route('boarding-houses.edit', $boardingHouse->id));
        }

        $this->reset(['logoUpload', 'coverUpload']);
    }

    public function saveSettings(BoardingHouseService $service): void
    {
        $this->validate([
            'check_in_time' => ['required', 'string'],
            'check_out_time' => ['required', 'string'],
            'billing_due_day' => ['required', 'integer', 'between:1,31'],
            'accepted_payment_channels' => ['required', 'array', 'min:1'],
            'currency' => ['required', 'string', 'max:5'],
            'timezone' => ['required', 'string'],
            'date_format' => ['required', 'string'],
            'number_format' => ['required', 'string'],
            'invoice_prefix' => ['required', 'string', 'max:20'],
            'invoice_notes' => ['nullable', 'string', 'max:500'],
            'booking_policy' => ['nullable', 'string', 'max:1000'],
            'cancellation_policy' => ['nullable', 'string', 'max:1000'],
        ]);

        $settings = [
            'check_in_time' => $this->check_in_time,
            'check_out_time' => $this->check_out_time,
            'billing_due_day' => $this->billing_due_day,
            'accepted_payment_channels' => $this->accepted_payment_channels,
            'currency' => $this->currency,
            'timezone' => $this->timezone,
            'date_format' => $this->date_format,
            'number_format' => $this->number_format,
            'invoice_prefix' => $this->invoice_prefix,
            'invoice_notes' => $this->invoice_notes,
            'booking_policy' => $this->booking_policy,
            'cancellation_policy' => $this->cancellation_policy,
        ];

        $boardingHouse = BoardingHouse::findOrFail($this->boardingHouseId);
        $service->updateSettings($boardingHouse, $settings);

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Operational configurations updated successfully.']);
    }

    public function saveFacilities(BoardingHouseService $service): void
    {
        $boardingHouse = BoardingHouse::findOrFail($this->boardingHouseId);
        
        $syncData = [];
        foreach ($this->selectedFacilities as $facilityId) {
            $isFeatured = in_array($facilityId, $this->featuredFacilities);
            $syncData[$facilityId] = ['is_featured' => $isFeatured];
        }

        $service->syncFacilities($boardingHouse, $syncData);

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Facilities synchronization complete.']);
    }

    // Rules handlers
    public function openAddRuleModal(): void
    {
        $this->resetValidation();
        $this->reset(['editingRuleId', 'ruleCategory', 'ruleTitle', 'ruleDescription', 'ruleIcon', 'ruleIsActive', 'ruleIsVisiblePublic']);
        $this->showRuleModal = true;
    }

    public function editRule(int $id): void
    {
        $this->resetValidation();
        $rule = BoardingHouseRule::findOrFail($id);
        
        $this->editingRuleId = $rule->id;
        $this->ruleCategory = $rule->category;
        $this->ruleTitle = $rule->title;
        $this->ruleDescription = $rule->description ?? '';
        $this->ruleIcon = $rule->icon ?? 'key';
        $this->ruleIsActive = $rule->is_active;
        $this->ruleIsVisiblePublic = $rule->is_visible_public;

        $this->showRuleModal = true;
    }

    public function saveRule(BoardingHouseService $service): void
    {
        $this->validate([
            'ruleTitle' => ['required', 'string', 'max:255'],
            'ruleCategory' => ['required', 'string'],
            'ruleDescription' => ['nullable', 'string', 'max:500'],
            'ruleIcon' => ['required', 'string'],
            'ruleIsActive' => ['boolean'],
            'ruleIsVisiblePublic' => ['boolean'],
        ]);

        $boardingHouse = BoardingHouse::findOrFail($this->boardingHouseId);

        $data = [
            'category' => $this->ruleCategory,
            'title' => $this->ruleTitle,
            'description' => $this->ruleDescription,
            'icon' => $this->ruleIcon,
            'is_active' => $this->ruleIsActive,
            'is_visible_public' => $this->ruleIsVisiblePublic,
        ];

        if ($this->editingRuleId) {
            $rule = BoardingHouseRule::findOrFail($this->editingRuleId);
            $service->updateRule($rule, $data);
            $message = 'Rule updated!';
        } else {
            $service->addRule($boardingHouse, $data);
            $message = 'Rule added!';
        }

        $this->showRuleModal = false;
        $this->dispatch('toast', ['type' => 'success', 'message' => $message]);
    }

    public function deleteRule(int $id, BoardingHouseService $service): void
    {
        $rule = BoardingHouseRule::findOrFail($id);
        $service->removeRule($rule);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Rule removed.']);
    }

    public function moveRuleUp(int $id, BoardingHouseService $service): void
    {
        $rule = BoardingHouseRule::findOrFail($id);
        $previous = BoardingHouseRule::where('boarding_house_id', $this->boardingHouseId)
            ->where('display_order', '<', $rule->display_order)
            ->orderBy('display_order', 'desc')
            ->first();

        if ($previous) {
            $oldOrder = $rule->display_order;
            $rule->update(['display_order' => $previous->display_order]);
            $previous->update(['display_order' => $oldOrder]);
        }
    }

    public function moveRuleDown(int $id, BoardingHouseService $service): void
    {
        $rule = BoardingHouseRule::findOrFail($id);
        $next = BoardingHouseRule::where('boarding_house_id', $this->boardingHouseId)
            ->where('display_order', '>', $rule->display_order)
            ->orderBy('display_order', 'asc')
            ->first();

        if ($next) {
            $oldOrder = $rule->display_order;
            $rule->update(['display_order' => $next->display_order]);
            $next->update(['display_order' => $oldOrder]);
        }
    }

    // Gallery handlers
    public function uploadGalleryImage(BoardingHouseService $service): void
    {
        $this->validate([
            'galleryUpload' => ['required', 'image', 'max:2048'], // 2MB
            'galleryLabel' => ['nullable', 'string', 'max:100'],
        ]);

        $boardingHouse = BoardingHouse::findOrFail($this->boardingHouseId);
        $path = $this->galleryUpload->store('galleries', 'public');
        
        $isFirst = $boardingHouse->galleries()->count() === 0;

        $service->addGalleryImage($boardingHouse, $path, $isFirst, $this->galleryLabel);

        $this->reset(['galleryUpload', 'galleryLabel']);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Image added to gallery.']);
    }

    public function setAsCover(int $id, BoardingHouseService $service): void
    {
        $gallery = BoardingHouseGallery::findOrFail($id);
        $service->setCoverImage($gallery);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Set as cover image successfully.']);
    }

    public function deleteGalleryImage(int $id, BoardingHouseService $service): void
    {
        $gallery = BoardingHouseGallery::findOrFail($id);
        $service->removeGalleryImage($gallery);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Gallery image deleted.']);
    }

    public function moveGalleryUp(int $id, BoardingHouseService $service): void
    {
        $gallery = BoardingHouseGallery::findOrFail($id);
        $previous = BoardingHouseGallery::where('boarding_house_id', $this->boardingHouseId)
            ->where('display_order', '<', $gallery->display_order)
            ->orderBy('display_order', 'desc')
            ->first();

        if ($previous) {
            $oldOrder = $gallery->display_order;
            $gallery->update(['display_order' => $previous->display_order]);
            $previous->update(['display_order' => $oldOrder]);
        }
    }

    public function moveGalleryDown(int $id, BoardingHouseService $service): void
    {
        $gallery = BoardingHouseGallery::findOrFail($id);
        $next = BoardingHouseGallery::where('boarding_house_id', $this->boardingHouseId)
            ->where('display_order', '>', $gallery->display_order)
            ->orderBy('display_order', 'asc')
            ->first();

        if ($next) {
            $oldOrder = $gallery->display_order;
            $gallery->update(['display_order' => $next->display_order]);
            $next->update(['display_order' => $oldOrder]);
        }
    }

    public function render()
    {
        $boardingHouse = $this->boardingHouseId ? BoardingHouse::findOrFail($this->boardingHouseId) : null;
        
        $rules = $boardingHouse ? $boardingHouse->rules : collect();
        $gallery = $boardingHouse ? $boardingHouse->galleries : collect();
        
        // Fetch dynamic active facilities group by category
        $allFacilities = Facility::forCurrentTenant()->where('is_active', true)->orderBy('category')->orderBy('display_order')->get();

        return view('livewire.boarding-house.boarding-house-form', [
            'boardingHouse' => $boardingHouse,
            'rulesList' => $rules,
            'galleryList' => $gallery,
            'allFacilities' => $allFacilities,
        ])->layout('layouts.app');
    }
}
