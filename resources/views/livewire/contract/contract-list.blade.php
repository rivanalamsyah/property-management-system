<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 reveal">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Kontrak <span class="text-gradient-primary">Hunian</span></h1>
            <p class="text-xs text-slate-500 mt-1">Kelola perjanjian sewa, estimasi biaya, perpanjangan, dan riwayat versi kontrak.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" href="{{ route('contracts.create') }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Buat Kontrak Baru
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 reveal">
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Total Kontrak</p>
            <h3 class="text-xl font-black text-slate-900 mt-1" data-counter="{{ $totalCount }}">{{ $totalCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Draft</p>
            <h3 class="text-xl font-black text-slate-500 mt-1" data-counter="{{ $draftCount }}">{{ $draftCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Kontrak Aktif</p>
            <h3 class="text-xl font-black text-emerald-600 mt-1" data-counter="{{ $activeCount }}">{{ $activeCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Segera Berakhir</p>
            <h3 class="text-xl font-black text-amber-600 mt-1" data-counter="{{ $expiringCount }}">{{ $expiringCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Pendapatan Bulanan</p>
            <p class="text-sm font-black text-indigo-700 mt-1">Rp{{ number_format($revenue, 0, ',', '.') }}</p>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Rata-rata Durasi</p>
            <h3 class="text-xl font-black text-slate-900 mt-1">{{ $avgDuration ?: '—' }} <span class="text-xs font-medium text-slate-400">bln</span></h3>
        </div>
    </div>

    <!-- Filters Section -->
    <x-card :glass="true" padding="sm">
        <div class="space-y-3">
            <div class="flex flex-col md:flex-row items-center gap-3">
                <!-- Search -->
                <div class="flex-1 w-full relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input wire:model.live.debounce.250ms="search" type="text"
                        class="input-base input-with-icon"
                        placeholder="Cari nomor kontrak, penghuni, properti, atau kamar...">
                </div>

                <!-- Property Filter -->
                <div class="w-full md:w-52">
                    <select wire:model.live="filterBoardingHouse" class="input-base">
                        <option value="">Semua Properti</option>
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="w-full md:w-44">
                    <select wire:model.live="filterStatus" class="input-base">
                        <option value="">Semua Status</option>
                        <option value="draft">Draft</option>
                        <option value="pending_approval">Menunggu Persetujuan</option>
                        <option value="active">Aktif</option>
                        <option value="expiring_soon">Segera Berakhir</option>
                        <option value="renewed">Diperbarui (Arsip)</option>
                        <option value="completed">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                        <option value="terminated">Dihentikan</option>
                        <option value="expired">Kadaluarsa</option>
                    </select>
                </div>
            </div>

            <!-- Date Range Filters -->
            <div class="flex flex-wrap items-center gap-4 pt-1 border-t border-slate-100/60">
                <div class="flex items-center gap-2">
                    <span class="section-label whitespace-nowrap">Tanggal Mulai:</span>
                    <input wire:model.live="filterStartDate" type="date"
                           class="px-2.5 py-1.5 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400">
                </div>
                <div class="flex items-center gap-2">
                    <span class="section-label whitespace-nowrap">Tanggal Berakhir:</span>
                    <input wire:model.live="filterEndDate" type="date"
                           class="px-2.5 py-1.5 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400">
                </div>
            </div>
        </div>
    </x-card>

    <!-- Data Table -->
    <div class="reveal">
        <x-table :headers="['No. Kontrak', 'Penghuni', 'Properti', 'Tipe', 'Periode', 'Sewa/Bulan', 'Status', 'Aksi']" :stickyHeader="true">
            @forelse($contracts as $ctr)
                <tr class="group transition-colors duration-100">
                    <!-- Number -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="No. Kontrak">
                        <span class="text-xs font-mono font-bold text-slate-800 bg-slate-100/60 px-2 py-0.5 rounded-lg">{{ $ctr->contract_number }}</span>
                    </td>

                    <!-- Resident -->
                    <td class="px-5 py-3.5" data-label="Penghuni">
                        <p class="text-xs font-bold text-slate-900">{{ $ctr->resident->name }}</p>
                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">NIK: {{ $ctr->resident->nik }}</p>
                    </td>

                    <!-- Property -->
                    <td class="px-5 py-3.5" data-label="Properti">
                        <p class="text-xs font-semibold text-slate-700">{{ $ctr->boardingHouse->name }}</p>
                        <p class="text-[10px] font-mono text-indigo-500 mt-0.5">Kamar {{ $ctr->room ? $ctr->room->room_number : '—' }}</p>
                    </td>

                    <!-- Type -->
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs text-slate-500 font-semibold" data-label="Tipe">
                        {{ $ctr->contract_type->label() }}
                    </td>

                    <!-- Dates -->
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs text-slate-600" data-label="Periode">
                        <div class="flex flex-col gap-0.5">
                            <span>{{ $ctr->start_date->format('d M Y') }}</span>
                            <span class="text-slate-400">— {{ $ctr->end_date->format('d M Y') }}</span>
                        </div>
                    </td>

                    <!-- Monthly Rent -->
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs font-bold text-slate-900" data-label="Sewa/Bulan">
                        Rp{{ number_format($ctr->monthly_rent, 0, ',', '.') }}
                    </td>

                    <!-- Status -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Status">
                        @php
                            $variant = 'neutral';
                            if ($ctr->status->value === 'active') $variant = 'success';
                            if ($ctr->status->value === 'pending_approval') $variant = 'info';
                            if ($ctr->status->value === 'expiring_soon') $variant = 'warning';
                            if (in_array($ctr->status->value, ['expired', 'terminated', 'cancelled'])) $variant = 'danger';
                        @endphp
                        <x-badge :variant="$variant" :dot="$ctr->status->value === 'active'">{{ $ctr->status->label() }}</x-badge>
                    </td>

                    <!-- Actions -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Aksi">
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('contracts.show', $ctr->id) }}"
                               class="inline-flex items-center justify-center w-7 h-7 rounded-xl border border-slate-200/80 bg-white hover:bg-indigo-50 hover:border-indigo-200 text-slate-500 hover:text-indigo-600 transition-all shadow-2xs active:scale-90"
                               title="Lihat Kontrak">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </a>
                            @if($ctr->status->value === 'draft')
                                <a href="{{ route('contracts.edit', $ctr->id) }}"
                                   class="inline-flex items-center justify-center w-7 h-7 rounded-xl border border-slate-200/80 bg-white hover:bg-slate-50 hover:border-slate-300 text-slate-500 hover:text-slate-700 transition-all shadow-2xs active:scale-90"
                                   title="Edit Kontrak">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                            @endif
                            @can('delete', $ctr)
                                <button wire:click="confirmDelete('{{ $ctr->id }}')"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-xl border border-slate-200/80 bg-white hover:bg-rose-50 hover:border-rose-200 text-slate-400 hover:text-rose-600 transition-all shadow-2xs active:scale-90 cursor-pointer"
                                        title="Hapus Draft">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-0">
                        <x-empty-state
                            icon="folder"
                            title="Belum ada kontrak yang dibuat"
                            description="Buat perjanjian sewa baru, hitung biaya sewa, dan cetak dokumen legal PDF.">
                            <x-button variant="primary" size="sm" href="{{ route('contracts.create') }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Buat Kontrak Pertama
                            </x-button>
                        </x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>

        <!-- Pagination -->
        <div class="mt-4 px-1">
            {{ $contracts->links('components.pagination') }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal wire:model="showDeleteModal" title="Hapus Draft Kontrak" maxWidth="md">
        <div class="space-y-4">
            <div class="flex items-start gap-3 p-4 bg-rose-50/60 border border-rose-100 rounded-2xl">
                <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-rose-800">Hapus Kontrak Draft?</p>
                    <p class="text-xs text-rose-700 mt-1 leading-relaxed">Semua estimasi biaya dan riwayat timeline akan dihapus permanen. Kontrak yang sudah aktif tidak dapat dihapus.</p>
                </div>
            </div>
            <div class="flex justify-end gap-2.5 pt-1">
                <x-button variant="outline" size="sm" @click="show = false">Batal</x-button>
                <x-button variant="danger" size="sm" wire:click="deleteContract">Hapus Draft</x-button>
            </div>
        </div>
    </x-modal>

</div>
