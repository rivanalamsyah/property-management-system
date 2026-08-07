<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 reveal">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Properti <span class="text-gradient-primary">Kos</span></h1>
            <p class="text-xs text-slate-500 mt-1">Kelola profil, galeri, fasilitas, dan peraturan untuk seluruh properti kos di ruang kerja Anda.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" href="{{ route('boarding-houses.create') }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Properti
            </x-button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 reveal">
        <div class="card-base card-hover p-5 cursor-default">
            <p class="section-label mb-1">Total Properti</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1" data-counter="{{ $totalCount }}">{{ $totalCount }}</h3>
        </div>
        <div class="card-base card-hover p-5 cursor-default">
            <p class="section-label mb-1">Aktif</p>
            <h3 class="text-2xl font-black text-emerald-600 mt-1" data-counter="{{ $activeCount }}">{{ $activeCount }}</h3>
        </div>
        <div class="card-base card-hover p-5 cursor-default">
            <p class="section-label mb-1">Penuh Terisi</p>
            <h3 class="text-2xl font-black text-indigo-600 mt-1" data-counter="{{ $fullCount }}">{{ $fullCount }}</h3>
        </div>
        <div class="card-base card-hover p-5 cursor-default">
            <p class="section-label mb-1">Tidak Aktif</p>
            <h3 class="text-2xl font-black text-rose-500 mt-1" data-counter="{{ $inactiveCount }}">{{ $inactiveCount }}</h3>
        </div>
    </div>

    <!-- Filters Section -->
    <x-card :glass="true" padding="sm">
        <div class="flex flex-col sm:flex-row items-center gap-3">
            <!-- Search -->
            <div class="flex-1 w-full relative">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input wire:model.live.debounce.250ms="search" type="text"
                    class="input-base input-with-icon"
                    placeholder="Cari berdasarkan nama, alamat, atau kota...">
            </div>

            <!-- Status Filter -->
            <div class="w-full sm:w-40">
                <select wire:model.live="filterStatus" class="input-base">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="full">Penuh</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>

            <!-- City Filter -->
            <div class="w-full sm:w-44">
                <select wire:model.live="filterCity" class="input-base">
                    <option value="">Semua Kota</option>
                    @foreach($cities as $cityItem)
                        <option value="{{ $cityItem }}">{{ $cityItem }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </x-card>

    <!-- Property Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 reveal">
        @forelse($boardingHouses as $house)
            <div class="card-base card-hover overflow-hidden flex flex-col group">
                <!-- Cover Image -->
                <div class="h-48 relative bg-slate-100 overflow-hidden">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         src="{{ $house->cover_image ? asset('storage/' . $house->cover_image) : asset('assets/images/property/default_cover.png') }}"
                         alt="{{ $house->name }}"
                         onerror="this.src='https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80'">

                    <!-- Gradient overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/10 to-transparent pointer-events-none"></div>

                    <!-- Logo overlay -->
                    @if($house->logo)
                        <div class="absolute bottom-3 left-3 w-11 h-11 rounded-xl bg-white/95 backdrop-blur-sm shadow-md p-1.5 flex items-center justify-center border border-white/60">
                            <img class="max-w-full max-h-full object-contain rounded-lg" src="{{ asset('storage/' . $house->logo) }}" alt="Logo">
                        </div>
                    @endif

                    <!-- Status & Visibility Badges -->
                    <div class="absolute top-3 right-3 flex flex-col gap-1.5 items-end">
                        @php
                            $statusVariant = 'neutral';
                            if ($house->status === 'active') $statusVariant = 'success';
                            if ($house->status === 'full') $statusVariant = 'info';
                            if ($house->status === 'inactive') $statusVariant = 'danger';
                        @endphp
                        <x-badge :variant="$statusVariant" class="shadow-sm">{{ ucfirst($house->status) }}</x-badge>
                        <x-badge :variant="$house->is_public ? 'info' : 'neutral'" class="shadow-sm">
                            {{ $house->is_public ? 'Publik' : 'Privat' }}
                        </x-badge>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex-1">
                        <h3 class="text-sm font-bold text-slate-900 line-clamp-1 group-hover:text-indigo-600 transition-colors duration-200">{{ $house->name }}</h3>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mt-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $house->city }}, {{ $house->province }}
                        </p>
                        <p class="text-[11px] text-slate-400 mt-2.5 line-clamp-2">{{ $house->address }}</p>

                        <div class="flex items-center gap-4 mt-4 py-3 border-y border-slate-100/80 text-slate-600">
                            <div class="flex items-center gap-1 text-xs">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                <span><strong>{{ $house->facilities_count }}</strong> Fasilitas</span>
                            </div>
                            <div class="flex items-center gap-1 text-xs">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span><strong>{{ $house->rules_count }}</strong> Peraturan</span>
                            </div>
                            <div class="flex items-center gap-1 text-xs">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span><strong>{{ $house->galleries_count }}</strong> Foto</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex items-center gap-2 mt-4">
                        <a href="{{ route('boarding-houses.edit', $house->id) }}"
                           class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200/80 hover:border-slate-300 rounded-xl transition-all active:scale-95">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Konfigurasi
                        </a>
                        @can('delete', $house)
                            <button wire:click="confirmDelete('{{ $house->id }}')"
                                    class="flex items-center justify-center w-9 h-9 text-slate-400 hover:text-rose-600 bg-white hover:bg-rose-50 border border-slate-200/80 hover:border-rose-200 rounded-xl transition-all active:scale-90 cursor-pointer shadow-2xs"
                                    title="Hapus Properti">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <x-empty-state
                    icon="room"
                    title="Belum ada properti kos"
                    description="Mulai dengan membuat properti kos baru untuk mengelola pengaturan, kamar, peraturan, dan fasilitas.">
                    <x-button variant="primary" size="sm" href="{{ route('boarding-houses.create') }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Properti Pertama
                    </x-button>
                </x-empty-state>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 px-1">
        {{ $boardingHouses->links('components.pagination') }}
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal wire:model="showDeleteModal" title="Hapus Properti Kos" maxWidth="md">
        <div class="space-y-4">
            <div class="flex items-start gap-3 p-4 bg-rose-50/60 border border-rose-100 rounded-2xl">
                <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-rose-800">Hapus Properti Kos?</p>
                    <p class="text-xs text-rose-700 mt-1 leading-relaxed">Semua pengaturan, alokasi kamar, peraturan aktif, dan galeri foto akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>
            <div class="flex justify-end gap-2.5 pt-1">
                <x-button variant="outline" size="sm" @click="show = false">Batal</x-button>
                <x-button variant="danger" size="sm" wire:click="deleteBoardingHouse">Hapus Properti</x-button>
            </div>
        </div>
    </x-modal>

</div>
