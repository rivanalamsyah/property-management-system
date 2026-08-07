<?php

namespace App\Livewire\CMS;

use App\Models\CmsBlogArticle;
use App\Models\CmsBlogCategory;
use App\Models\CmsBlogTag;
use App\Models\CmsRevision;
use App\Services\CMS\CmsService;
use App\Enums\CmsPublishStatus;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CmsBlogEditor extends Component
{
    public ?CmsBlogArticle $article = null;
    public bool $isEdit = false;

    // Fields
    public string $title = '';
    public string $slug = '';
    public string $excerpt = '';
    public string $content = '';
    public string $featured_image = '';
    public string $author_name = '';
    public string $status = 'draft';
    
    // Dates
    public ?string $published_at = null;
    public ?string $expired_at = null;

    // SEO
    public string $seo_title = '';
    public string $seo_description = '';

    // Selected relationships
    public array $selectedCategories = [];
    public string $tagsCsv = ''; // comma-separated tags

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'string'],
            'author_name' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
            'expired_at' => ['nullable', 'date'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function mount(?string $id = null): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized. Super Admin access only.');
        }

        if ($id) {
            $this->isEdit = true;
            $this->article = CmsBlogArticle::with(['categories', 'tags'])->findOrFail($id);
            
            $this->title = $this->article->title;
            $this->slug = $this->article->slug;
            $this->excerpt = $this->article->excerpt ?? '';
            $this->content = $this->article->content ?? '';
            $this->featured_image = $this->article->featured_image ?? '';
            $this->author_name = $this->article->author_name ?? '';
            $this->status = $this->article->status->value;
            $this->published_at = $this->article->published_at ? $this->article->published_at->format('Y-m-d\TH:i') : null;
            $this->expired_at = $this->article->expired_at ? $this->article->expired_at->format('Y-m-d\TH:i') : null;
            
            $this->seo_title = $this->article->seo_title ?? '';
            $this->seo_description = $this->article->seo_description ?? '';
            
            $this->selectedCategories = $this->article->categories->pluck('id')->toArray();
            $this->tagsCsv = implode(', ', $this->article->tags->pluck('name')->toArray());
        } else {
            $this->author_name = Auth::user()->name;
        }
    }

    public function updatedTitle(): void
    {
        if (!$this->isEdit) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function saveArticle(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'featured_image' => $this->featured_image,
            'author_name' => $this->author_name,
            'status' => $this->status,
            'published_at' => $this->published_at ? Carbon::parse($this->published_at) : null,
            'expired_at' => $this->expired_at ? Carbon::parse($this->expired_at) : null,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
        ];

        $cmsService = app(CmsService::class);

        if ($this->isEdit) {
            // Save revision snapshot before change
            $snapshot = [
                'title' => $this->article->title,
                'slug' => $this->article->slug,
                'excerpt' => $this->article->excerpt,
                'content' => $this->article->content,
                'featured_image' => $this->article->featured_image,
                'status' => $this->article->status->value,
            ];
            $cmsService->createRevision($this->article, $snapshot);

            $this->article->update($data);
            $article = $this->article;
        } else {
            $article = CmsBlogArticle::create($data);
        }

        // Sync categories
        $article->categories()->sync($this->selectedCategories);

        // Sync tags
        $tagIds = [];
        $tags = array_map('trim', explode(',', $this->tagsCsv));
        foreach ($tags as $tagName) {
            if (empty($tagName)) continue;
            $tag = CmsBlogTag::firstOrCreate([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
            $tagIds[] = $tag->id;
        }
        $article->tags()->sync($tagIds);

        activity_log(
            event: $this->isEdit ? 'cms.article_update' : 'cms.article_create',
            description: "CMS Blog Article saved: {$article->title}",
            userId: Auth::id()
        );

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Article successfully saved!']);
        $this->redirect(route('cms.blog.index'));
    }

    public function restoreRevision(string $revisionId): void
    {
        $cmsService = app(CmsService::class);
        $cmsService->restoreRevision($this->article, $revisionId);

        // Refresh model values
        $this->title = $this->article->title;
        $this->slug = $this->article->slug;
        $this->excerpt = $this->article->excerpt ?? '';
        $this->content = $this->article->content ?? '';
        $this->featured_image = $this->article->featured_image ?? '';
        $this->status = $this->article->status->value;

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Restored version successfully!']);
    }

    public function render()
    {
        $categoriesList = CmsBlogCategory::all();
        $revisions = $this->isEdit 
            ? CmsRevision::where('revisable_type', CmsBlogArticle::class)
                ->where('revisable_id', $this->article->id)
                ->orderBy('version_number', 'desc')
                ->get()
            : collect();

        return view('livewire.cms.cms-blog-editor', [
            'categoriesList' => $categoriesList,
            'revisions' => $revisions,
        ]);
    }
}
