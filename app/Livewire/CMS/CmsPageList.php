<?php

namespace App\Livewire\CMS;

use App\Models\CmsPage;
use Livewire\Component;

class CmsPageList extends Component
{
    public function mount(): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized. Super Admin access only.');
        }
    }
    public function render()
    {
        $pages = CmsPage::withCount('sections')->get();

        return view('livewire.cms.cms-page-list', [
            'pages' => $pages,
        ]);
    }
}
