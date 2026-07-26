<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- LEFT: Main Editors Fields -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Page Title Card -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Editing Predefined Layout</span>
                <span class="text-[10px] bg-slate-100 text-slate-650 px-2 py-0.5 rounded-full font-bold uppercase">{{ $page->slug }}</span>
            </div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">{{ $page->name }} Page Sections</h2>
            <p class="text-xs text-slate-500 mt-1 leading-normal">Layout elements are locked by code. You can freely edit texts, URLs, and labels below.</p>
        </div>

        <!-- Sections Content Fields -->
        @foreach($page->sections as $sec)
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-50">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                        Section: {{ $sec->name }}
                    </h3>
                    <span class="text-[9px] bg-slate-50 border border-slate-150 text-slate-450 px-2 py-0.5 rounded-full font-semibold uppercase">{{ $sec->type }}</span>
                </div>

                <div class="space-y-4">
                    <!-- HERO OR GENERIC SECTION FIELDS -->
                    @if(isset($sectionsData[$sec->id]['heading']))
                        <div>
                            <x-label for="heading_{{ $sec->id }}">Heading Title</x-label>
                            <x-input id="heading_{{ $sec->id }}" type="text" wire:model="sectionsData.{{ $sec->id }}.heading" class="w-full mt-1.5" />
                        </div>
                    @endif

                    @if(isset($sectionsData[$sec->id]['subtitle']))
                        <div>
                            <x-label for="sub_{{ $sec->id }}">Subtitle / Excerpt</x-label>
                            <x-input id="sub_{{ $sec->id }}" type="text" wire:model="sectionsData.{{ $sec->id }}.subtitle" class="w-full mt-1.5" />
                        </div>
                    @endif

                    @if(isset($sectionsData[$sec->id]['body']))
                        <div>
                            <x-label for="body_{{ $sec->id }}">Body Paragraph / Description</x-label>
                            <textarea id="body_{{ $sec->id }}" wire:model="sectionsData.{{ $sec->id }}.body" rows="3" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                    @endif

                    <!-- CTA Buttons / Links -->
                    @if(isset($sectionsData[$sec->id]['button_label']))
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-label for="btn_lbl_{{ $sec->id }}">Button Label</x-label>
                                <x-input id="btn_lbl_{{ $sec->id }}" type="text" wire:model="sectionsData.{{ $sec->id }}.button_label" class="w-full mt-1.5" />
                            </div>
                            <div>
                                <x-label for="btn_url_{{ $sec->id }}">Button URL Link</x-label>
                                <x-input id="btn_url_{{ $sec->id }}" type="text" wire:model="sectionsData.{{ $sec->id }}.button_url" class="w-full mt-1.5" />
                            </div>
                        </div>
                    @endif

                    <!-- Pricing / Stat columns list mapping (if defined) -->
                    @if(isset($sectionsData[$sec->id]['features']) && is_array($sectionsData[$sec->id]['features']))
                        <div class="space-y-3 pt-3 border-t border-slate-50">
                            <span class="text-xs font-bold text-slate-500 block">Section Features / Lists</span>
                            @foreach($sectionsData[$sec->id]['features'] as $fIdx => $feat)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <div>
                                        <x-label>Feature Title</x-label>
                                        <x-input type="text" wire:model="sectionsData.{{ $sec->id }}.features.{{ $fIdx }}.title" class="w-full mt-1.5 bg-white" />
                                    </div>
                                    <div>
                                        <x-label>Feature Description</x-label>
                                        <x-input type="text" wire:model="sectionsData.{{ $sec->id }}.features.{{ $fIdx }}.description" class="w-full mt-1.5 bg-white" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- RIGHT: Sticky Config & Revision Actions Sidebar -->
    <div class="space-y-6">
        <!-- Sticky Editor Control Box -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-6 sticky top-6">
            <div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Publish settings</h3>
                <p class="text-[11px] text-slate-400 leading-normal mt-0.5">Control live indexing parameters.</p>
            </div>

            <!-- Page basic configs -->
            <div class="space-y-4">
                <div>
                    <x-label for="name">Page Label</x-label>
                    <x-input id="name" type="text" wire:model="name" class="w-full mt-1.5" />
                    <x-input-error for="name" class="mt-1" />
                </div>

                <div>
                    <x-label for="slug">URL Slug</x-label>
                    <x-input id="slug" type="text" wire:model="slug" class="w-full mt-1.5" />
                    <x-input-error for="slug" class="mt-1" />
                </div>

                <div>
                    <x-label for="status">Publish Status</x-label>
                    <select id="status" wire:model="status" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="scheduled">Scheduled</option>
                    </select>
                </div>
            </div>

            <div class="border-t border-slate-50 pt-5">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">SEO Management</h4>
                <div class="space-y-4">
                    <div>
                        <x-label for="seo_title">Meta Title Override</x-label>
                        <x-input id="seo_title" type="text" wire:model="seo_title" placeholder="Meta title..." class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="seo_description">Meta Description</x-label>
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
                <button type="button" wire:click="savePage" class="w-full py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow transition-all cursor-pointer">
                    Save Changes & Publish
                </button>
            </div>
        </div>
    </div>
</div>
