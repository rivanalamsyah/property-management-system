<?php

namespace App\Livewire\CMS;

use App\Models\CmsBlogArticle;
use App\Models\CmsBlogCategory;
use App\Models\CmsBlogTag;
use Livewire\Component;
use Livewire\WithPagination;

class CmsBlogList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $category = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteArticle(string $id): void
    {
        $article = CmsBlogArticle::findOrFail($id);
        $article->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Article deleted successfully.']);
    }

    public function render()
    {
        $query = CmsBlogArticle::with(['categories', 'tags']);

        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('author_name', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        if (!empty($this->category)) {
            $query->whereHas('categories', function ($q) {
                $q->where('cms_blog_categories.id', $this->category);
            });
        }

        $articles = $query->latest()->paginate(15);
        $categories = CmsBlogCategory::all();

        return view('livewire.cms.cms-blog-list', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }
}
