<?php

namespace App\Livewire\CMS;

use App\Models\CmsPage;
use App\Models\CmsBlogArticle;
use App\Models\CmsBlogCategory;
use App\Models\CmsBlogTag;
use App\Models\CmsMedia;
use App\Models\CmsRedirect;
use Livewire\Component;

class CmsDashboard extends Component
{
    public string $globalSearch = '';

    public function mount(): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized. Super Admin access only.');
        }
    }

    public function render()
    {
        $publishedPages = CmsPage::where('status', \App\Enums\CmsPublishStatus::PUBLISHED)->count();
        $draftPages = CmsPage::where('status', \App\Enums\CmsPublishStatus::DRAFT)->count();
        $scheduledPages = CmsPage::where('status', \App\Enums\CmsPublishStatus::SCHEDULED)->count();

        $articles = CmsBlogArticle::count();
        $categories = CmsBlogCategory::count();
        $tags = CmsBlogTag::count();

        // Media count & size calculation
        $mediaCount = CmsMedia::count();
        $mediaSizeBytes = CmsMedia::sum('file_size');
        $mediaSizeMb = round($mediaSizeBytes / 1024 / 1024, 2);

        // SEO Health Indicators: Pages missing meta title/description or having inactive redirects
        $pagesMissingMeta = CmsPage::whereNull('seo_title')
            ->orWhereNull('seo_description')
            ->count();
        $brokenRedirectsCount = CmsRedirect::where('is_active', false)->count();

        // Search Results
        $searchResults = [];
        if (!empty($this->globalSearch)) {
            $searchResults['pages'] = CmsPage::where('name', 'like', '%' . $this->globalSearch . '%')
                ->orWhere('slug', 'like', '%' . $this->globalSearch . '%')
                ->take(5)
                ->get();
            $searchResults['articles'] = CmsBlogArticle::where('title', 'like', '%' . $this->globalSearch . '%')
                ->take(5)
                ->get();
        }

        return view('livewire.cms.cms-dashboard', [
            'publishedPages' => $publishedPages,
            'draftPages' => $draftPages,
            'scheduledPages' => $scheduledPages,
            'articlesCount' => $articles,
            'categoriesCount' => $categories,
            'tagsCount' => $tags,
            'mediaCount' => $mediaCount,
            'mediaSizeMb' => $mediaSizeMb,
            'pagesMissingMeta' => $pagesMissingMeta,
            'brokenRedirectsCount' => $brokenRedirectsCount,
            'searchResults' => $searchResults,
        ]);
    }
}
