<?php

namespace App\Livewire\CMS;

use App\Models\CmsPage;
use Livewire\Component;

class CmsPageList extends Component
{
    public function render()
    {
        $pages = CmsPage::withCount('sections')->get();

        return view('livewire.cms.cms-page-list', [
            'pages' => $pages,
        ]);
    }
}
