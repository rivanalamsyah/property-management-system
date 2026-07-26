<div class="space-y-6">
    
    <!-- Title & Action -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Billing & Invoices</h1>
            <p class="text-sm text-slate-500 mt-1">Automatically generate recurring rental bills, configure utilities estimates, track payment states, and adjust late penalties.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" wire:click="openBulkModal" class="cursor-pointer">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Bulk Generate Invoices
                </span>
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total Revenue</p>
            <h3 class="text-md font-bold text-emerald-650 mt-1">Rp{{ number_format($revenueTotal, 0, ',', '.') }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Outstanding</p>
            <h3 class="text-md font-bold text-amber-600 mt-1">Rp{{ number_format($outstandingTotal, 0, ',', '.') }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Overdue Bills</p>
            <h3 class="text-md font-bold text-rose-600 mt-1">Rp{{ number_format($overdueTotal, 0, ',', '.') }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Penalties Collected</p>
            <h3 class="text-md font-bold text-slate-800 mt-1">Rp{{ number_format($penaltyCollected, 0, ',', '.') }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Paid This Month</p>
            <h3 class="text-lg font-bold text-slate-900 mt-0.5">{{ $paidCountThisMonth }} <span class="text-xs font-normal text-slate-400">invoices</span></h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Pending payments</p>
            <h3 class="text-lg font-bold text-slate-900 mt-0.5">{{ $pendingPaymentsCount }} <span class="text-xs font-normal text-slate-400">invoices</span></h3>
        </x-card>
    </div>

    <!-- Filters Section -->
    <x-card class="py-4 px-6">
        <div class="space-y-4">
            <div class="flex flex-col md:flex-row items-center gap-4">
                <!-- Search -->
                <div class="flex-1 w-full relative">
                    <input wire:model.live.debounce.250ms="search" type="text"
                        class="w-full pl-10 pr-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="Search by invoice #, resident name, boarding house, or room number...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <!-- Property Filter -->
                <div class="w-full md:w-56">
                    <select wire:model.live="filterBoardingHouse"
                        class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="">All Boarding Houses</option>
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="w-full md:w-44">
                    <select wire:model.live="filterStatus"
                        class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="">All Statuses</option>
                        <option value="draft">Draft</option>
                        <option value="pending">Pending Payment</option>
                        <option value="sent">Sent</option>
                        <option value="viewed">Viewed</option>
                        <option value="partially_paid">Partially Paid</option>
                        <option value="paid">Paid</option>
                        <option value="overdue">Overdue</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="voided">Voided</option>
                    </select>
                </div>
            </div>

            <!-- Date range filters -->
            <div class="flex flex-wrap items-center gap-4 text-xs">
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
        <x-table :headers="['Invoice No', 'Resident', 'Room Details', 'Billing Period', 'Subtotal', 'Penalty', 'Grand Total', 'Status', 'Actions']">
            @forelse($invoices as $inv)
                <tr class="hover:bg-slate-50/50 transition">
                    <!-- Invoice number -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-slate-800">
                        {{ $inv->invoice_number }}
                    </td>

                    <!-- Resident -->
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-slate-900">{{ $inv->resident->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">NIK: {{ $inv->resident->nik }}</p>
                    </td>

                    <!-- Room details -->
                    <td class="px-6 py-4 text-xs text-slate-650">
                        <p class="font-semibold">{{ $inv->boardingHouse->name }}</p>
                        <p class="font-mono text-indigo-650 mt-0.5">Room {{ $inv->room ? $inv->room->room_number : '-' }}</p>
                    </td>

                    <!-- Period -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-550">
                        {{ $inv->billing_period_start->format('d M Y') }} - {{ $inv->billing_period_end->format('d M Y') }}
                    </td>

                    <!-- Subtotal -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-800 font-semibold">
                        Rp{{ number_format($inv->subtotal, 0, ',', '.') }}
                    </td>

                    <!-- Penalty -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-rose-600 font-semibold">
                        {{ $inv->penalty > 0 ? 'Rp' . number_format($inv->penalty, 0, ',', '.') : '-' }}
                    </td>

                    <!-- Grand Total -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900">
                        Rp{{ number_format($inv->grand_total, 0, ',', '.') }}
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $variant = 'neutral';
                            if ($inv->status->value === 'paid') $variant = 'success';
                            if ($inv->status->value === 'draft') $variant = 'neutral';
                            if (in_array($inv->status->value, ['pending', 'sent', 'viewed'])) $variant = 'info';
                            if ($inv->status->value === 'overdue') $variant = 'warning';
                            if ($inv->status->value === 'cancelled' || $inv->status->value === 'voided') $variant = 'danger';
                        @endphp
                        <x-badge :variant="$variant" class="uppercase text-[8px] font-bold px-2.5 py-0.5">
                            {{ $inv->status->label() }}
                        </x-badge>
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <x-button variant="outline" size="sm" class="px-2.5! py-1! text-xs font-semibold" onclick="window.location.href='{{ route('invoices.show', $inv->id) }}'">
                                Manage Invoice
                            </x-button>
                            @can('delete', $inv)
                                <x-button variant="outline" size="sm" class="px-2.5! py-1! text-xs text-rose-600 border-slate-200 hover:border-rose-100 hover:bg-rose-50 cursor-pointer" wire:click="confirmDelete('{{ $inv->id }}')">
                                    Delete
                                </x-button>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="p-0">
                        <x-empty-state title="No rental invoices issued yet" description="Generate monthly rental invoices, utilities estimates, or apply overdue fines to active contracts."></x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $invoices->links('components.pagination') }}
    </div>

    <!-- BULK GENERATOR MODAL -->
    <x-modal wire:model="showBulkModal" title="Bulk Recurring Invoices Wizard" maxWidth="lg">
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Boarding House Property</label>
                    <select wire:model.live="bulkBoardingHouseId" wire:change="previewBulkGeneration"
                        class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none">
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Due Date</label>
                    <input wire:model="bulkDueDate" type="date" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Billing Period Start</label>
                    <input wire:model.live="bulkPeriodStart" wire:change="previewBulkGeneration" type="date" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Billing Period End</label>
                    <input wire:model.live="bulkPeriodEnd" wire:change="previewBulkGeneration" type="date" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                </div>
            </div>

            <!-- Preview Grid -->
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Bulk Preview generation</p>
                <div class="border border-slate-100 rounded-xl overflow-hidden max-h-[220px] overflow-y-auto">
                    <x-table :headers="['Room', 'Resident', 'Monthly Rent']" class="text-xs!">
                        @forelse($bulkPreviews as $prev)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-4 py-2 font-mono font-bold text-slate-800">Room {{ $prev['room_number'] }}</td>
                                <td class="px-4 py-2 font-semibold text-slate-900">{{ $prev['resident_name'] }}</td>
                                <td class="px-4 py-2 text-slate-900 font-bold">Rp{{ number_format($prev['monthly_rent'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-slate-400 italic text-[11px]">
                                    All active lease agreements in this property have already been invoiced for the specified period.
                                </td>
                            </tr>
                        @endforelse
                    </x-table>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Cancel</x-button>
                @if(count($bulkPreviews) > 0)
                    <x-button variant="primary" size="sm" type="button" wire:click="generateBulkInvoices" loading="generateBulkInvoices">Batch Generate {{ count($bulkPreviews) }} Invoices</x-button>
                @endif
            </div>
        </div>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal wire:model="showDeleteModal" title="Delete Invoice Draft" maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-slate-500">
                Are you sure you want to delete this invoice draft? This operation is permanent. Settled or sent invoices cannot be deleted.
            </p>
            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Cancel</x-button>
                <x-button variant="danger" size="sm" type="button" wire:click="deleteInvoice">Delete Invoice</x-button>
            </div>
        </div>
    </x-modal>

</div>
