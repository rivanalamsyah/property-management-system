<div class="space-y-6">
    
    <!-- Title & Action -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Payments & Reconciliation</h1>
        <p class="text-sm text-slate-500 mt-1">Review transfer proofs, verify pending bank transfers, issue legal receipts, and audit transaction records.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total Verified</p>
            <h3 class="text-md font-bold text-emerald-650 mt-1">Rp{{ number_format($totalPayments, 0, ',', '.') }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Monthly Revenue</p>
            <h3 class="text-md font-bold text-indigo-650 mt-1">Rp{{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Verification queue</p>
            <h3 class="text-lg font-bold text-amber-600 mt-0.5">{{ $pendingVerificationCount }} <span class="text-xs font-normal text-slate-400">pending</span></h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Failed payments</p>
            <h3 class="text-lg font-bold text-slate-500 mt-0.5">{{ $failedCount }} <span class="text-xs font-normal text-slate-400">failed</span></h3>
        </x-card>
        <x-card class="py-3! px-4! col-span-1 md:col-span-2 lg:col-span-1">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Outstanding Balance</p>
            <h3 class="text-md font-bold text-slate-800 mt-1">Rp{{ number_format($outstandingBalance, 0, ',', '.') }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Collection Rate</p>
            <h3 class="text-lg font-bold text-slate-900 mt-0.5">{{ $collectionRate }}%</h3>
        </x-card>
    </div>

    <!-- Quick Notice Alert -->
    <div class="bg-indigo-50/20 border border-indigo-100/50 p-4 rounded-2xl text-xs text-indigo-750 leading-normal flex items-start gap-3">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <p class="font-bold">Manual Recording Tip:</p>
            <p class="mt-0.5">To record a manual payment (Cash, Bank Transfer) or apply adjustments directly, click **Billing & Invoices** on the sidebar, select any pending/unpaid invoice, and use the Invoice Management actions sidebar.</p>
        </div>
    </div>

    <!-- Filters Section -->
    <x-card class="py-4 px-6">
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="col-span-1 md:col-span-2 relative">
                    <input wire:model.live.debounce.250ms="search" type="text"
                        class="w-full pl-10 pr-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="Search by transaction #, reference #, resident name, or invoice #...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <!-- Property Filter -->
                <div>
                    <select wire:model.live="filterBoardingHouse"
                        class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="">All Boarding Houses</option>
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Method Filter -->
                <div>
                    <select wire:model.live="filterMethod"
                        class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="">All Payment Methods</option>
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="virtual_account">Virtual Account</option>
                        <option value="qris">QRIS Code</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="debit_card">Debit Card</option>
                        <option value="ewallet">E-Wallet</option>
                    </select>
                </div>
            </div>

            <!-- Date Bounds and status -->
            <div class="flex flex-wrap items-center gap-4 text-xs">
                <div class="flex items-center gap-2">
                    <span class="text-slate-400 font-bold uppercase tracking-wider">Status:</span>
                    <select wire:model.live="filterStatus" class="px-2 py-1 bg-slate-50/50 border border-slate-200 rounded-lg text-xs">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="waiting_verification">Waiting Verification</option>
                        <option value="completed">Completed</option>
                        <option value="failed">Failed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-slate-400 font-bold uppercase tracking-wider">Start Date:</span>
                    <input wire:model.live="filterStartDate" type="date" class="px-2.5 py-1 bg-slate-50/50 border border-slate-200 rounded-lg text-xs">
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-slate-400 font-bold uppercase tracking-wider">End Date:</span>
                    <input wire:model.live="filterEndDate" type="date" class="px-2.5 py-1 bg-slate-50/50 border border-slate-200 rounded-lg text-xs">
                </div>
            </div>
        </div>
    </x-card>

    <!-- Data Table -->
    <x-card class="overflow-hidden p-0!">
        <x-table :headers="['Transaction No', 'Invoice Reference', 'Resident', 'Payment Details', 'Payment Method', 'Amount Paid', 'Verification Stamp', 'Status', 'Actions']">
            @forelse($payments as $pay)
                <tr class="hover:bg-slate-50/50 transition">
                    <!-- Transaction number -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-slate-800">
                        {{ $pay->transaction_number }}
                    </td>

                    <!-- Invoice Ref -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs font-mono font-semibold">
                        <a href="{{ route('invoices.show', $pay->invoice_id) }}" class="text-indigo-650 hover:underline">
                            {{ $pay->invoice->invoice_number }}
                        </a>
                    </td>

                    <!-- Resident -->
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-slate-900">{{ $pay->resident->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Room {{ $pay->invoice->room ? $pay->invoice->room->room_number : '-' }}</p>
                    </td>

                    <!-- Date & reference -->
                    <td class="px-6 py-4 text-xs text-slate-650">
                        <p>{{ $pay->payment_date->format('d M Y') }}</p>
                        @if($pay->reference_number)
                            <p class="font-mono text-[10px] text-slate-400 mt-0.5">Ref: {{ $pay->reference_number }}</p>
                        @endif
                    </td>

                    <!-- Method -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 font-medium">
                        {{ $pay->payment_method->label() }}
                    </td>

                    <!-- Amount Paid -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900">
                        Rp{{ number_format($pay->amount_paid, 0, ',', '.') }}
                    </td>

                    <!-- Verifier info -->
                    <td class="px-6 py-4 text-xs text-slate-550">
                        @if($pay->verifier)
                            <p class="font-semibold">{{ $pay->verifier->name }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $pay->verified_at->format('d M Y, H:i') }}</p>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $variant = 'neutral';
                            if ($pay->status->value === 'completed') $variant = 'success';
                            if ($pay->status->value === 'pending') $variant = 'neutral';
                            if ($pay->status->value === 'waiting_verification') $variant = 'info';
                            if ($pay->status->value === 'failed' || $pay->status->value === 'cancelled') $variant = 'danger';
                        @endphp
                        <x-badge :variant="$variant" class="uppercase text-[8px] font-bold px-2 py-0.5">
                            {{ $pay->status->label() }}
                        </x-badge>
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if($pay->status->value === 'waiting_verification')
                            <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 hover:bg-indigo-50/50 hover:border-indigo-200 text-indigo-600 transition cursor-pointer" onclick="window.location.href='{{ route('payments.show', $pay->id) }}'" title="Verifikasi Transfer" aria-label="Verifikasi Transfer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </x-button>
                        @else
                            <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 transition cursor-pointer" onclick="window.location.href='{{ route('payments.show', $pay->id) }}'" title="Lihat Penerimaan" aria-label="Lihat Penerimaan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </x-button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="p-0">
                        <x-empty-state title="No payment transactions logged" description="Process bank transfer approvals, generate receipts, and review outstanding collections."></x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $payments->links('components.pagination') }}
    </div>

</div>
