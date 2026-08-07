<?php

namespace App\Livewire\Workspace;

use App\Models\Tenant;
use App\Models\SubscriptionPlan;
use App\Enums\WorkspaceStatus;
use Livewire\Component;
use Livewire\WithPagination;

class WorkspaceSearch extends Component
{
    use WithPagination;

    public function mount(): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized.');
        }
    }

    public string $search = '';
    public string $status = '';
    public string $plan = '';
    public string $sortField = 'created_at';
    public bool $sortAsc = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'plan' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortField = $field;
            $this->sortAsc = true;
        }
    }

    public function render()
    {
        $query = Tenant::with(['subscriptionPlan', 'users']);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('slug', 'like', '%' . $this->search . '%')
                  ->orWhere('company_name', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        if (!empty($this->plan)) {
            $query->where('subscription_plan_id', $this->plan);
        }

        $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

        $workspaces = $query->paginate(15);
        $plans = SubscriptionPlan::all();

        return view('livewire.workspace.workspace-search', [
            'workspaces' => $workspaces,
            'plans' => $plans,
        ]);
    }
}
