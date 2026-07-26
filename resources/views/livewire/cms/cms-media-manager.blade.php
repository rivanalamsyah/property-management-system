<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    
    <!-- LEFT COLUMN: Folders Navigation -->
    <div class="space-y-6">
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Folders Directory</span>
            <div class="space-y-1">
                @foreach($folders as $f)
                    <button wire:click="$set('folder', '{{ $f }}')" class="w-full text-left px-3 py-2 text-xs font-semibold rounded-xl transition cursor-pointer flex items-center gap-2
                        {{ $folder === $f ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }}
                    ">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                        {{ $f === '/' ? 'Root' : ltrim($f, '/') }}
                    </button>
                @endforeach
            </div>

            <!-- New Folder trigger -->
            <div class="pt-4 border-t border-slate-50">
                <x-label for="new_folder">Add Folder Path</x-label>
                <div class="flex items-center gap-2 mt-1.5">
                    <x-input id="new_folder" type="text" placeholder="e.g. /blog" class="w-full text-xs" 
                        onkeydown="if(event.key === 'Enter') { @this.set('folder', this.value); this.value = ''; }" />
                </div>
            </div>
        </div>
    </div>

    <!-- MIDDLE COLUMN: Media Library Grid list -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Actions & Upload block -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-5">
            <h3 class="text-base font-bold text-slate-900 tracking-tight">Upload Media Assets</h3>
            
            <form wire:submit.prevent="uploadMedia" class="space-y-4">
                <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-3xl hover:border-indigo-400 transition cursor-pointer relative">
                    <input type="file" wire:model="upload_file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*,.svg,.pdf" />
                    <div class="space-y-1 text-center pointer-events-none">
                        <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-slate-600">
                            <span class="font-semibold text-indigo-600">Click to upload assets</span>
                        </div>
                        <p class="text-[10px] text-slate-400">PNG, JPG, SVG, or PDF (Max 10MB)</p>
                    </div>
                </div>

                @if($upload_file)
                    <div class="flex items-center justify-between text-xs p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="font-medium text-slate-650 truncate max-w-[200px]">{{ $upload_file->getClientOriginalName() }}</span>
                        <div class="flex items-center gap-3">
                            <x-input type="text" wire:model="alt_text" placeholder="Alt text..." class="text-xs max-w-[120px]" />
                            <button type="submit" class="px-3 py-1.5 bg-indigo-650 text-white font-bold rounded-xl hover:bg-indigo-750 transition cursor-pointer">Upload</button>
                        </div>
                    </div>
                @endif
            </form>
        </div>

        <!-- Files list -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Active Assets</span>
                <x-input type="text" wire:model.live.debounce.300ms="search" placeholder="Search filenames..." class="text-xs max-w-[180px]" />
            </div>

            <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
                @forelse($mediaList as $media)
                    <div wire:click="selectMedia('{{ $media->id }}')" class="group relative bg-slate-50 border rounded-2xl p-2 cursor-pointer flex flex-col justify-between hover:border-indigo-400 transition
                        {{ $selectedMediaId === $media->id ? 'border-indigo-600 bg-indigo-50/20' : 'border-slate-100' }}
                    ">
                        <!-- Thumbnail preview or file icon -->
                        @if(Str::startsWith($media->mime_type, 'image/'))
                            <img src="{{ $media->file_url }}" alt="{{ $media->alt_text }}" class="h-20 w-full object-cover rounded-xl" />
                        @else
                            <div class="h-20 w-full rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                        @endif

                        <div class="mt-2 text-[10px] text-slate-700 truncate font-semibold">{{ $media->filename }}</div>
                        <div class="text-[9px] text-slate-400 font-medium">{{ round($media->file_size / 1024, 1) }} KB</div>
                    </div>
                @empty
                    <div class="col-span-4 py-8 text-center text-slate-400 italic">No assets inside this folder.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Selected media detail editor & replacer -->
    <div class="space-y-6">
        @if($selectedMedia)
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Asset Metadata</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5 leading-normal">Details for selected file.</p>
                </div>

                <div class="space-y-4">
                    <!-- File details -->
                    <div class="text-xs space-y-1.5 p-3.5 bg-slate-50 border border-slate-100 rounded-2xl font-semibold">
                        <div class="flex justify-between"><span class="text-slate-400">Mime:</span> <span class="text-slate-700">{{ $selectedMedia->mime_type }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Size:</span> <span class="text-slate-700 font-mono">{{ round($selectedMedia->file_size / 1024) }} KB</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Path:</span> <span class="text-slate-700 truncate max-w-[120px]">{{ $selectedMedia->filepath }}</span></div>
                    </div>

                    <!-- Alt Text edit -->
                    <div>
                        <x-label for="alt_text">Alt Text (Accessibility)</x-label>
                        <div class="flex items-center gap-2 mt-1.5">
                            <x-input id="alt_text" type="text" wire:model="alt_text" class="w-full text-xs" />
                            <button type="button" wire:click="updateAltText" class="px-3 py-2 bg-indigo-650 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition cursor-pointer">Save</button>
                        </div>
                    </div>

                    <!-- Replace file -->
                    <div class="pt-4 border-t border-slate-50 space-y-2">
                        <x-label for="replace_file">Replace Source File</x-label>
                        <p class="text-[10px] text-slate-400 leading-normal">Overwrites the physical asset on disk, keeping the same reference ID across sections.</p>
                        
                        <div class="flex items-center gap-2 mt-1.5 relative border border-slate-200 rounded-xl p-2 bg-slate-50 hover:border-indigo-400 transition cursor-pointer">
                            <input type="file" wire:model="replace_file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                            <span class="text-[11px] font-bold text-indigo-650">Choose replacement...</span>
                        </div>

                        @if($replace_file)
                            <div class="flex items-center justify-between text-[10px] bg-indigo-50 border border-indigo-100 rounded-xl p-2 mt-2">
                                <span class="text-indigo-950 font-bold truncate max-w-[120px]">{{ $replace_file->getClientOriginalName() }}</span>
                                <button type="button" wire:click="replaceMedia" class="px-2 py-1 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition cursor-pointer">Apply</button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-5 border-t border-slate-100 flex items-center justify-between">
                    <button type="button" wire:click="deleteMedia('{{ $selectedMedia->id }}')" wire:confirm="Are you sure you want to delete this media asset?" class="w-full py-2 bg-rose-50 border border-rose-100 text-rose-700 hover:bg-rose-100 rounded-xl text-xs font-semibold shadow transition-all cursor-pointer">
                        Delete Asset
                    </button>
                </div>
            </div>
        @else
            <div class="bg-white border border-slate-100 border-dashed rounded-3xl p-8 text-center text-slate-400 italic">
                Select an asset from the grid to view details and editing controls.
            </div>
        @endif
    </div>
</div>
