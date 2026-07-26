<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- LEFT: Main tree editor panel -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-5">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Structured Menu Tree</h3>
                <span class="text-[10px] bg-slate-100 text-slate-650 px-2 py-0.5 rounded-full font-bold uppercase">{{ $selectedSlug }}</span>
            </div>

            <!-- Items list -->
            <div class="space-y-4">
                @forelse($menuItems as $idx => $item)
                    <div class="border border-slate-150 rounded-2xl bg-slate-50/30 overflow-hidden">
                        
                        <!-- Parent header bar -->
                        <div class="p-3.5 bg-slate-50 flex items-center justify-between border-b border-slate-100">
                            <div>
                                <span class="font-bold text-slate-900 text-xs">{{ $item['label'] }}</span>
                                <span class="text-[10px] text-slate-400 font-mono ml-2">{{ $item['url'] }}</span>
                            </div>

                            <div class="flex items-center gap-1.5">
                                <!-- Position arrows -->
                                <button type="button" wire:click="moveItem({{ $idx }}, 'up')" class="p-1 hover:bg-slate-200 rounded-lg text-slate-450 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
                                </button>
                                <button type="button" wire:click="moveItem({{ $idx }}, 'down')" class="p-1 hover:bg-slate-200 rounded-lg text-slate-450 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                <div class="w-px h-3 bg-slate-200 mx-1"></div>

                                <!-- Delete -->
                                <button type="button" wire:click="removeMenuItem({{ $idx }})" class="p-1 hover:bg-rose-100 rounded-lg text-rose-600 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Nested Child sub-items -->
                        <div class="p-3.5 space-y-2 bg-white">
                            @if(!empty($item['children']))
                                <div class="space-y-1.5 pl-6 border-l-2 border-slate-100">
                                    @foreach($item['children'] as $cIdx => $child)
                                        <div class="flex items-center justify-between p-2 bg-slate-50 rounded-xl border border-slate-100 text-[11px] font-semibold text-slate-700">
                                            <div>
                                                <span>{{ $child['label'] }}</span>
                                                <span class="text-[9px] text-slate-400 font-mono ml-2">{{ $child['url'] }}</span>
                                            </div>
                                            <button type="button" wire:click="removeChildItem({{ $idx }}, {{ $cIdx }})" class="p-0.5 hover:bg-rose-100 rounded text-rose-600 cursor-pointer">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Form to add child -->
                            <div class="mt-3 pl-6 pt-3 border-t border-slate-50 grid grid-cols-1 sm:grid-cols-3 gap-2 items-end">
                                <div>
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Sub-Link Label</label>
                                    <input type="text" placeholder="Sub-Link..." class="w-full text-xs rounded-xl border-slate-200 bg-white py-1 px-2.5" 
                                        id="c_lbl_{{ $idx }}" />
                                </div>
                                <div>
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Sub-Link URL</label>
                                    <input type="text" placeholder="/url..." class="w-full text-xs rounded-xl border-slate-200 bg-white py-1 px-2.5" 
                                        id="c_url_{{ $idx }}" />
                                </div>
                                <button type="button" class="w-full py-1.5 bg-slate-150 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition cursor-pointer"
                                    onclick="@this.addChildItem({{ $idx }}, document.getElementById('c_lbl_{{ $idx }}').value, document.getElementById('c_url_{{ $idx }}').value); document.getElementById('c_lbl_{{ $idx }}').value=''; document.getElementById('c_url_{{ $idx }}').value='';">
                                    Add Sub-Link
                                </button>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="py-8 text-center text-slate-450 italic border border-dashed border-slate-200 rounded-2xl">This menu is currently empty. Add items using the sidebar control.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- RIGHT: Selector and Add control -->
    <div class="space-y-6">
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-6 sticky top-6">
            <div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Menu selection</h3>
                <p class="text-[11px] text-slate-400 leading-normal mt-0.5">Choose target and append new nodes.</p>
            </div>

            <!-- Selection dropdown -->
            <div>
                <x-label for="selectedSlug">Active Menu Structure</x-label>
                <select id="selectedSlug" wire:model.live="selectedSlug" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="header_menu">Header Menu</option>
                    <option value="footer_menu">Footer Menu</option>
                    <option value="quick_links">Footer Quick Links</option>
                    <option value="social_links">Social Links</option>
                </select>
            </div>

            <!-- Form: Add top-level link -->
            <div class="pt-5 border-t border-slate-50 space-y-4">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Add Top-Level Link</span>
                
                <div>
                    <x-label for="newItemLabel">Link Label</x-label>
                    <x-input id="newItemLabel" type="text" wire:model="newItemLabel" placeholder="e.g. FAQ" class="w-full mt-1.5" />
                    <x-input-error for="newItemLabel" class="mt-1" />
                </div>

                <div>
                    <x-label for="newItemUrl">Destination Link URL</x-label>
                    <x-input id="newItemUrl" type="text" wire:model="newItemUrl" placeholder="e.g. /faq or http://..." class="w-full mt-1.5" />
                    <x-input-error for="newItemUrl" class="mt-1" />
                </div>

                <div>
                    <x-label for="newItemTarget">Open Behavior</x-label>
                    <select id="newItemTarget" wire:model="newItemTarget" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm">
                        <option value="_self">Same Tab (_self)</option>
                        <option value="_blank">New Tab (_blank)</option>
                    </select>
                </div>

                <button type="button" wire:click="addMenuItem" class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                    Append Node
                </button>
            </div>

            <div class="pt-5 border-t border-slate-100 flex items-center justify-end">
                <button type="button" wire:click="saveMenu" class="w-full py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow transition-all cursor-pointer">
                    Save Menu Layout
                </button>
            </div>
        </div>
    </div>
</div>
