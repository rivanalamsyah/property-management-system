<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ activeTab: @entangle('activeTab') }">
    
    <!-- Left Column: Summary & Fees -->
    <div class="space-y-6">
        <x-card class="py-6 px-4">
            <div class="text-center mb-6">
                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Contract specifications</span>
                <h2 class="text-xl font-mono font-bold text-slate-800 mt-1">{{ $contract->contract_number }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">Version {{ $contract->version }}</p>

                <div class="mt-3 flex justify-center">
                    @php
                        $variant = 'neutral';
                        if ($contract->status->value === 'active') $variant = 'success';
                        if ($contract->status->value === 'draft') $variant = 'neutral';
                        if ($contract->status->value === 'pending_approval') $variant = 'info';
                        if ($contract->status->value === 'expiring_soon') $variant = 'warning';
                        if ($contract->status->value === 'expired' || $contract->status->value === 'terminated' || $contract->status->value === 'cancelled') $variant = 'danger';
                    @endphp
                    <x-badge :variant="$variant" class="uppercase text-[9px] px-3 py-1 font-bold">{{ $contract->status->label() }}</x-badge>
                </div>
            </div>

            <!-- Basic stats -->
            <div class="border-t border-slate-50 pt-5 space-y-4 text-xs">
                <div>
                    <span class="block text-slate-400 font-semibold uppercase tracking-wider text-[9px]">Resident / Tenant</span>
                    <span class="block text-sm font-bold text-slate-850 mt-0.5">{{ $contract->resident->name }}</span>
                    <span class="block text-[10px] text-slate-400 font-mono">NIK: {{ $contract->resident->nik }}</span>
                </div>
                <div>
                    <span class="block text-slate-400 font-semibold uppercase tracking-wider text-[9px]">Accommodation room</span>
                    <span class="block text-sm font-bold text-slate-850 mt-0.5">{{ $contract->boardingHouse->name }}</span>
                    <span class="block mt-1 font-mono">
                        <x-badge variant="info" class="text-[9px]">Room {{ $contract->room ? $contract->room->room_number : '-' }}</x-badge>
                    </span>
                </div>
                <div>
                    <span class="block text-slate-400 font-semibold uppercase tracking-wider text-[9px]">Lease Duration Period</span>
                    <span class="block text-sm font-semibold text-slate-800 mt-0.5">
                        {{ $contract->start_date->format('d M Y') }} - {{ $contract->end_date->format('d M Y') }}
                    </span>
                    <span class="block text-[10px] text-slate-400 mt-0.5">({{ $contract->duration_months }} Months, billing type: {{ $contract->contract_type->label() }})</span>
                </div>
            </div>
        </x-card>

        <!-- Pricing details breakdown -->
        <x-card title="Pricing Details Breakdown" description="Estimates of monthly costs and refundable deposit balances.">
            <div class="space-y-3.5 text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-slate-450">Monthly Room Rent</span>
                    <span class="font-bold text-slate-900">Rp{{ number_format($contract->monthly_rent, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-450">Paid Security Deposit</span>
                    <span class="font-bold text-slate-900">Rp{{ number_format($contract->security_deposit, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-450">Electricity Tokens</span>
                    <span class="font-semibold text-slate-700">Rp{{ number_format($contract->electricity_fee, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-450">Water Utility Fee</span>
                    <span class="font-semibold text-slate-700">Rp{{ number_format($contract->water_fee, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-450">Internet Connection</span>
                    <span class="font-semibold text-slate-700">Rp{{ number_format($contract->internet_fee, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-450">Parking Lot Fee</span>
                    <span class="font-semibold text-slate-700">Rp{{ number_format($contract->parking_fee, 0, ',', '.') }}</span>
                </div>
                @if($contract->discount > 0)
                    <div class="flex items-center justify-between text-emerald-600 font-medium">
                        <span>Applied Monthly Discount</span>
                        <span>-Rp{{ number_format($contract->discount, 0, ',', '.') }}</span>
                    </div>
                @endif
            </div>
        </x-card>
    </div>

    <!-- Right Column: Tabs & wizards content -->
    <div class="col-span-1 lg:col-span-2 space-y-6">
        
        <!-- Tab selector headers -->
        <div class="border-b border-slate-100 flex flex-wrap gap-2 mb-2 bg-white p-2.5 rounded-2xl border border-slate-100">
            <button @click="activeTab = 'preview'" :class="{"bg-indigo-50  text-indigo-600  activeTab === 'preview', 'text-slate-500 hover:text-slate-700': activeTab !== 'preview'}"
                class="px-4 py-2 text-xs font-bold rounded-xl transition cursor-pointer">PDF Agreement</button>
            <button @click="activeTab = 'renew'" :class="{"bg-indigo-50  text-indigo-600  activeTab === 'renew', 'text-slate-500 hover:text-slate-700': activeTab !== 'renew'}"
                class="px-4 py-2 text-xs font-bold rounded-xl transition cursor-pointer">Contract Renewal</button>
            <button @click="activeTab = 'attachments'" :class="{"bg-indigo-50  text-indigo-600  activeTab === 'attachments', 'text-slate-500 hover:text-slate-700': activeTab !== 'attachments'}"
                class="px-4 py-2 text-xs font-bold rounded-xl transition cursor-pointer">Attachments Vault</button>
            <button @click="activeTab = 'history'" :class="{"bg-indigo-50  text-indigo-600  activeTab === 'history', 'text-slate-500 hover:text-slate-700': activeTab !== 'history'}"
                class="px-4 py-2 text-xs font-bold rounded-xl transition cursor-pointer">Versions Archive</button>
            <button @click="activeTab = 'timeline'" :class="{"bg-indigo-50  text-indigo-600  activeTab === 'timeline', 'text-slate-500 hover:text-slate-700': activeTab !== 'timeline'}"
                class="px-4 py-2 text-xs font-bold rounded-xl transition cursor-pointer">Activity Logs</button>
        </div>

        <!-- Tab 1: PDF Preview -->
        <div x-show="activeTab === 'preview'" class="space-y-6">
            @if($contract->status->value === 'draft')
                <!-- Activation Banner -->
                <x-card class="bg-indigo-50/30! border-indigo-100!">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="space-y-1">
                            <h4 class="text-sm font-bold text-slate-800">Activate Lease Contract Draft</h4>
                            <p class="text-xs text-slate-500 leading-normal">Activating this contract creates a signed PDF agreement, switches its status, and completes check-in constraints validations.</p>
                        </div>
                        <div class="flex-shrink-0">
                            <x-button variant="primary" size="sm" type="button" wire:click="activateAgreement">
                                Activate Agreement
                            </x-button>
                        </div>
                    </div>
                </x-card>
            @endif

            <x-card title="Signed PDF Agreement Document" description="Official lease contract documentation, QR verification signatures, and rule summaries.">
                @if($contract->signed_pdf_path)
                    <div class="p-6 border border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center text-center space-y-4 bg-slate-50/10">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-bold">
                            PDF
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">Lease Contract File Available</h4>
                            <p class="text-xs text-slate-400 mt-1">File name: {{ basename($contract->signed_pdf_path) }}</p>
                        </div>
                        <div class="flex gap-3">
                            <x-button variant="outline" size="sm" onclick="window.open('{{ asset('storage/' . $contract->signed_pdf_path) }}', '_blank')">
                                Download Signed Contract
                            </x-button>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6 text-slate-400 text-xs italic">
                        No signed PDF generated. Please activate the agreement draft to output files.
                    </div>
                @endif
            </x-card>
        </div>

        <!-- Tab 2: Renew Contract -->
        <div x-show="activeTab === 'renew'" class="space-y-6">
            <x-card title="Extend / Renew Lease Agreement" description="Generate a new contract version, adjust dates, and update monthly rental prices.">
                <form wire:submit="executeRenewal" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Renewal Start Date</label>
                            <input wire:model="renewal_start_date" type="date" required
                                class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none">
                            @error('renewal_start_date') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Renewal End Date</label>
                            <input wire:model="renewal_end_date" type="date" required
                                class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none">
                            @error('renewal_end_date') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Duration (Months)</label>
                            <input wire:model="renewal_duration_months" type="number" required min="1"
                                class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Adjusted Monthly Rent price (IDR)</label>
                        <input wire:model="renewal_monthly_rent" type="number" required min="0" step="1000"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm">
                        @error('renewal_monthly_rent') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Reason for Extension / Renewal version changes</label>
                        <textarea wire:model="renewal_reason" rows="2" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="e.g. Standard 6-month extension with 5% pricing updates..."></textarea>
                        @error('renewal_reason') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <x-button variant="primary" size="sm" type="submit" loading="executeRenewal">Execute Renewal Extension</x-button>
                    </div>
                </form>
            </x-card>
        </div>

        <!-- Tab 3: Attachments Vault -->
        <div x-show="activeTab === 'attachments'" class="space-y-6">
            <x-card title="Contract Attachments & Files Vault" description="Upload additional receipts, identity cards scan copies, or signed signature scans.">
                
                <form wire:submit="uploadAttachment" class="space-y-4 pb-6 border-b border-slate-50 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Choose File (max 5MB)</label>
                            <input type="file" wire:model="attachUpload" accept="image/*,application/pdf,application/zip"
                                class="w-full px-2.5 py-1.5 bg-slate-50/50 border border-dashed border-slate-300 rounded-xl text-xs text-slate-500 focus:outline-none file:mr-3 file:py-1 file:px-2 file:border-0 file:rounded-lg file:text-[10px] file:bg-indigo-50 file:text-indigo-650 file:cursor-pointer">
                            @error('attachUpload') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Attachment Label</label>
                            <div class="flex items-center gap-2">
                                <input wire:model="attachLabel" type="text" required class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="e.g. Deposit Bank Transfer Slip">
                                <x-button variant="primary" size="sm" type="submit" loading="uploadAttachment">Attach</x-button>
                            </div>
                            @error('attachLabel') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </form>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($contract->attachments as $attachItem)
                        <div class="flex items-center justify-between p-4 border border-slate-100 rounded-xl bg-slate-50/20">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                    FILE
                                </div>
                                <div class="max-w-[150px]">
                                    <h4 class="text-xs font-bold text-slate-800 truncate">{{ $attachItem->label }}</h4>
                                    <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ basename($attachItem->file_path) }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <x-button variant="outline" size="sm" class="px-2.5! py-1! text-[10px] font-bold" onclick="window.open('{{ asset('storage/' . $attachItem->file_path) }}', '_blank')">Preview</x-button>
                                <x-button variant="outline" size="sm" class="px-2.5! py-1! text-[10px] text-rose-600 hover:bg-rose-50 border-slate-200 cursor-pointer" wire:click="deleteAttachment({{ $attachItem->id }})">Delete</x-button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <x-empty-state title="No supporting attachments" description="Upload bank transfer receipts, co-signer documents, or background checking archives."></x-empty-state>
                        </div>
                    @endforelse
                </div>

            </x-card>
        </div>

        <!-- Tab 4: Version History -->
        <div x-show="activeTab === 'history'" class="space-y-6">
            <x-card title="Historical Contract Versions" description="Archived agreement revisions showing dates and pricing shifts logs.">
                
                <div class="space-y-4">
                    @forelse($contract->versions as $ver)
                        <div class="p-4 border border-slate-100 rounded-2xl space-y-3 bg-slate-50/10">
                            <div class="flex items-center justify-between border-b border-slate-50 pb-2">
                                <div class="flex items-center gap-2">
                                    <x-badge variant="info" class="text-[10px] font-bold">Version {{ $ver->version_number }}</x-badge>
                                    <span class="text-xs font-semibold text-slate-700">Renewed by: {{ $ver->creator->name }}</span>
                                </div>
                                <span class="text-[10px] text-slate-400 font-bold">{{ $ver->created_at->format('d M Y, H:i') }}</span>
                            </div>

                            <p class="text-xs text-slate-500 font-medium"><strong>Reason:</strong> {{ $ver->reason }}</p>

                            <!-- Version values table -->
                            <div class="grid grid-cols-2 gap-4 text-[10px] text-slate-450 bg-slate-50/50 p-2.5 rounded-xl border border-slate-100/50">
                                <div>
                                    <p class="font-bold uppercase tracking-wider text-[8px] text-slate-400">Previous Parameters</p>
                                    <p class="mt-1">Rent: Rp{{ number_format($ver->previous_values['monthly_rent'], 0, ',', '.') }}</p>
                                    <p class="mt-0.5">Period: {{ date('d M Y', strtotime($ver->previous_values['start_date'])) }} - {{ date('d M Y', strtotime($ver->previous_values['end_date'])) }}</p>
                                    <p class="mt-0.5">Duration: {{ $ver->previous_values['duration_months'] }} Months</p>
                                </div>
                                <div>
                                    <p class="font-bold uppercase tracking-wider text-[8px] text-slate-400">Signed PDF Archive</p>
                                    @if(isset($ver->previous_values['signed_pdf_path']))
                                        <p class="mt-2">
                                            <a href="{{ asset('storage/' . $ver->previous_values['signed_pdf_path']) }}" target="_blank" class="text-indigo-650 font-bold hover:underline">Download PDF (v{{ $ver->version_number }})</a>
                                        </p>
                                    @else
                                        <p class="mt-2 text-slate-400 italic">No PDF archive available</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs italic">
                            This contract is currently on its initial version (v{{ $contract->version }}). Revisions will show here on renewals.
                        </div>
                    @endforelse
                </div>

            </x-card>
        </div>

        <!-- Tab 5: Timeline -->
        <div x-show="activeTab === 'timeline'" class="space-y-6">
            <x-card title="Agreement Status Logs Timeline" description="Chronological log of events associated with this contract.">
                
                <div class="flow-root mt-4">
                    <ul role="list" class="-mb-8">
                        @forelse($contract->timeline as $index => $timelineItem)
                            <li>
                                <div class="relative pb-8">
                                    @if($index !== $contract->timeline->count() - 1)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                    @endif
                                    
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white text-white text-xs font-bold {{ $timelineItem->color ?:"bg-indigo-500' }}">
                                                @if($timelineItem->event === 'created')
                                                    +
                                                @elseif($timelineItem->event === 'activated')
                                                    V
                                                @elseif($timelineItem->event === 'renewed')
                                                    R
                                                @else
                                                    *
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">{{ $timelineItem->title }}</p>
                                                @if($timelineItem->description)
                                                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $timelineItem->description }}</p>
                                                @endif
                                            </div>
                                            <div class="text-right text-[10px] whitespace-nowrap text-slate-400 font-semibold">
                                                <time>{{ $timelineItem->created_at->format('d M, H:i') }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <x-empty-state title="Timeline logs are empty" description="Timeline logs will populate automatically as activations occur."></x-empty-state>
                        @endforelse
                    </ul>
                </div>

            </x-card>
        </div>

    </div>

</div>
