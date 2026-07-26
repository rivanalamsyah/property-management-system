<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- LEFT: Article Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-6">
            <div>
                <x-label for="title">Article Title</x-label>
                <x-input id="title" type="text" wire:model.live="title" placeholder="e.g. 10 Tips to Increase Occupancy Rate" class="w-full mt-1.5 text-base font-bold" />
                <x-input-error for="title" class="mt-1" />
            </div>

            <div>
                <x-label for="slug">URL Slug</x-label>
                <x-input id="slug" type="text" wire:model="slug" class="w-full mt-1.5 font-mono text-xs" />
                <x-input-error for="slug" class="mt-1" />
            </div>

            <div>
                <x-label for="excerpt">Excerpt Summary</x-label>
                <textarea id="excerpt" wire:model="excerpt" rows="2" placeholder="Brief summary of the article..." class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                <x-input-error for="excerpt" class="mt-1" />
            </div>

            <div>
                <x-label for="content">Article Body Content</x-label>
                <textarea id="content" wire:model="content" rows="15" placeholder="Write your markdown/HTML article body here..." class="mt-1.5 font-mono block w-full rounded-xl border-slate-200 bg-white py-2.5 px-3 text-xs text-slate-750 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                <x-input-error for="content" class="mt-1" />
            </div>
        </div>
    </div>

    <!-- RIGHT: Sidebar metadata & scheduling settings -->
    <div class="space-y-6">
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-6 sticky top-6">
            <div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Article settings</h3>
                <p class="text-[11px] text-slate-400 leading-normal mt-0.5">Configure categories, status, and SEO metadata.</p>
            </div>

            <!-- Basic Publish Details -->
            <div class="space-y-4">
                <div>
                    <x-label for="author_name">Author Name</x-label>
                    <x-input id="author_name" type="text" wire:model="author_name" class="w-full mt-1.5" />
                    <x-input-error for="author_name" class="mt-1" />
                </div>

                <div>
                    <x-label for="status">Publish Status</x-label>
                    <select id="status" wire:model="status" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                <!-- Custom Scheduled Publication Date -->
                <div>
                    <x-label for="published_at">Publish Scheduled Date</x-label>
                    <x-input id="published_at" type="datetime-local" wire:model="published_at" class="w-full mt-1.5" />
                </div>

                <div>
                    <x-label for="expired_at">Auto-expire Date</x-label>
                    <x-input id="expired_at" type="datetime-local" wire:model="expired_at" class="w-full mt-1.5" />
                </div>
            </div>

            <!-- Media asset link -->
            <div class="border-t border-slate-50 pt-5">
                <x-label for="featured_image">Featured Image URL</x-label>
                <x-input id="featured_image" type="text" wire:model="featured_image" placeholder="Image URL..." class="w-full mt-1.5" />
            </div>

            <!-- Categories and Tags -->
            <div class="border-t border-slate-50 pt-5 space-y-4">
                <div>
                    <span class="text-xs font-bold text-slate-500 block mb-2">Categories</span>
                    <div class="space-y-1.5 max-h-36 overflow-y-auto pr-1">
                        @foreach($categoriesList as $cat)
                            <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                                <input type="checkbox" value="{{ $cat->id }}" wire:model="selectedCategories" class="rounded border-slate-200 text-indigo-600 focus:ring-indigo-500" />
                                <span>{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <x-label for="tagsCsv">Tags (Comma separated)</x-label>
                    <x-input id="tagsCsv" type="text" wire:model="tagsCsv" placeholder="e.g. guide, tips, finance" class="w-full mt-1.5" />
                </div>
            </div>

            <!-- SEO Configs -->
            <div class="border-t border-slate-50 pt-5">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">SEO Configuration</h4>
                <div class="space-y-4">
                    <div>
                        <x-label for="seo_title">SEO Title Override</x-label>
                        <x-input id="seo_title" type="text" wire:model="seo_title" placeholder="Meta title..." class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="seo_description">SEO Description</x-label>
                        <textarea id="seo_description" wire:model="seo_description" rows="3" placeholder="Page summary..." class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                </div>
            </div>

            <!-- Restore Revision history -->
            @if($revisions->count() > 0)
                <div class="border-t border-slate-50 pt-5 space-y-3">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Version History</h4>
                    <div class="max-h-40 overflow-y-auto space-y-2 pr-1">
                        @foreach($revisions as $rev)
                            <div class="flex items-center justify-between text-[11px] p-2 bg-slate-50 rounded-xl border border-slate-100">
                                <div>
                                    <span class="font-bold text-slate-700 block">Version #{{ $rev->version_number }}</span>
                                    <span class="text-slate-400">{{ $rev->created_at->diffForHumans() }}</span>
                                </div>
                                <button type="button" wire:click="restoreRevision('{{ $rev->id }}')" class="px-2 py-1 bg-white hover:bg-slate-100 border border-slate-200 rounded-lg font-bold text-slate-650 cursor-pointer">
                                    Restore
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="pt-5 border-t border-slate-100 flex items-center justify-end">
                <button type="button" wire:click="saveArticle" class="w-full py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow transition-all cursor-pointer">
                    Save Changes & Publish
                </button>
            </div>
        </div>
    </div>
</div>
