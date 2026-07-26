<?php

namespace App\Livewire\Settings;

use App\Models\Facility;
use App\Services\FacilityService;
use Livewire\Component;
use Livewire\WithPagination;

class FacilityManager extends Component
{
    use WithPagination;

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
                $this->dispatch('toast', ['type' => 'error', 'message' => 'Cannot edit system default facilities.']);
                return;
            }
            $service->updateFacility($facility, $data);
            $message = 'Facility updated successfully!';
        } else {
            $service->createFacility($data);
            $message = 'New facility created successfully!';
        }

        $this->showFormModal = false;
        $this->dispatch('toast', ['type' => 'success', 'message' => $message]);
    }

    public function confirmDelete(int $id): void
    {
        $facility = Facility::forCurrentTenant()->findOrFail($id);
        
        if ($facility->tenant_id !== tenant()->id) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'System default facilities cannot be deleted.']);
            return;
        }

        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteFacility(FacilityService $service): void
    {
        if ($this->deletingId) {
            $facility = Facility::forCurrentTenant()->findOrFail($this->deletingId);
            $service->deleteFacility($facility);
            
            $this->showDeleteModal = false;
            $this->deletingId = null;
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Facility deleted successfully.']);
        }
    }

    public function toggleStatus(int $id, FacilityService $service): void
    {
        $facility = Facility::forCurrentTenant()->findOrFail($id);
        
        if ($facility->tenant_id !== tenant()->id) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Cannot toggle status of system default facilities.']);
            return;
        }

        $newStatus = !$facility->is_active;
        $service->updateFacility($facility, ['is_active' => $newStatus]);

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Facility status toggled successfully!',
        ]);
    }

    public function moveUp(int $id, FacilityService $service): void
    {
        $facility = Facility::forCurrentTenant()->findOrFail($id);
        $previous = Facility::forCurrentTenant()
            ->where('display_order', '<', $facility->display_order)
            ->orderBy('display_order', 'desc')
            ->first();

        if ($previous) {
            $oldOrder = $facility->display_order;
            $facility->update(['display_order' => $previous->display_order]);
            $previous->update(['display_order' => $oldOrder]);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Reordered successfully.']);
        }
    }

    public function moveDown(int $id, FacilityService $service): void
    {
        $facility = Facility::forCurrentTenant()->findOrFail($id);
        $next = Facility::forCurrentTenant()
            ->where('display_order', '>', $facility->display_order)
            ->orderBy('display_order', 'asc')
            ->first();

        if ($next) {
            $oldOrder = $facility->display_order;
            $facility->update(['display_order' => $next->display_order]);
            $next->update(['display_order' => $oldOrder]);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Reordered successfully.']);
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
