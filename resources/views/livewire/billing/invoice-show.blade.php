<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Printable Invoice Sheet -->
    <div class="col-span-1 lg:col-span-2 space-y-6">
        <div id="invoice-sheet" class="bg-white border border-slate-100 rounded-2xl p-8 shadow-sm">
            <!-- Sheet Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 pb-6 border-b border-slate-100">
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-indigo-650">KOSAN SaaS System</h2>
                    <p class="text-xs text-slate-400 mt-1">Tenant Workspace: {{ tenant()->name }}</p>
                    <p class="text-[10px] text-slate-400 font-mono mt-0.5">SLUG: {{ tenant()->slug }}</p>
                </div>
                <div class="sm:text-right">
                    <span class="text-slate-400 font-bold uppercase tracking-wider text-[9px] block">Invoice number</span>
                    <span class="text-lg font-mono font-bold text-slate-900 block mt-0.5">{{ $invoice->invoice_number }}</span>
                    
                    <div class="mt-2.5 flex sm:justify-end">
                        @php
                            $variant = 'neutral';
                            if ($invoice->status->value === 'paid') $variant = 'success';
                            if ($invoice->status->value === 'draft') $variant = 'neutral';
                            if (in_array($invoice->status->value, ['pending', 'sent', 'viewed'])) $variant = 'info';
                            if ($invoice->status->value === 'overdue') $variant = 'warning';
                            if ($invoice->status->value === 'cancelled' || $invoice->status->value === 'voided') $variant = 'danger';
                        @endphp
                        <x-badge :variant="$variant" class="uppercase text-[8px] px-2 py-0.5 font-bold">{{ $invoice->status->label() }}</x-badge>
                    </div>
                </div>
            </div>

            <!-- Dates Block -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-5 text-xs border-b border-slate-100 bg-slate-50/50 px-4 rounded-xl mt-4">
                <div>
                    <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px]">Invoice Date</span>
                    <span class="block font-semibold text-slate-800 mt-1">{{ $invoice->invoice_date->format('d M Y') }}</span>
                </div>
                <div>
                    <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px]">Due Date</span>
                    <span class="block font-semibold text-slate-800 mt-1">{{ $invoice->due_date->format('d M Y') }}</span>
                </div>
                <div>
                    <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px]">Billing Period</span>
                    <span class="block font-semibold text-slate-800 mt-1">{{ $invoice->billing_period_start->format('d M Y') }} - {{ $invoice->billing_period_end->format('d M Y') }}</span>
                </div>
                <div>
                    <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px]">Associated Lease</span>
                    <span class="block font-semibold text-slate-800 mt-1 font-mono text-[10px]">#{{ $invoice->contract ? $invoice->contract->contract_number : '-' }}</span>
                </div>
            </div>

            <!-- Addresses Block -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6 text-xs border-b border-slate-100">
                <div>
                    <span class="block text-slate-400 font-bold uppercase tracking-wider text-[9px] mb-2">Issued From (Boarding House)</span>
                    <p class="font-bold text-slate-900">{{ $invoice->boardingHouse->name }}</p>
                    <p class="text-slate-500 mt-1 leading-relaxed">{{ $invoice->boardingHouse->address }}</p>
                    <p class="text-slate-500 mt-0.5">{{ $invoice->boardingHouse->district }}, {{ $invoice->boardingHouse->city }}</p>
                    <p class="text-slate-400 mt-1 font-mono">WhatsApp: {{ $invoice->boardingHouse->whatsapp_number }}</p>
                </div>
                <div>
                    <span class="block text-slate-400 font-bold uppercase tracking-wider text-[9px] mb-2">Invoiced To (Resident)</span>
                    <p class="font-bold text-slate-900">{{ $invoice->resident->name }}</p>
                    <p class="text-slate-500 mt-0.5 font-mono">NIK: {{ $invoice->resident->nik }}</p>
                    <p class="text-slate-500 mt-0.5">Email: {{ $invoice->resident->email }}</p>
                    <p class="text-slate-500 mt-0.5">Phone: {{ $invoice->resident->phone }}</p>
                    <p class="mt-2 font-semibold text-indigo-650 font-mono text-[10px]">Room {{ $invoice->room ? $invoice->room->room_number : '-' }} ({{ $invoice->room ? $invoice->room->room_type : '-' }} floor {{ $invoice->room ? $invoice->room->floor : '-' }})</p>
                </div>
            </div>

            <!-- Billing Items Table -->
            <div class="py-6">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 font-bold uppercase tracking-wider text-[9px] border-b border-slate-100">
                            <th class="py-2.5">Billing Item Description</th>
                            <th class="py-2.5">Billing Type</th>
                            <th class="py-2.5 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                            <tr class="border-b border-slate-100/50 text-slate-700">
                                <td class="py-3 font-semibold">
                                    {{ $item->name }}
                                    @if($item->notes)
                                        <span class="block text-[10px] text-slate-400 font-normal mt-0.5">{{ $item->notes }}</span>
                                    @endif
                                </td>
                                <td class="py-3 capitalize text-slate-500 text-[10px] font-medium">{{ str_replace('_', ' ', $item->item_type->value) }}</td>
                                <td class="py-3 text-right font-bold text-slate-900">Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Invoice totals summary block -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <div class="w-full sm:w-64 space-y-2.5 text-xs">
                    <div class="flex justify-between items-center text-slate-500">
                        <span>Subtotal charges</span>
                        <span class="font-semibold text-slate-800">Rp{{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($invoice->penalty > 0)
                        <div class="flex justify-between items-center text-rose-600">
                            <span>Late payment penalty</span>
                            <span class="font-bold">Rp{{ number_format($invoice->penalty, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if($invoice->discount > 0)
                        <div class="flex justify-between items-center text-emerald-600 font-medium">
                            <span>Lease discount</span>
                            <span>-Rp{{ number_format($invoice->discount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center text-sm font-bold text-slate-900 border-t border-slate-50 pt-2.5">
                        <span>Grand Total Due</span>
                        <span class="text-md">Rp{{ number_format($invoice->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Footnotes -->
            <div class="mt-8 pt-6 border-t border-slate-100 text-[10px] text-slate-400 leading-relaxed">
                <p class="font-semibold">Important billing notice:</p>
                <p class="mt-1">Please pay before due date. Transfers must be sent to the designated office bank accounts, enclosing invoice sequence number for payment matching.</p>
                @if($invoice->notes)
                    <p class="mt-3 bg-slate-50/50 p-2.5 rounded-lg border border-slate-100/50"><strong>Notes:</strong> {{ $invoice->notes }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column: Sticky Actions & Timelines -->
    <div class="space-y-6">
        
        <!-- Actions Card -->
        <x-card title="Invoice Management Tools" description="Manage invoice lifecycle states.">
            <div class="space-y-3">
                @if(!in_array($invoice->status->value, ['paid', 'cancelled', 'voided']))
                    <x-button variant="primary" size="sm" class="w-full justify-center cursor-pointer bg-emerald-600! hover:bg-emerald-700!" wire:click="$set('showPaymentModal', true)">
                        Record Manual Payment
                    </x-button>
                    <x-button variant="outline" size="sm" class="w-full justify-center cursor-pointer text-xs" wire:click="markAsPaid">
                        Mark as Paid (Settle)
                    </x-button>
                    <div class="grid grid-cols-2 gap-2">
                        <x-button variant="outline" size="sm" class="justify-center cursor-pointer text-[10px]" wire:click="markAsCancelled">
                            Cancel Invoice
                        </x-button>
                        <x-button variant="outline" size="sm" class="justify-center cursor-pointer text-[10px]" wire:click="markAsVoided">
                            Void Invoice
                        </x-button>
                    </div>
                @endif

                <x-button variant="outline" size="sm" class="w-full justify-center text-xs" onclick="window.print()">
                    Print Invoice
                </x-button>
            </div>
        </x-card>

        @if(!in_array($invoice->status->value, ['paid', 'cancelled', 'voided']))
            <!-- Apply Penalty Card -->
            <x-card title="Apply Overdue Penalty" description="Append a penalty line item for delayed payment.">
                <form wire:submit="applyPenalty" class="space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center gap-1.5 text-xs text-slate-700 cursor-pointer">
                            <input type="radio" wire:model="penaltyType" value="fixed" class="text-indigo-600 focus:ring-indigo-500">
                            Fixed IDR Amount
                        </label>
                        <label class="flex items-center gap-1.5 text-xs text-slate-700 cursor-pointer">
                            <input type="radio" wire:model="penaltyType" value="percentage" class="text-indigo-600 focus:ring-indigo-500">
                            % of Subtotal
                        </label>
                    </div>

                    <div>
                        <input wire:model="penaltyValue" type="number" step="0.01" required min="1"
                            class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs"
                            placeholder="Penalty Amount / Percent value...">
                        @error('penaltyValue') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <x-button variant="primary" size="sm" type="submit" loading="applyPenalty" class="text-xs">Apply Penalty Fine</x-button>
                    </div>
                </form>
            </x-card>

            <!-- Manual Charge Item Card -->
            <x-card title="Add Manual Charge Item" description="Insert additional lines for maintenance, deposits, or services.">
                <form wire:submit="addManualChargeItem" class="space-y-3">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Charge Type</label>
                        <select wire:model="manualItemType"
                            class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900">
                            <option value="electricity">Electricity</option>
                            <option value="water">Water</option>
                            <option value="internet">Internet</option>
                            <option value="parking">Parking</option>
                            <option value="laundry">Laundry</option>
                            <option value="cleaning">Cleaning</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="additional">Additional Charges</option>
                            <option value="manual">Manual Charge</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Item Description</label>
                        <input wire:model="manualItemName" type="text" required class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="e.g. Aircon Filter Cleaning">
                        @error('manualItemName') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Amount (IDR)</label>
                        <input wire:model="manualItemAmount" type="number" required min="1" step="1000" class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="Rp Amount...">
                        @error('manualItemAmount') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Additional Notes</label>
                        <input wire:model="manualItemNotes" type="text" class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="Private internal annotations (optional)">
                    </div>

                    <div class="flex justify-end">
                        <x-button variant="primary" size="sm" type="submit" loading="addManualChargeItem" class="text-xs">Add Charge</x-button>
                    </div>
                </form>
            </x-card>
        @endif

        <!-- Activity Timeline -->
        <x-card title="Invoice Activity Log" description="Timeline records.">
            <div class="flow-root mt-2">
                <ul role="list" class="-mb-8">
                    @forelse($invoice->timeline as $index => $logItem)
                        <li>
                            <div class="relative pb-8">
                                @if($index !== $invoice->timeline->count() - 1)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                @endif
                                
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white text-white text-xs font-bold {{ $logItem->color ?: 'bg-indigo-500' }}">
                                            @if($logItem->event === 'generated')
                                                +
                                            @elseif($logItem->event === 'status_change')
                                                S
                                            @elseif($logItem->event === 'penalty_applied')
                                                !
                                            @else
                                                *
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-xs font-bold text-slate-800">{{ $logItem->title }}</p>
                                            @if($logItem->description)
                                                <p class="text-xs text-slate-500 mt-1 leading-normal">{{ $logItem->description }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right text-[10px] whitespace-nowrap text-slate-400 font-semibold">
                                            <time>{{ $logItem->created_at->format('d M, H:i') }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-center text-xs italic text-slate-400 py-4">No events logged.</li>
                    @endforelse
                </ul>
            </div>
        </x-card>

    </div>

    <!-- Manual Payment Record Modal -->
    <x-modal wire:model="showPaymentModal" title="Record Manual Payment" maxWidth="md">
        <form wire:submit.prevent="recordManualPayment" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Payment Method</label>
                <select wire:model="payMethod" required
                    class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900">
                    <option value="cash">Cash (Manual)</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="virtual_account">Virtual Account</option>
                    <option value="qris">QRIS Code</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="ewallet">E-Wallet</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Bank Reference / TXN Number (Optional)</label>
                <input wire:model="payReference" type="text"
                    class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs"
                    placeholder="e.g. BCA-8921820">
                @error('payReference') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Amount Paid (IDR)</label>
                <input wire:model="payAmount" type="number" required min="1" step="1000"
                    class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                @error('payAmount') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Administrative Notes</label>
                <input wire:model="payNotes" type="text"
                    class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs"
                    placeholder="e.g. Handed cash to office admin.">
                @error('payNotes') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Cancel</x-button>
                <x-button variant="primary" size="sm" type="submit" loading="recordManualPayment">Reconcile & Settle</x-button>
            </div>
        </form>
    </x-modal>

</div>
