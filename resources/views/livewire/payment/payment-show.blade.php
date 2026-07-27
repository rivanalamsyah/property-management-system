<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Receipt Sheet or Proof Verification -->
    <div class="col-span-1 lg:col-span-2 space-y-6">
        
        @if($payment->status->value === 'completed')
            <!-- Premium Receipt Sheet -->
            <div id="receipt-sheet" class="bg-white border border-emerald-100 rounded-2xl p-8 shadow-sm relative overflow-hidden">
                <!-- Paid Badge Watermark -->
                <div class="absolute -right-16 -top-16 w-44 h-44 rounded-full border-4 border-dashed border-emerald-500/10 flex items-center justify-center pointer-events-none select-none rotate-12">
                    <span class="text-emerald-500/15 font-black uppercase text-xl tracking-widest">PAID</span>
                </div>

                <!-- Receipt Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 pb-6 border-b border-slate-100">
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-900">PAYMENT RECEIPT</h2>
                        <p class="text-xs text-slate-400 mt-1">Tenant Workspace: {{ tenant()->name }}</p>
                        <p class="text-[10px] text-slate-450 mt-0.5">SLUG: {{ tenant()->slug }}</p>
                    </div>
                    <div class="sm:text-right">
                        <span class="text-slate-400 font-bold uppercase tracking-wider text-[9px] block">Receipt number</span>
                        <span class="text-lg font-mono font-bold text-slate-800 block mt-0.5">{{ $payment->transaction_number }}</span>
                        
                        <div class="mt-2 flex sm:justify-end">
                            <x-badge variant="success" class="uppercase text-[8px] px-2.5 py-0.5 font-bold">COMPLETED & RECONCILED</x-badge>
                        </div>
                    </div>
                </div>

                <!-- Addresses / Info Block -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6 text-xs border-b border-slate-100">
                    <div>
                        <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px] mb-1.5">Received From (Resident)</span>
                        <p class="font-bold text-slate-900 text-sm">{{ $payment->resident->name }}</p>
                        <p class="text-slate-500 mt-0.5 font-mono">NIK: {{ $payment->resident->nik }}</p>
                        <p class="text-slate-550 mt-1">Accommodated: {{ $payment->boardingHouse->name }}</p>
                        <p class="font-mono text-indigo-650 mt-0.5 font-semibold">Room {{ $payment->invoice->room ? $payment->invoice->room->room_number : '-' }}</p>
                    </div>
                    <div>
                        <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px] mb-1.5">References & Date</span>
                        <p class="text-slate-500"><strong>Associated Invoice:</strong> <a href="{{ route('invoices.show', $payment->invoice_id) }}" class="text-indigo-650 font-mono hover:underline">#{{ $payment->invoice->invoice_number }}</a></p>
                        <p class="text-slate-550 mt-0.5"><strong>Contract Reference:</strong> <span class="font-mono">{{ $payment->contract ? $payment->contract->contract_number : '-' }}</span></p>
                        <p class="text-slate-550 mt-1"><strong>Payment Method:</strong> {{ $payment->payment_method->label() }}</p>
                        <p class="text-slate-550 mt-0.5"><strong>Payment Settled Date:</strong> {{ $payment->payment_date->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- Financial Details -->
                <div class="py-6 space-y-4">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-slate-400 font-bold uppercase tracking-wider text-[9px] border-b border-slate-100">
                                <th class="py-2.5">Billing description</th>
                                <th class="py-2.5 text-right">Settled Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-slate-100/50">
                                <td class="py-3 font-semibold text-slate-700">Room rent and utilities charges subtotal (Invoice #{{ $payment->invoice->invoice_number }})</td>
                                <td class="py-3 text-right font-bold text-slate-900">Rp{{ number_format($payment->amount_paid, 0, ',', '.') }}</td>
                            </tr>
                            @if($payment->penalty_paid > 0)
                                <tr class="border-b border-slate-100/50">
                                    <td class="py-3 font-semibold text-rose-600">Late Payment Penalty adjustment</td>
                                    <td class="py-3 text-right font-bold text-rose-600">Rp{{ number_format($payment->penalty_paid, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="flex justify-between items-center bg-emerald-50/10 p-4 border border-emerald-100/50 rounded-xl">
                        <span class="text-xs font-bold text-emerald-800">Total Amount Settled</span>
                        <span class="text-md font-extrabold text-emerald-950">Rp{{ number_format($payment->amount_paid + $payment->penalty_paid, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Footer Signature and QR Mock -->
                <div class="flex flex-col sm:flex-row justify-between items-end gap-6 pt-6 border-t border-slate-100 text-[10px] text-slate-400 mt-4 leading-relaxed">
                    <div class="space-y-1">
                        <p class="font-bold text-slate-700">Verifier Stamp:</p>
                        <p class="text-slate-500">Stamps verification by verifier: {{ $payment->verifier ? $payment->verifier->name : '-' }}</p>
                        <p class="text-slate-500">Approved date: {{ $payment->verified_at ? $payment->verified_at->format('d M Y, H:i') : '-' }}</p>
                        @if($payment->reconciliation_notes)
                            <p class="text-slate-450 italic mt-1.5"><strong>Verification notes:</strong> "{{ $payment->reconciliation_notes }}"</p>
                        @endif
                    </div>
                    
                    <!-- QR Box -->
                    <div class="w-20 h-20 border border-slate-150 p-1 bg-white rounded-lg flex flex-col items-center justify-center text-center">
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-[7px] font-bold text-slate-450 uppercase leading-none select-none">
                            QR CODE VERIFIED
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Proof validation details sheet -->
            <x-card title="Payment Proof Verification Details" description="Verify bank transfer files, upload additional confirmations, and reconcile balances.">
                <div class="space-y-5 text-xs">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 border-b border-slate-50 pb-4">
                        <div>
                            <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px]">Total invoiced amount</span>
                            <span class="block font-bold text-slate-800 text-sm mt-1">Rp{{ number_format($payment->invoice->grand_total, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px]">Amount Paid in Transfer</span>
                            <span class="block font-bold text-indigo-650 text-sm mt-1">Rp{{ number_format($payment->amount_paid, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px]">Payment Method</span>
                            <span class="block font-semibold text-slate-850 text-xs mt-1.5">{{ $payment->payment_method->label() }}</span>
                        </div>
                    </div>

                    <!-- Proof Slider/Preview -->
                    <div>
                        <span class="block text-slate-400 font-bold uppercase tracking-wider text-[9px] mb-3">Resident Proof of Payment File</span>
                        
                        @if($payment->proof_of_payment_path)
                            <div class="border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/20 max-w-lg mx-auto">
                                <img src="{{ asset('storage/' . $payment->proof_of_payment_path) }}" alt="Proof of Payment" class="w-full h-auto max-h-[380px] object-contain">
                                <div class="p-3 bg-slate-50 border-t border-slate-100 text-center flex justify-center gap-2">
                                    <x-button variant="outline" size="sm" class="px-2.5! py-1! text-[10px]" onclick="window.open('{{ asset('storage/' . $payment->proof_of_payment_path) }}', '_blank')">View Full Screen</x-button>
                                </div>
                            </div>
                        @else
                            <!-- Livewire Upload file input form for resident -->
                            <div class="p-6 border border-dashed border-slate-200 rounded-2xl text-center space-y-4 bg-slate-50/10">
                                <p class="text-slate-400 italic">No payment proof uploaded. Resident needs to attach bank transfer receipt.</p>
                                
                                <form wire:submit="uploadResidentProof" class="max-w-xs mx-auto space-y-3 pt-3 border-t border-slate-50">
                                    <input type="file" wire:model="proofUpload" accept="image/*"
                                        class="w-full px-2 py-1.5 border border-dashed border-slate-300 rounded-xl text-xs text-slate-500 file:mr-3 file:py-1 file:px-2 file:border-0 file:rounded-lg file:text-[10px] file:bg-indigo-50 file:text-indigo-650 cursor-pointer">
                                    @error('proofUpload') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                                    
                                    <div class="flex justify-center">
                                        <x-button variant="primary" size="sm" type="submit" loading="uploadResidentProof" class="text-xs">Upload Proof File</x-button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </x-card>
        @endif

    </div>

    <!-- Right Column: Verification actions & timelines -->
    <div class="space-y-6">
        
        <!-- Verification actions sidebar -->
        <x-card title="Verification Controls" description="Verify bank transfer authenticity.">
            @if($payment->status->value === 'waiting_verification')
                <form wire:submit.prevent class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Verifier Audit Notes</label>
                        <textarea wire:model="reconciliationNotes" rows="3"
                            class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs"
                            placeholder="Add approval notes or rejection reasons details..."></textarea>
                    </div>

                    <div class="flex flex-col gap-2 pt-2">
                        <x-button variant="primary" size="sm" class="justify-center cursor-pointer bg-emerald-600! hover:bg-emerald-700!" wire:click="approvePayment" loading="approvePayment">
                            Approve Payment (Reconcile)
                        </x-button>
                        <x-button variant="outline" size="sm" class="justify-center cursor-pointer text-rose-600 hover:bg-rose-50 border-slate-200" wire:click="rejectPayment" loading="rejectPayment">
                            Reject & Fail Payment
                        </x-button>
                    </div>
                </form>
            @else
                <div class="space-y-3.5 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Payment Status</span>
                        @php
                            $variant = 'neutral';
                            if ($payment->status->value === 'completed') $variant = 'success';
                            if ($payment->status->value === 'pending') $variant = 'neutral';
                            if ($payment->status->value === 'waiting_verification') $variant = 'info';
                            if ($payment->status->value === 'failed' || $payment->status->value === 'cancelled') $variant = 'danger';
                        @endphp
                        <x-badge :variant="$variant" class="uppercase text-[8px] font-bold px-2 py-0.5">
                            {{ $payment->status->label() }}
                        </x-badge>
                    </div>
                    @if($payment->status->value === 'completed')
                        <div class="flex justify-between items-center text-slate-550 mt-2">
                            <span>Print Receipt</span>
                            <x-button variant="outline" size="sm" class="px-2.5! py-1! text-[10px]" onclick="window.print()">Print</x-button>
                        </div>
                    @endif
                </div>
            @endif
        </x-card>

        <!-- Timelines Card -->
        <x-card title="Payment Logs Timeline" description="Audit log of state shifts.">
            <div class="flow-root mt-2">
                <ul role="list" class="-mb-8">
                    @forelse($payment->timeline as $index => $timelineItem)
                        <li>
                            <div class="relative pb-8">
                                @if($index !== $payment->timeline->count() - 1)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                @endif
                                
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white text-white text-xs font-bold {{ $timelineItem->color ?: 'bg-indigo-500' }}">
                                            @if($timelineItem->event === 'initiated')
                                                +
                                            @elseif($timelineItem->event === 'proof_uploaded')
                                                F
                                            @elseif($timelineItem->event === 'completed')
                                                V
                                            @elseif($timelineItem->event === 'failed')
                                                X
                                            @else
                                                *
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-xs font-bold text-slate-800">{{ $timelineItem->title }}</p>
                                            @if($timelineItem->description)
                                                <p class="text-xs text-slate-500 mt-1 leading-normal">{{ $timelineItem->description }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right text-[10px] whitespace-nowrap text-slate-400 font-semibold font-mono">
                                            <time>{{ $timelineItem->created_at->format('d M, H:i') }}</time>
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

</div>
