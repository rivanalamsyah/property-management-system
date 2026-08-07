<?php

namespace App\Livewire\Settings;

use App\Models\Facility;
use App\Services\FacilityService;
use Livewire\Component;
use Livewire\WithPagination;

class FacilityManager extends Component
{
    use WithPagination;

    public function mount(): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasPermission('manage-settings')) {
            abort(403, 'Unauthorized.');
        }
    }

    // Filters & Search
    public string $search = '';
    public string $filterCategory = '';

    // Form fields
    public ?int $facilityId = null;
    public string $name = '';
    public string $icon = 'wifi'; // default
    public string $category = 'Room'; // default
    public string $description = '';
    public bool $is_active = true;

    // Modal state
    public bool $showFormModal = false;
    public bool $showDeleteModal = false;
    public ?int $deletingId = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['required', 'string', 'max:50'],
            'category' => ['required', 'string', 'in:Room,General,Security,Shared'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterCategory(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->resetValidation();
        $this->reset(['facilityId', 'name', 'icon', 'category', 'description', 'is_active']);
        $this->showFormModal = true;
    }

    public function editFacility(int $id): void
    {
        $this->resetValidation();
        $facility = Facility::forCurrentTenant()->findOrFail($id);
        
        $this->facilityId = $facility->id;
        $this->name = $facility->name;
        $this->icon = $facility->icon;
        $this->category = $facility->category;
        $this->description = $facility->description ?? '';
        $this->is_active = $facility->is_active;

        $this->showFormModal = true;
    }

    public function saveFacility(FacilityService $service): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasPermission('manage-settings')) {
            abort(403, 'Unauthorized.');
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'icon' => $this->icon,
            'category' => $this->category,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->facilityId) {
            $facility = Facility::forCurrentTenant()->findOrFail($this->facilityId);
            // Verify ownership: tenant can only edit their own custom facilities
            if ($facility->tenant_id !== tenant()->id) {
                $this->dispatch('toast', ['type' => 'error', 'message' => 'Tidak dapat mengubah fasilitas bawaan sistem.']);
                return;
            }
            $service->updateFacility($facility, $data);
            $message = 'Fasilitas berhasil diperbarui!';
        } else {
            $service->createFacility($data);
            $message = 'Fasilitas baru berhasil dibuat!';
        }

        $this->showFormModal = false;
        $this->dispatch('toast', ['type' => 'success', 'message' => $message]);
    }

    public function confirmDelete(int $id): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasPermission('manage-settings')) {
            abort(403, 'Unauthorized.');
        }

        $facility = Facility::forCurrentTenant()->findOrFail($id);
        
        if ($facility->tenant_id !== tenant()->id) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Fasilitas bawaan sistem tidak dapat dihapus.']);
            return;
        }

        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteFacility(FacilityService $service): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasPermission('manage-settings')) {
            abort(403, 'Unauthorized.');
        }

        if ($this->deletingId) {
            $facility = Facility::forCurrentTenant()->findOrFail($this->deletingId);
            $service->deleteFacility($facility);
            
            $this->showDeleteModal = false;
            $this->deletingId = null;
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Fasilitas berhasil dihapus.']);
        }
    }

    public function toggleStatus(int $id, FacilityService $service): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasPermission('manage-settings')) {
            abort(403, 'Unauthorized.');
        }

        $facility = Facility::forCurrentTenant()->findOrFail($id);
        
        if ($facility->tenant_id !== tenant()->id) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Tidak dapat mengubah status fasilitas bawaan sistem.']);
            return;
        }

        $newStatus = !$facility->is_active;
        $service->updateFacility($facility, ['is_active' => $newStatus]);

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Status fasilitas berhasil diubah!',
        ]);
    }

    public function moveUp(int $id, FacilityService $service): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasPermission('manage-settings')) {
            abort(403, 'Unauthorized.');
        }

        $facility = Facility::forCurrentTenant()->findOrFail($id);
        $previous = Facility::forCurrentTenant()
            ->where('display_order', '<', $facility->display_order)
            ->orderBy('display_order', 'desc')
            ->first();

        if ($previous) {
            $oldOrder = $facility->display_order;
            $facility->update(['display_order' => $previous->display_order]);
            $previous->update(['display_order' => $oldOrder]);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Urutan berhasil diperbarui.']);
        }
    }

    public function moveDown(int $id, FacilityService $service): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasPermission('manage-settings')) {
            abort(403, 'Unauthorized.');
        }

        $facility = Facility::forCurrentTenant()->findOrFail($id);
        $next = Facility::forCurrentTenant()
            ->where('display_order', '>', $facility->display_order)
            ->orderBy('display_order', 'asc')
            ->first();

        if ($next) {
            $oldOrder = $facility->display_order;
            $facility->update(['display_order' => $next->display_order]);
            $next->update(['display_order' => $oldOrder]);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Urutan berhasil diperbarui.']);
        }
    }

    public function render()
    {
        $query = Facility::forCurrentTenant()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterCategory, function ($q) {
                $q->where('category', $this->filterCategory);
            })
            ->orderBy('display_order');

        return view('livewire.settings.facility-manager', [
            'facilities' => $query->paginate(10),
        ])->layout('layouts.app');
    }
}
