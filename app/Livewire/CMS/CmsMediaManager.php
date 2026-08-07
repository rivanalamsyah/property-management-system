<?php

namespace App\Livewire\CMS;

use App\Models\CmsMedia;
use App\Services\CMS\CmsMediaService;
use Livewire\Component;
use Livewire\WithFileUploads;

class CmsMediaManager extends Component
{
    use WithFileUploads;

    public $upload_file;
    public string $alt_text = '';
    public string $folder = '/';
    public string $search = '';

    // Selected file for edit/replace
    public ?string $selectedMediaId = null;
    public $replace_file;

    public function mount(): void
    {
        if (!\Illuminate\Support\Facades\Auth::user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized. Super Admin access only.');
        }
    }

    protected $queryString = [
        'folder' => ['except' => '/'],
        'search' => ['except' => ''],
    ];

    public function uploadMedia(): void
    {
        $this->folder = preg_replace('/[^a-zA-Z0-9\/_-]/', '', $this->folder);
        $this->folder = '/' . trim(preg_replace('/\.\.+/', '', $this->folder), '/');

        $this->validate([
            'upload_file' => ['required', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,zip,mp3,mp4', 'max:10240'], // 10MB limit
            'alt_text' => ['nullable', 'string', 'max:255'],
        ]);

        $mediaService = app(CmsMediaService::class);
        $mediaService->upload($this->upload_file, $this->folder, $this->alt_text);

        $this->upload_file = null;
        $this->alt_text = '';

        $this->dispatch('toast', ['type' => 'success', 'message' => 'File uploaded successfully!']);
    }

    public function selectMedia(string $id): void
    {
        $this->selectedMediaId = $id;
        $media = CmsMedia::findOrFail($id);
        $this->alt_text = $media->alt_text ?? '';
    }

    public function updateAltText(): void
    {
        if ($this->selectedMediaId) {
            $media = CmsMedia::findOrFail($this->selectedMediaId);
            $media->update(['alt_text' => $this->alt_text]);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Alt text updated successfully.']);
        }
    }

    public function replaceMedia(): void
    {
        $this->validate([
            'replace_file' => ['required', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,zip,mp3,mp4', 'max:10240'],
        ]);

        if ($this->selectedMediaId) {
            $media = CmsMedia::findOrFail($this->selectedMediaId);
            $mediaService = app(CmsMediaService::class);
            
            $mediaService->replace($media, $this->replace_file);
            $this->replace_file = null;

            $this->dispatch('toast', ['type' => 'success', 'message' => 'File content replaced successfully. All page links updated!']);
        }
    }

    public function deleteMedia(string $id): void
    {
        $media = CmsMedia::findOrFail($id);
        $mediaService = app(CmsMediaService::class);
        $mediaService->delete($media);

        if ($this->selectedMediaId === $id) {
            $this->selectedMediaId = null;
            $this->alt_text = '';
        }

        $this->dispatch('toast', ['type' => 'warning', 'message' => 'File deleted.']);
    }

    public function render()
    {
        $this->folder = preg_replace('/[^a-zA-Z0-9\/_-]/', '', $this->folder);
        $this->folder = '/' . trim(preg_replace('/\.\.+/', '', $this->folder), '/');

        $query = CmsMedia::where('folder', $this->folder);

        if (!empty($this->search)) {
            $query->where('filename', 'like', '%' . $this->search . '%')
                  ->orWhere('alt_text', 'like', '%' . $this->search . '%');
        }

        $mediaList = $query->latest()->get();

        // Unique folders list
        $folders = CmsMedia::pluck('folder')->unique()->toArray();
        if (!in_array('/', $folders)) {
            $folders[] = '/';
        }

        $selectedMedia = $this->selectedMediaId ? CmsMedia::find($this->selectedMediaId) : null;

        return view('livewire.cms.cms-media-manager', [
            'mediaList' => $mediaList,
            'folders' => $folders,
            'selectedMedia' => $selectedMedia,
        ]);
    }
}
