<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 reveal">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Pembayaran &amp; <span class="text-gradient-primary">Rekonsiliasi</span></h1>
            <p class="text-xs text-slate-500 mt-1">Verifikasi bukti transfer, setujui pembayaran masuk, cetak kwitansi resmi, dan audit rekaman transaksi.</p>
        </div>
        <!-- No create button — payments are created from invoice actions -->
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 reveal">
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Total Terverifikasi</p>
            <p class="text-sm font-black text-emerald-600 mt-1">Rp{{ number_format($totalPayments, 0, ',', '.') }}</p>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Revenue Bulan Ini</p>
            <p class="text-sm font-black text-indigo-700 mt-1">Rp{{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <div class="flex items-center justify-between">
                <p class="section-label">Antrian Verifikasi</p>
                @if($pendingVerificationCount > 0)
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                @endif
            </div>
            <h3 class="text-xl font-black text-amber-600 mt-1" data-counter="{{ $pendingVerificationCount }}">{{ $pendingVerificationCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Pembayaran Gagal</p>
            <h3 class="text-xl font-black text-slate-500 mt-1" data-counter="{{ $failedCount }}">{{ $failedCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Saldo Belum Terbayar</p>
            <p class="text-sm font-black text-slate-800 mt-1">Rp{{ number_format($outstandingBalance, 0, ',', '.') }}</p>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Tingkat Koleksi</p>
            <h3 class="text-xl font-black text-slate-900 mt-1">{{ $collectionRate }}<span class="text-sm font-bold text-slate-400">%</span></h3>
        </div>
    </div>

    <!-- Info Alert -->
    <div class="flex items-start gap-3 p-4 bg-indigo-50/60 border border-indigo-100/80 rounded-2xl text-xs text-indigo-800 reveal">
        <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0 mt-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="font-bold text-indigo-900">Cara Rekam Pembayaran Manual:</p>
            <p class="mt-0.5 leading-relaxed text-indigo-700">Untuk mencatat pembayaran tunai atau transfer bank secara manual, buka menu <strong>Tagihan &amp; Faktur</strong>, pilih tagihan yang belum dibayar, lalu gunakan panel Aksi Manajemen Tagihan.</p>
        </div>
    </div>

    <!-- Filters Section -->
    <x-card :glass="true" padding="sm">
        <div class="space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <!-- Search -->
                <div class="md:col-span-2 relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input wire:model.live.debounce.250ms="search" type="text"
                        class="input-base input-with-icon"
                        placeholder="Cari no. transaksi, ref. nomor, nama penghuni, atau no. faktur...">
                </div>

                <!-- Property Filter -->
                <div>
                    <select wire:model.live="filterBoardingHouse" class="input-base">
                        <option value="">Semua Properti</option>
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Method Filter -->
                <div>
                    <select wire:model.live="filterMethod" class="input-base">
                        <option value="">Semua Metode Bayar</option>
                        <option value="cash">Tunai</option>
                        <option value="bank_transfer">Transfer Bank</option>
                        <option value="virtual_account">Virtual Account</option>
                        <option value="qris">QRIS</option>
                        <option value="credit_card">Kartu Kredit</option>
                        <option value="debit_card">Kartu Debit</option>
                        <option value="ewallet">E-Wallet</option>
                    </select>
                </div>
            </div>

            <!-- Date & Status Filters -->
            <div class="flex flex-wrap items-center gap-3 pt-1 border-t border-slate-100/60">
                <div class="flex items-center gap-2">
                    <span class="section-label whitespace-nowrap">Status:</span>
                    <select wire:model.live="filterStatus" class="px-2.5 py-1.5 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400">
                        <option value="">Semua</option>
                        <option value="pending">Pending</option>
                        <option value="waiting_verification">Menunggu Verifikasi</option>
                        <option value="completed">Selesai</option>
                        <option value="failed">Gagal</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
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
        <x-table :headers="['No. Transaksi', 'Ref. Faktur', 'Penghuni', 'Detail Bayar', 'Metode', 'Jumlah', 'Verifikator', 'Status', 'Aksi']" :stickyHeader="true">
            @forelse($payments as $pay)
                <tr class="group transition-colors duration-100">
                    <!-- Transaction number -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="No. Transaksi">
                        <span class="text-xs font-mono font-bold text-slate-800 bg-slate-100/70 px-2 py-0.5 rounded-lg">{{ $pay->transaction_number }}</span>
                    </td>

                    <!-- Invoice Ref -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Ref. Faktur">
                        <a href="{{ route('invoices.show', $pay->invoice_id) }}"
                           class="text-xs font-mono font-semibold text-indigo-600 hover:text-indigo-800 hover:underline underline-offset-2 transition-colors">
                            {{ $pay->invoice->invoice_number }}
                        </a>
                    </td>

                    <!-- Resident -->
                    <td class="px-5 py-3.5" data-label="Penghuni">
                        <p class="text-xs font-bold text-slate-900">{{ $pay->resident->name }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">Kamar {{ $pay->invoice->room ? $pay->invoice->room->room_number : '—' }}</p>
                    </td>

                    <!-- Date & reference -->
                    <td class="px-5 py-3.5" data-label="Detail Bayar">
                        <p class="text-xs font-semibold text-slate-700">{{ $pay->payment_date->format('d M Y') }}</p>
                        @if($pay->reference_number)
                            <p class="text-[10px] font-mono text-slate-400 mt-0.5">Ref: {{ $pay->reference_number }}</p>
                        @endif
                    </td>

                    <!-- Method -->
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs text-slate-500 font-semibold" data-label="Metode">
                        {{ $pay->payment_method->label() }}
                    </td>

                    <!-- Amount Paid -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Jumlah">
                        <span class="text-xs font-bold text-slate-900">Rp{{ number_format($pay->amount_paid, 0, ',', '.') }}</span>
                    </td>

                    <!-- Verifier info -->
                    <td class="px-5 py-3.5" data-label="Verifikator">
                        @if($pay->verifier)
                            <p class="text-xs font-semibold text-slate-700">{{ $pay->verifier->name }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $pay->verified_at->format('d M Y, H:i') }}</p>
                        @else
                            <span class="text-slate-400 text-xs">—</span>
                        @endif
                    </td>

                    <!-- Status -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Status">
                        @php
                            $variant = 'neutral';
                            if ($pay->status->value === 'completed') $variant = 'success';
                            if ($pay->status->value === 'waiting_verification') $variant = 'info';
                            if (in_array($pay->status->value, ['failed', 'cancelled'])) $variant = 'danger';
                        @endphp
                        <x-badge :variant="$variant" :dot="$pay->status->value === 'waiting_verification'">{{ $pay->status->label() }}</x-badge>
                    </td>

                    <!-- Actions -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Aksi">
                        <a href="{{ route('payments.show', $pay->id) }}"
                           class="inline-flex items-center justify-center w-7 h-7 rounded-xl border border-slate-200/80 bg-white {{ $pay->status->value === 'waiting_verification' ? 'hover:bg-indigo-50 hover:border-indigo-200 text-indigo-600' : 'hover:bg-slate-50 text-slate-500 hover:text-slate-700' }} transition-all shadow-2xs active:scale-90"
                           title="{{ $pay->status->value === 'waiting_verification' ? 'Verifikasi Transfer' : 'Lihat Detail' }}">
                            @if($pay->status->value === 'waiting_verification')
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            @else
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            @endif
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="p-0">
                        <x-empty-state
                            icon="payment"
                            title="Belum ada transaksi pembayaran"
                            description="Proses persetujuan transfer bank, cetak kwitansi, dan pantau outstanding tagihan."/>
                    </td>
                </tr>
            @endforelse
        </x-table>

        <!-- Pagination -->
        <div class="mt-4 px-1">
            {{ $payments->links('components.pagination') }}
        </div>
    </div>

</div>
