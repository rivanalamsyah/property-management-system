<?php

namespace App\Livewire\CMS;

use App\Models\CmsPage;
use App\Models\CmsSection;
use App\Models\CmsRevision;
use App\Services\CMS\CmsService;
use App\Enums\CmsPublishStatus;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CmsPageEditor extends Component
{
    public CmsPage $page;
    
    // Page configuration fields
    public string $name = '';
    public string $slug = '';
    public string $seo_title = '';
    public string $seo_description = '';
    public string $status = 'draft';

    // Sections editable content data
    public array $sectionsData = [];

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'string'],
        ];
    }

    public function mount(string $id): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized. Super Admin access only.');
        }

        $this->page = CmsPage::with('sections')->findOrFail($id);
        
        $this->name = $this->page->name;
        $this->slug = $this->page->slug;
        $this->seo_title = $this->page->seo_title ?? '';
        $this->seo_description = $this->page->seo_description ?? '';
        $this->status = $this->page->status->value;

        // Initialize structured section contents
        foreach ($this->page->sections as $sec) {
            $this->sectionsData[$sec->id] = $sec->content ?? [];
        }
    }

    public function savePage(): void
    {
        $this->validate();

        $cmsService = app(CmsService::class);

        // 1. Create a revision snapshot of current page configuration
        $snapshot = [
            'name' => $this->page->name,
            'slug' => $this->page->slug,
            'seo_title' => $this->page->seo_title,
            'seo_description' => $this->page->seo_description,
            'status' => $this->page->status->value,
        ];
        $cmsService->createRevision($this->page, $snapshot);

        // 2. Update page DB record
        $this->page->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'status' => $this->status,
        ]);

        // 3. Save sections content edits
        foreach ($this->sectionsData as $secId => $content) {
            $section = CmsSection::find($secId);
            if ($section) {
                $section->update(['content' => $content]);
            }
        }

        activity_log(
            event: 'cms.page_update',
            description: "CMS page updated: {$this->page->name}",
            userId: Auth::id()
        );

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Page content successfully saved!']);
    }

    /**
     * Restore page configuration from a historical version.
     */
    public function restoreRevision(string $revisionId): void
    {
        $cmsService = app(CmsService::class);
        $cmsService->restoreRevision($this->page, $revisionId);

        // Refresh component variables
        $this->name = $this->page->name;
        $this->slug = $this->page->slug;
        $this->seo_title = $this->page->seo_title ?? '';
        $this->seo_description = $this->page->seo_description ?? '';
        $this->status = $this->page->status->value;

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Restored version successfully!']);
    }

    public function render()
    {
        $revisions = CmsRevision::where('revisable_type', CmsPage::class)
            ->where('revisable_id', $this->page->id)
            ->orderBy('version_number', 'desc')
            ->get();

        return view('livewire.cms.cms-page-editor', [
            'revisions' => $revisions,
        ]);
    }
}
