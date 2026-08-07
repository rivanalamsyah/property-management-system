<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 reveal">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Manajemen <span class="text-gradient-primary">Kamar Kos</span></h1>
            <p class="text-xs text-slate-500 mt-1">Kelola alokasi kamar, harga sewa, fasilitas, dan kode QR check-in penghuni.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" href="{{ route('rooms.create') }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kamar
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 reveal">
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Total Kamar</p>
            <h3 class="text-xl font-black text-slate-900 mt-1" data-counter="{{ $totalCount }}">{{ $totalCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Tersedia</p>
            <h3 class="text-xl font-black text-emerald-600 mt-1" data-counter="{{ $availableCount }}">{{ $availableCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Terisi</p>
            <h3 class="text-xl font-black text-indigo-600 mt-1" data-counter="{{ $occupiedCount }}">{{ $occupiedCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Okupansi</p>
            <h3 class="text-xl font-black text-slate-900 mt-1">{{ $occupancyRate }}<span class="text-sm font-bold text-slate-400">%</span></h3>
        </div>
        <div class="card-base card-hover p-4 col-span-2 md:col-span-1 lg:col-span-2 cursor-default">
            <p class="section-label mb-1">Pendapatan (Aktual / Potensi)</p>
            <h3 class="text-sm font-black text-slate-900 mt-1">
                Rp{{ number_format($currentRevenue, 0, ',', '.') }}
                <span class="text-slate-400 font-medium text-xs">/ Rp{{ number_format($monthlyRevenuePotential, 0, ',', '.') }}</span>
            </h3>
        </div>
    </div>

    <!-- Filters Section -->
    <x-card class="py-4 px-6">
        <div class="space-y-4">
            <div class="flex flex-col lg:flex-row items-center gap-4">
                <!-- Search -->
                <div class="flex-1 w-full relative">
                    <input wire:model.live.debounce.250ms="search" type="text"
                        class="w-full pl-10 pr-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="Cari berdasarkan nomor kamar, nama, atau kode...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <!-- Boarding House Select Filter -->
                <div class="w-full lg:w-56">
                    <select wire:model.live="filterBoardingHouse"
                        class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="">Semua Rumah Kos</option>
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="w-full lg:w-44">
                    <select wire:model.live="filterStatus"
                        class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="">Semua Status</option>
                        <option value="available">Tersedia</option>
                        <option value="occupied">Terisi</option>
                        <option value="reserved">Dipesan</option>
                        <option value="maintenance">Pemeliharaan</option>
                        <option value="cleaning">Pembersihan</option>
                        <option value="unavailable">Tidak Tersedia</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                </div>
            </div>

            <!-- Advanced Filter row: Price, Floor, Type -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 pt-3 border-t border-slate-50">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Tipe Kamar</label>
                    <select wire:model.live="filterType" class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        <option value="">Semua Tipe</option>
                        <option value="Standard">Standard</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Suite">Suite</option>
                        <option value="VIP">VIP</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Lantai</label>
                    <select wire:model.live="filterFloor" class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        <option value="">Semua Lantai</option>
                        <option value="1">Lantai 1</option>
                        <option value="2">Lantai 2</option>
                        <option value="3">Lantai 3</option>
                        <option value="4">Lantai 4</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Harga Min (IDR)</label>
                    <input wire:model.live.debounce.300ms="filterMinPrice" type="number" class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="misal: 500000">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Harga Max (IDR)</label>
                    <input wire:model.live.debounce.300ms="filterMaxPrice" type="number" class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="misal: 3000000">
                </div>
            </div>

            <!-- Facilities filter badges selection -->
            <div class="pt-3 border-t border-slate-50">
                <label class="block text-xs font-semibold text-slate-400 mb-2">Filter berdasarkan Fasilitas</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($allFacilities as $facility)
                        <label class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl border text-xs font-semibold cursor-pointer select-none transition {{ in_array($facility->id, $filterFacilities) ? 'bg-indigo-50 text-indigo-600 border-indigo-200' : 'bg-white border-slate-200 text-slate-650 hover:bg-slate-50' }}">
                            <input type="checkbox" wire:model.live="filterFacilities" value="{{ $facility->id }}" class="hidden">
                            <span>{{ $facility->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </x-card>

    <!-- Bulk Action floating bar (Sticky bottom) -->
    @if(count($selectedIds) > 0)
        <div class="fixed bottom-24 md:bottom-8 left-1/2 -translate-x-1/2 bg-slate-900/97 backdrop-blur-md border border-slate-700/60 shadow-2xl px-5 py-3 rounded-2xl flex items-center gap-4 z-[45] text-white animate-slide-up whitespace-nowrap">
            <div class="flex items-center gap-2">
                <div class="w-5 h-5 rounded-full bg-indigo-600 flex items-center justify-center text-[10px] font-black">{{ count($selectedIds) }}</div>
                <span class="text-xs font-semibold text-slate-300">dipilih</span>
            </div>

            <div class="h-4 w-px bg-slate-700"></div>

            <div class="flex items-center gap-2">
                <button class="px-3 py-1.5 text-xs font-bold text-slate-200 hover:text-white hover:bg-slate-700/80 rounded-xl transition-all border border-transparent hover:border-slate-600" wire:click="triggerBulkStatus">
                    Ganti Status
                </button>
                <button class="px-3 py-1.5 text-xs font-bold text-slate-200 hover:text-white hover:bg-slate-700/80 rounded-xl transition-all border border-transparent hover:border-slate-600" wire:click="exportSelected">
                    Ekspor CSV
                </button>
                <button class="px-3 py-1.5 text-xs font-bold text-rose-400 hover:text-rose-300 hover:bg-rose-900/30 rounded-xl transition-all border border-transparent hover:border-rose-800" wire:click="applyBulkDelete">
                    Hapus
                </button>
            </div>
        </div>
    @endif

    <!-- Data Table -->
    <x-card class="overflow-hidden p-0!">
        <x-table :headers="['Pilih', 'Kode Kamar', 'Detail Kamar', 'Rumah Kos', 'Sewa Bulanan', 'Status', 'Fasilitas', 'Aksi']">
            @forelse($rooms as $room)
                <tr class="hover:bg-slate-50/50 transition">
                    <!-- Checkbox select -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" wire:model.live="selectedIds" value="{{ $room->id }}"
                            class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 bg-slate-50/50 cursor-pointer">
                    </td>

                    <!-- Code / QR Code Thumb -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs font-mono font-semibold text-slate-500">
                        <div class="flex items-center gap-2">
                            @if($room->qr_code_path)
                                <img class="w-8 h-8 rounded border border-slate-100 bg-white" src="{{ asset('storage/' . $room->qr_code_path) }}" alt="QR">
                            @endif
                            <span>{{ $room->room_code }}</span>
                        </div>
                    </td>

                    <!-- Number & Name / Floor -->
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-slate-900">Kamar {{ $room->room_number }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $room->room_type }} • Lantai {{ $room->floor }} • {{ $room->room_size ?: '-' }}
                        </p>
                    </td>

                    <!-- Boarding house -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-650">
                        {{ $room->boardingHouse->name }}
                    </td>

                    <!-- Monthly Rent -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-800">
                        Rp{{ number_format($room->monthly_rent, 0, ',', '.') }}
                    </td>

                    <!-- Status badge -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $variant = 'neutral';
                            $statusText = 'Nonaktif';
                            if ($room->status === 'available') { $variant = 'success'; $statusText = 'Tersedia'; }
                            if ($room->status === 'occupied') { $variant = 'info'; $statusText = 'Terisi'; }
                            if ($room->status === 'reserved') { $variant = 'warning'; $statusText = 'Dipesan'; }
                            if ($room->status === 'maintenance') { $variant = 'danger'; $statusText = 'Pemeliharaan'; }
                            if ($room->status === 'cleaning') { $variant = 'danger'; $statusText = 'Pembersihan'; }
                            if ($room->status === 'unavailable') { $variant = 'danger'; $statusText = 'Tidak Tersedia'; }
                        @endphp
                        <x-badge :variant="$variant" class="uppercase text-[9px] px-2 py-0.5 font-bold">{{ $statusText }}</x-badge>
                    </td>

                    <!-- Facilities Icons / Badges preview -->
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1 max-w-[150px]">
                            @forelse($room->facilities->take(3) as $facItem)
                                <x-badge variant="neutral" class="text-[9px] py-0 px-1">{{ $facItem->name }}</x-badge>
                            @empty
                                <span class="text-[10px] text-slate-400 italic">Tidak ada</span>
                            @endforelse
                            @if($room->facilities->count() > 3)
                                <span class="text-[9px] text-slate-400 font-semibold">+{{ $room->facilities->count() - 3 }}</span>
                            @endif
                        </div>
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 transition cursor-pointer" onclick="window.location.href='{{ route('rooms.edit', $room->id) }}'" title="Atur Kamar" aria-label="Atur Kamar">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </x-button>
                            <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl text-rose-600 border border-slate-200 hover:border-rose-100 hover:bg-rose-50 cursor-pointer" wire:click="confirmDelete('{{ $room->id }}')" title="Hapus Kamar" aria-label="Hapus Kamar">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </x-button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-0">
                        <x-empty-state title="Belum ada kamar terdaftar" description="Mulai dengan membuat kamar di bawah properti aktif Anda untuk mengelola kontrak dan tagihan."></x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $rooms->links('components.pagination') }}
    </div>

    <!-- Single Delete Modal -->
    <x-modal wire:model="showDeleteModal" title="Hapus Kamar" maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-slate-500">
                Apakah Anda yakin ingin menghapus kamar ini? Semua aset gambar galeri dan tautan fasilitas akan dihapus. Tindakan ini tidak dapat dibatalkan dan kamar terisi yang memiliki pemesanan penghuni aktif tidak dapat dihapus.
            </p>
            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Batal</x-button>
                <x-button variant="danger" size="sm" type="button" wire:click="deleteRoom">Hapus Kamar</x-button>
            </div>
        </div>
    </x-modal>

    <!-- Bulk status modal -->
    <x-modal wire:model="showBulkStatusModal" title="Ubah Status Kamar Terpilih" maxWidth="md">
        <div class="space-y-4">
            <div>
                <label for="b_status" class="block text-sm font-medium text-slate-700 mb-1.5">Status Target Baru</label>
                <select wire:model="bulkStatus" id="b_status"
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                    <option value="available">Tersedia</option>
                    <option value="occupied">Terisi</option>
                    <option value="reserved">Dipesan</option>
                    <option value="maintenance">Pemeliharaan</option>
                    <option value="cleaning">Pembersihan</option>
                    <option value="unavailable">Tidak Tersedia</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>

            <p class="text-xs text-amber-600">
                <strong>Perhatian:</strong> Kamar yang terisi akan dilewati dari pembaruan ini untuk mencegah desinkronisasi tagihan penghuni.
            </p>

            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Batal</x-button>
                <x-button variant="primary" size="sm" type="button" wire:click="applyBulkStatus">Terapkan Perubahan</x-button>
            </div>
        </div>
    </x-modal>

</div>
