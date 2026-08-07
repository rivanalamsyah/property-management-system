<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 reveal">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Tagihan &amp; <span class="text-gradient-primary">Faktur</span></h1>
            <p class="text-xs text-slate-500 mt-1">Generate tagihan sewa berulang, konfigurasi estimasi utilitas, pantau status bayar, dan sesuaikan denda keterlambatan.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" wire:click="openBulkModal" data-ripple>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Bulk Generate Faktur
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 reveal">
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Total Pendapatan</p>
            <p class="text-sm font-black text-emerald-600 mt-1">Rp{{ number_format($revenueTotal, 0, ',', '.') }}</p>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Belum Dibayar</p>
            <p class="text-sm font-black text-amber-600 mt-1">Rp{{ number_format($outstandingTotal, 0, ',', '.') }}</p>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Tagihan Jatuh Tempo</p>
            <p class="text-sm font-black text-rose-600 mt-1">Rp{{ number_format($overdueTotal, 0, ',', '.') }}</p>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Denda Terkumpul</p>
            <p class="text-sm font-black text-slate-800 mt-1">Rp{{ number_format($penaltyCollected, 0, ',', '.') }}</p>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Terbayar Bulan Ini</p>
            <h3 class="text-xl font-black text-slate-900 mt-1" data-counter="{{ $paidCountThisMonth }}">{{ $paidCountThisMonth }} <span class="text-xs font-medium text-slate-400">faktur</span></h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Menunggu Bayar</p>
            <h3 class="text-xl font-black {{ $pendingPaymentsCount > 0 ? 'text-amber-600' : 'text-slate-900' }} mt-1" data-counter="{{ $pendingPaymentsCount }}">{{ $pendingPaymentsCount }} <span class="text-xs font-medium text-slate-400">faktur</span></h3>
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
                        placeholder="Cari no. faktur, nama penghuni, kos, atau nomor kamar...">
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
                        <option value="pending">Menunggu Bayar</option>
                        <option value="sent">Terkirim</option>
                        <option value="viewed">Dilihat</option>
                        <option value="partially_paid">Bayar Sebagian</option>
                        <option value="paid">Lunas</option>
                        <option value="overdue">Jatuh Tempo</option>
                        <option value="cancelled">Dibatalkan</option>
                        <option value="voided">Dibatalkan (Void)</option>
                    </select>
                </div>
            </div>

            <!-- Date Range Filters -->
            <div class="flex flex-wrap items-center gap-3 pt-1 border-t border-slate-100/60">
                <div class="flex items-center gap-2">
                    <span class="section-label whitespace-nowrap">Dari:</span>
                    <input wire:model.live="filterStartDate" type="date"
                           class="px-2.5 py-1.5 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400">
                </div>
                <div class="flex items-center gap-2">
                    <span class="section-label whitespace-nowrap">Hingga:</span>
                    <input wire:model.live="filterEndDate" type="date"
                           class="px-2.5 py-1.5 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400">
                </div>
            </div>
        </div>
    </x-card>

    <!-- Data Table -->
    <div class="reveal">
        <x-table :headers="['No. Faktur', 'Penghuni', 'Detail Kamar', 'Periode Tagihan', 'Subtotal', 'Denda', 'Total', 'Status', 'Aksi']" :stickyHeader="true">
            @forelse($invoices as $inv)
                <tr class="group transition-colors duration-100">
                    <!-- Invoice number -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="No. Faktur">
                        <span class="text-xs font-mono font-bold text-slate-800 bg-slate-100/70 px-2 py-0.5 rounded-lg">{{ $inv->invoice_number }}</span>
                    </td>

                    <!-- Resident -->
                    <td class="px-5 py-3.5" data-label="Penghuni">
                        <p class="text-xs font-bold text-slate-900">{{ $inv->resident->name }}</p>
                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">NIK: {{ $inv->resident->nik }}</p>
                    </td>

                    <!-- Room details -->
                    <td class="px-5 py-3.5" data-label="Detail Kamar">
                        <p class="text-xs font-semibold text-slate-700">{{ $inv->boardingHouse->name }}</p>
                        <p class="text-[10px] font-mono text-indigo-500 mt-0.5">Kamar {{ $inv->room ? $inv->room->room_number : '—' }}</p>
                    </td>

                    <!-- Period -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Periode">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-xs text-slate-700">{{ $inv->billing_period_start->format('d M Y') }}</span>
                            <span class="text-[10px] text-slate-400">— {{ $inv->billing_period_end->format('d M Y') }}</span>
                        </div>
                    </td>

                    <!-- Subtotal -->
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs font-semibold text-slate-700" data-label="Subtotal">
                        Rp{{ number_format($inv->subtotal, 0, ',', '.') }}
                    </td>

                    <!-- Penalty -->
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs font-semibold" data-label="Denda">
                        @if($inv->penalty > 0)
                            <span class="text-rose-600">Rp{{ number_format($inv->penalty, 0, ',', '.') }}</span>
                        @else
                            <span class="text-slate-400">—</span>
                        @endif
                    </td>

                    <!-- Grand Total -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Total">
                        <span class="text-xs font-black text-slate-900">Rp{{ number_format($inv->grand_total, 0, ',', '.') }}</span>
                    </td>

                    <!-- Status -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Status">
                        @php
                            $variant = 'neutral';
                            if ($inv->status->value === 'paid') $variant = 'success';
                            if (in_array($inv->status->value, ['pending', 'sent', 'viewed'])) $variant = 'info';
                            if ($inv->status->value === 'overdue') $variant = 'warning';
                            if (in_array($inv->status->value, ['cancelled', 'voided'])) $variant = 'danger';
                            if ($inv->status->value === 'partially_paid') $variant = 'warning';
                        @endphp
                        <x-badge :variant="$variant" :dot="$inv->status->value === 'overdue'">{{ $inv->status->label() }}</x-badge>
                    </td>

                    <!-- Actions -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Aksi">
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('invoices.show', $inv->id) }}"
                               class="inline-flex items-center justify-center w-7 h-7 rounded-xl border border-slate-200/80 bg-white hover:bg-indigo-50 hover:border-indigo-200 text-slate-500 hover:text-indigo-600 transition-all shadow-2xs active:scale-90"
                               title="Kelola Tagihan">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </a>
                            @can('delete', $inv)
                                <button wire:click="confirmDelete('{{ $inv->id }}')"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-xl border border-slate-200/80 bg-white hover:bg-rose-50 hover:border-rose-200 text-slate-400 hover:text-rose-600 transition-all shadow-2xs active:scale-90 cursor-pointer"
                                        title="Hapus Faktur">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="p-0">
                        <x-empty-state
                            icon="payment"
                            title="Belum ada faktur sewa yang diterbitkan"
                            description="Generate tagihan sewa bulanan, estimasi utilitas, atau denda keterlambatan untuk kontrak aktif.">
                            <x-button variant="primary" size="sm" wire:click="openBulkModal">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Bulk Generate Faktur
                            </x-button>
                        </x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>

        <!-- Pagination -->
        <div class="mt-4 px-1">
            {{ $invoices->links('components.pagination') }}
        </div>
    </div>

    <!-- BULK GENERATOR MODAL -->
    <x-modal wire:model="showBulkModal" title="Wizard Bulk Generate Faktur Berulang" maxWidth="lg">
        <div class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Properti Kos</label>
                    <select wire:model.live="bulkBoardingHouseId" wire:change="previewBulkGeneration" class="input-base">
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Tanggal Jatuh Tempo</label>
                    <input wire:model="bulkDueDate" type="date" class="input-base">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Periode Tagihan Mulai</label>
                    <input wire:model.live="bulkPeriodStart" wire:change="previewBulkGeneration" type="date" class="input-base">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Periode Tagihan Berakhir</label>
                    <input wire:model.live="bulkPeriodEnd" wire:change="previewBulkGeneration" type="date" class="input-base">
                </div>
            </div>

            <!-- Preview Grid -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <p class="section-label">Pratinjau Bulk Generate</p>
                    @if(count($bulkPreviews) > 0)
                        <x-badge variant="info">{{ count($bulkPreviews) }} faktur akan dibuat</x-badge>
                    @endif
                </div>
                <div class="border border-slate-200/70 rounded-2xl overflow-hidden max-h-[220px] overflow-y-auto shadow-xs">
                    <x-table :headers="['Kamar', 'Penghuni', 'Sewa/Bulan']">
                        @forelse($bulkPreviews as $prev)
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2.5 font-mono font-bold text-xs text-slate-800">Kamar {{ $prev['room_number'] }}</td>
                                <td class="px-4 py-2.5 font-semibold text-xs text-slate-900">{{ $prev['resident_name'] }}</td>
                                <td class="px-4 py-2.5 text-xs font-bold text-slate-900">Rp{{ number_format($prev['monthly_rent'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-xs text-slate-400 italic">
                                    Semua kontrak aktif di properti ini sudah ditagih untuk periode yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </x-table>
                </div>
            </div>

            <div class="flex justify-end gap-2.5 pt-2 border-t border-slate-100/80">
                <x-button variant="outline" size="sm" @click="show = false">Batal</x-button>
                @if(count($bulkPreviews) > 0)
                    <x-button variant="primary" size="sm" wire:click="generateBulkInvoices" :loading="'generateBulkInvoices'">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Generate {{ count($bulkPreviews) }} Faktur
                    </x-button>
                @endif
            </div>
        </div>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal wire:model="showDeleteModal" title="Hapus Draft Faktur" maxWidth="md">
        <div class="space-y-4">
            <div class="flex items-start gap-3 p-4 bg-rose-50/60 border border-rose-100 rounded-2xl">
                <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-rose-800">Hapus Faktur?</p>
                    <p class="text-xs text-rose-700 mt-1 leading-relaxed">Tindakan ini tidak dapat dibatalkan. Faktur yang sudah terkirim atau diselesaikan tidak dapat dihapus.</p>
                </div>
            </div>
            <div class="flex justify-end gap-2.5 pt-1">
                <x-button variant="outline" size="sm" @click="show = false">Batal</x-button>
                <x-button variant="danger" size="sm" wire:click="deleteInvoice">Hapus Faktur</x-button>
            </div>
        </div>
    </x-modal>

</div>
