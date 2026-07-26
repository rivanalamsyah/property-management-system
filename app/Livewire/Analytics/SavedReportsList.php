<?php

namespace App\Livewire\Analytics;

use App\Models\SavedReport;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SavedReportsList extends Component
{
    use WithPagination;

    public function mount(): void
    {
        if (!Auth::user()->can('viewAny', SavedReport::class)) {
            abort(403, 'Unauthorized.');
        }
    }

    public function deleteReport(string $id): void
    {
        $report = SavedReport::findOrFail($id);

        if (Auth::user()->cannot('delete', $report)) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $report->delete();
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Saved report preset deleted.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        $reports = SavedReport::with('user')
            ->latest()
            ->paginate(10);

        return view('livewire.analytics.saved-reports-list', [
            'reports' => $reports,
        ])->layout('layouts.app');
    }
}
