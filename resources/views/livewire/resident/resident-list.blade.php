<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 reveal">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Penghuni &amp; <span class="text-gradient-primary">Penyewa</span></h1>
            <p class="text-xs text-slate-500 mt-1">Kelola profil penghuni kos, riwayat check-in, kontak darurat, dan status hunian.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" href="{{ route('residents.create') }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Tambah Penghuni
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 reveal">
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Total Data</p>
            <h3 class="text-xl font-black text-slate-900 mt-1" data-counter="{{ $totalCount }}">{{ $totalCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Aktif</p>
            <h3 class="text-xl font-black text-emerald-600 mt-1" data-counter="{{ $activeCount }}">{{ $activeCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Reserved (DP)</p>
            <h3 class="text-xl font-black text-indigo-600 mt-1" data-counter="{{ $reservedCount }}">{{ $reservedCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Terlambat Bayar</p>
            <h3 class="text-xl font-black text-amber-600 mt-1" data-counter="{{ $latePaymentCount }}">{{ $latePaymentCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Tingkat Hunian</p>
            <h3 class="text-xl font-black text-slate-900 mt-1">{{ $occupancyRate }}<span class="text-sm font-bold text-slate-400">%</span></h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Rata-rata Masa Huni</p>
            <h3 class="text-xl font-black text-slate-900 mt-1">{{ $avgStay ?: '—' }} <span class="text-xs font-medium text-slate-400">hari</span></h3>
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
                    placeholder="Cari nama, NIK, nomor HP, atau kamar...">
            </div>

            <!-- Property Filter -->
            <div class="w-full sm:w-52">
                <select wire:model.live="filterBoardingHouse" class="input-base">
                    <option value="">Semua Properti</option>
                    @foreach($boardingHouses as $house)
                        <option value="{{ $house->id }}">{{ $house->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="w-full sm:w-44">
                <select wire:model.live="filterStatus" class="input-base">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu Review</option>
                    <option value="reserved">Reserved</option>
                    <option value="active">Aktif</option>
                    <option value="late_payment">Terlambat Bayar</option>
                    <option value="moving_out">Proses Pindah</option>
                    <option value="former">Mantan Penyewa</option>
                    <option value="blacklisted">Daftar Hitam</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
        </div>
    </x-card>

    <!-- Data Table -->
    <div class="reveal">
        <x-table :headers="['Foto', 'Identitas Penghuni', 'Properti', 'Kamar', 'No. HP', 'Status', 'Aksi']" :stickyHeader="true">
            @forelse($residents as $res)
                <tr class="group transition-colors duration-100">
                    <!-- Photo -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Foto">
                        <img class="h-9 w-9 rounded-xl object-cover bg-slate-100 border-2 border-white ring-1 ring-slate-200/60 shadow-xs group-hover:ring-indigo-200/60 transition-all"
                             src="{{ $res->photo ? asset('storage/' . $res->photo) : asset('assets/images/avatars/resident_' . ($res->gender === 'female' ? 'female' : 'male') . '.png') }}"
                             alt="{{ $res->name }}"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($res->name) }}&background=e0e7ff&color=4f46e5&size=64'">
                    </td>

                    <!-- Identity -->
                    <td class="px-5 py-3.5" data-label="Identitas">
                        <p class="text-xs font-bold text-slate-900">{{ $res->name }}</p>
                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">NIK: {{ $res->nik }}</p>
                    </td>

                    <!-- Boarding House -->
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs font-semibold text-slate-600" data-label="Properti">
                        {{ $res->boardingHouse ? $res->boardingHouse->name : '—' }}
                    </td>

                    <!-- Room -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Kamar">
                        @if($res->room)
                            <x-badge variant="info">Kamar {{ $res->room->room_number }}</x-badge>
                        @else
                            <span class="text-slate-400 italic text-[10px]">Belum ditentukan</span>
                        @endif
                    </td>

                    <!-- Contact -->
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs text-slate-600 font-medium" data-label="No. HP">
                        {{ $res->phone }}
                    </td>

                    <!-- Status -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Status">
                        @php
                            $variant = 'neutral';
                            if ($res->status->value === 'active') $variant = 'success';
                            if ($res->status->value === 'reserved') $variant = 'info';
                            if ($res->status->value === 'late_payment') $variant = 'warning';
                            if ($res->status->value === 'former' || $res->status->value === 'blacklisted') $variant = 'danger';
                        @endphp
                        <x-badge :variant="$variant" :dot="true">{{ $res->status->label() }}</x-badge>
                    </td>

                    <!-- Actions -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Aksi">
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('residents.show', $res->id) }}"
                               class="inline-flex items-center justify-center w-7 h-7 rounded-xl border border-slate-200/80 bg-white hover:bg-indigo-50 hover:border-indigo-200 text-slate-500 hover:text-indigo-600 transition-all shadow-2xs hover:shadow-xs active:scale-90"
                               title="Lihat Detail">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </a>
                            <a href="{{ route('residents.edit', $res->id) }}"
                               class="inline-flex items-center justify-center w-7 h-7 rounded-xl border border-slate-200/80 bg-white hover:bg-slate-50 hover:border-slate-300 text-slate-500 hover:text-slate-700 transition-all shadow-2xs hover:shadow-xs active:scale-90"
                               title="Edit Profil">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                            @can('delete', $res)
                                <button wire:click="confirmDelete('{{ $res->id }}')"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-xl border border-slate-200/80 bg-white hover:bg-rose-50 hover:border-rose-200 text-slate-400 hover:text-rose-600 transition-all shadow-2xs hover:shadow-xs active:scale-90 cursor-pointer"
                                        title="Hapus Profil">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-0">
                        <x-empty-state
                            icon="user"
                            title="Belum ada penghuni terdaftar"
                            description="Tambahkan profil penghuni, lakukan proses check-in, dan tautkan dokumen hunian.">
                            <x-button variant="primary" size="sm" href="{{ route('residents.create') }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Penghuni Pertama
                            </x-button>
                        </x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>

        <!-- Pagination -->
        <div class="mt-4 px-1">
            {{ $residents->links('components.pagination') }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal wire:model="showDeleteModal" title="Hapus Data Penghuni" maxWidth="md">
        <div class="space-y-4">
            <div class="flex items-start gap-3 p-4 bg-rose-50/60 border border-rose-100 rounded-2xl">
                <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-rose-800">Tindakan Tidak Dapat Dibatalkan</p>
                    <p class="text-xs text-rose-700 mt-1 leading-relaxed">Semua dokumen lampiran dan riwayat kejadian terkait akan dihapus permanen. Penghuni yang sedang aktif tidak dapat dihapus.</p>
                </div>
            </div>
            <div class="flex justify-end gap-2.5 pt-1">
                <x-button variant="outline" size="sm" @click="show = false">Batal</x-button>
                <x-button variant="danger" size="sm" wire:click="deleteResident" :loading="'deleteResident'">Hapus Data</x-button>
            </div>
        </div>
    </x-modal>

</div>
