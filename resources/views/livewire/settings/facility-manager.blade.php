<div class="space-y-6">
    
    <!-- Title & Action -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Katalog Fasilitas</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola fasilitas bawaan sistem dan kustom untuk kamar dan properti kos.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" wire:click="openCreateModal">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Fasilitas
                </span>
            </x-button>
        </div>
    </div>

    <!-- Filters Section -->
    <x-card class="py-4 px-6 mb-6">
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <!-- Search -->
            <div class="flex-1 w-full relative">
                <input wire:model.live.debounce.250ms="search" type="text"
                    class="w-full pl-10 pr-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                    placeholder="Cari berdasarkan nama atau deskripsi fasilitas...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="w-full sm:w-48">
                <select wire:model.live="filterCategory"
                    class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                    <option value="">Semua Kategori</option>
                    <option value="Room">Kamar</option>
                    <option value="General">Umum</option>
                    <option value="Security">Keamanan</option>
                    <option value="Shared">Bersama</option>
                </select>
            </div>
        </div>
    </x-card>

    <!-- Table List -->
    <x-table :headers="['Urutan', 'Ikon', 'Nama Fasilitas', 'Kategori', 'Cakupan', 'Status', 'Aksi']">
        @forelse($facilities as $facility)
            <tr class="hover:bg-slate-50/50 transition">
                <!-- Sorting Display Order -->
                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-400">
                    <div class="flex items-center gap-1">
                        <button wire:click="moveUp({{ $facility->id }})" class="p-1 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded transition cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                        </button>
                        <button wire:click="moveDown({{ $facility->id }})" class="p-1 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded transition cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <span class="ml-2">{{ $facility->display_order }}</span>
                    </div>
                </td>

                <!-- Icon -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                        <!-- Simple visual text fallback or icon maps -->
                        @if($facility->icon === 'wifi')
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10.5 10.5 0 0114.14 0M1.414 7.929a16 16 0 0121.172 0"></path></svg>
                        @elseif($facility->icon === 'tv')
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                        @elseif($facility->icon === 'parking')
                            <span class="text-xs">P</span>
                        @elseif($facility->icon === 'bath')
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        @else
                            <span class="text-xs uppercase">{{ substr($facility->icon, 0, 2) }}</span>
                        @endif
                    </div>
                </td>

                <!-- Name & Description -->
                <td class="px-6 py-4">
                    <p class="text-sm font-semibold text-slate-800">{{ $facility->name }}</p>
                    @if($facility->description)
                        <p class="text-xs text-slate-400 truncate max-w-xs mt-0.5">{{ $facility->description }}</p>
                    @endif
                </td>

                <!-- Category -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                    {{ $facility->category }}
                </td>

                <!-- Scope -->
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if($facility->tenant_id === null)
                        <x-badge variant="info">Bawaan Sistem</x-badge>
                    @else
                        <x-badge variant="neutral">Kustom Ruang Kerja</x-badge>
                    @endif
                </td>

                <!-- Status -->
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if($facility->tenant_id !== null)
                        <button wire:click="toggleStatus({{ $facility->id }})" class="cursor-pointer">
                            <x-badge :variant="$facility->is_active ? 'success' : 'danger'">
                                {{ $facility->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </x-badge>
                        </button>
                    @else
                        <x-badge variant="success">Aktif</x-badge>
                    @endif
                </td>

                <!-- Actions -->
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center gap-2">
                        @if($facility->tenant_id !== null)
                            <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 transition cursor-pointer" wire:click="editFacility({{ $facility->id }})" title="Ubah Fasilitas" aria-label="Ubah Fasilitas">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </x-button>
                            <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl text-rose-600 border border-slate-200 hover:border-rose-100 hover:bg-rose-50 cursor-pointer" wire:click="confirmDelete({{ $facility->id }})" title="Hapus Fasilitas" aria-label="Hapus Fasilitas">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </x-button>
                        @else
                             <span class="text-xs text-slate-400 italic">Terkunci</span>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="p-0">
                    <x-empty-state title="Fasilitas tidak ditemukan" description="Buat fasilitas kustom untuk kamar atau properti kos Anda."></x-empty-state>
                </td>
            </tr>
        @endforelse
    </x-table>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $facilities->links('components.pagination') }}
    </div>

    <!-- Form Modal -->
    <x-modal wire:model="showFormModal" title="{{ $facilityId ? 'Ubah Fasilitas Kustom' : 'Buat Fasilitas Kustom' }}" maxWidth="md">
        <form wire:submit="saveFacility" class="space-y-4">
            <!-- Facility Name -->
            <div>
                <label for="fac_name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Fasilitas</label>
                <input wire:model="name" id="fac_name" type="text" required
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                    placeholder="cth. Wi-Fi Kecepatan Tinggi, Kamar Mandi Dalam">
                @error('name')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Icon & Category -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="fac_icon" class="block text-sm font-medium text-slate-700 mb-1.5">Ikon Visual</label>
                    <select wire:model="icon" id="fac_icon"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="wifi">Gelombang WiFi</option>
                        <option value="tv">TV / Monitor</option>
                        <option value="bath">Kamar Mandi / Shower</option>
                        <option value="parking">Tempat Parkir</option>
                        <option value="key">Kunci Jam Malam</option>
                    </select>
                    @error('icon')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="fac_category" class="block text-sm font-medium text-slate-700 mb-1.5">Kategori</label>
                    <select wire:model="category" id="fac_category"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="Room">Khusus Kamar</option>
                        <option value="General">Fasilitas Umum</option>
                        <option value="Security">Pengaturan Keamanan</option>
                        <option value="Shared">Ruang Bersama</option>
                    </select>
                    @error('category')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="fac_description" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                <textarea wire:model="description" id="fac_description" rows="3"
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                    placeholder="Ringkasan singkat karakteristik fasilitas ini..."></textarea>
                @error('description')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Active Status checkbox -->
            <div class="flex items-center">
                <input wire:model="is_active" id="fac_active" type="checkbox"
                    class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 bg-slate-50/50">
                <label for="fac_active" class="ml-2 block text-sm text-slate-700 select-none">
                    Tandai fasilitas kustom ini sebagai aktif
                </label>
            </div>

            <!-- Actions footer -->
            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Batal</x-button>
                <x-button variant="primary" size="sm" type="submit" loading="saveFacility">Simpan</x-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal wire:model="showDeleteModal" title="Hapus Fasilitas Kustom" maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-slate-500">
                Apakah Anda yakin ingin menghapus fasilitas kustom ini? Alokasi kamar dan halaman publik yang merujuknya akan dilepas. Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Batal</x-button>
                <x-button variant="danger" size="sm" type="button" wire:click="deleteFacility">Hapus</x-button>
            </div>
        </div>
    </x-modal>

</div>
