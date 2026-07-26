<div class="space-y-6">
    
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ $contractId ? 'Edit Contract Specifications' : 'Draft Lease Contract Agreement' }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">Configure lease terms, auto-renewal configurations, utility fees, and draft signed PDF files.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="outline" size="sm" onclick="window.location.href='{{ route('contracts') }}'">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to List
                </span>
            </x-button>
        </div>
    </div>

    <!-- Progress Stepper Indicator -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 mb-6 flex items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 {{ $step >= 1 ?"bg-indigo-650 text-white' : 'bg-slate-100 text-slate-400  }}">1</span>
            <span class="text-xs font-bold {{ $step === 1 ?"text-slate-800  : 'text-slate-400  }}">General Lease Terms</span>
        </div>
        <div class="h-0.5 flex-1 bg-slate-100 max-w-[120px]"></div>
        <div class="flex items-center gap-2">
            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 {{ $step >= 2 ?"bg-indigo-650 text-white' : 'bg-slate-100 text-slate-400  }}">2</span>
            <span class="text-xs font-bold {{ $step === 2 ?"text-slate-800  : 'text-slate-400  }}">Financial Estimates</span>
        </div>
        <div class="h-0.5 flex-1 bg-slate-100 max-w-[120px]"></div>
        <div class="flex items-center gap-2">
            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 {{ $step >= 3 ?"bg-indigo-650 text-white' : 'bg-slate-100 text-slate-400  }}">3</span>
            <span class="text-xs font-bold {{ $step === 3 ?"text-slate-800  : 'text-slate-400  }}">Admin Documentation</span>
        </div>
    </div>

    <!-- Form Wizard Steps -->
    <div class="space-y-6">

        <!-- STEP 1: General Terms -->
        @if($step === 1)
            <x-card title="General Lease Specifications" description="Select property boarding house, target resident, room allocation, and lease duration boundaries.">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    
                    <!-- Property Boarding House -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Boarding House Property</label>
                        <select wire:model.live="boarding_house_id" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none">
                            <option value="">Select Property...</option>
                            @foreach($boardingHouses as $house)
                                <option value="{{ $house->id }}">{{ $house->name }}</option>
                            @endforeach
                        </select>
                        @error('boarding_house_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Room Selection -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Target Room</label>
                        <select wire:model.live="room_id" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none">
                            <option value="">Choose Room...</option>
                            @foreach($availableRooms as $room)
                                <option value="{{ $room->id }}">Room {{ $room->room_number }} (Rp{{ number_format($room->monthly_rent, 0, ',', '.') }}/mo)</option>
                            @endforeach
                        </select>
                        @error('room_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Resident / Tenant Selection -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Resident Tenant</label>
                        <select wire:model="resident_id" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none">
                            <option value="">Select Resident...</option>
                            @foreach($residents as $res)
                                <option value="{{ $res->id }}">{{ $res->name }} (NIK: {{ $res->nik }})</option>
                            @endforeach
                        </select>
                        @error('resident_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-5">
                    <!-- Contract Type -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Billing Type</label>
                        <select wire:model="contract_type"
                            class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none">
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="semi_annual">Semi-Annual</option>
                            <option value="annual">Annual</option>
                            <option value="custom">Custom Duration</option>
                        </select>
                    </div>

                    <!-- Start date -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Start Date</label>
                        <input wire:model="start_date" type="date" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        @error('start_date') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- End date -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">End Date</label>
                        <input wire:model="end_date" type="date" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        @error('end_date') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Duration months -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Duration (Months)</label>
                        <input wire:model="duration_months" type="number" required min="1" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        @error('duration_months') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5 pt-4 border-t border-slate-50">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Actual Move-in Date</label>
                        <input wire:model="move_in_date" type="date" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    </div>
                    <div class="flex items-center gap-3 pt-6">
                        <input wire:model="auto_renewal" type="checkbox" id="auto_r" class="rounded border-slate-300 text-indigo-650 focus:ring-indigo-500">
                        <label for="auto_r" class="text-xs font-bold text-slate-700 select-none cursor-pointer">Auto Contract Renewal Option enabled</label>
                    </div>
                </div>
            </x-card>
        @endif

        <!-- STEP 2: Financial Details -->
        @if($step === 2)
            <x-card title="Financial Estimates & Extras" description="Define pricing matrix details including monthly rent rates, utilities, deposit parameters, and discounts.">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Monthly Rent -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Monthly Rent price (IDR)</label>
                        <input wire:model="monthly_rent" type="number" required min="0" step="1000"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm">
                        @error('monthly_rent') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Security Deposit -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Paid Security Deposit (IDR)</label>
                        <input wire:model="security_deposit" type="number" required min="0" step="1000"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm">
                        @error('security_deposit') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Discount -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Lease Monthly Discount (IDR)</label>
                        <input wire:model="discount" type="number" required min="0" step="1000"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm">
                        @error('discount') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-5 pt-4 border-t border-slate-50">
                    <!-- Electricity -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Electricity tokens</label>
                        <input wire:model="electricity_fee" type="number" required min="0" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    </div>

                    <!-- Water -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Water fee</label>
                        <input wire:model="water_fee" type="number" required min="0" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    </div>

                    <!-- Internet -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Internet connection</label>
                        <input wire:model="internet_fee" type="number" required min="0" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    </div>

                    <!-- Parking -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Parking lot fee</label>
                        <input wire:model="parking_fee" type="number" required min="0" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    </div>

                    <!-- Additional -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Additional charges</label>
                        <input wire:model="additional_charges" type="number" required min="0" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    </div>
                </div>
            </x-card>
        @endif

        <!-- STEP 3: Admin Notes -->
        @if($step === 3)
            <x-card title="Contract Documentation Details" description="Provide internal descriptions, house rules annotations, and public agreement footnotes.">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Internal Office Notes (Private)</label>
                        <textarea wire:model="internal_notes" rows="3"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm"
                            placeholder="Private annotations, approval checklist notes, background context details..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Public Contract Agreement Notes (Footnotes)</label>
                        <textarea wire:model="public_notes" rows="3"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm"
                            placeholder="Additional public rules annotations, payment terms additions, custom duration extensions..."></textarea>
                    </div>
                </div>
            </x-card>
        @endif

        <!-- Stepper Navigation Footer -->
        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            @if($step > 1)
                <x-button variant="outline" size="sm" type="button" wire:click="prevStep">
                    Back Step
                </x-button>
            @else
                <div></div>
            @endif

            @if($step < 3)
                <x-button variant="primary" size="sm" type="button" wire:click="nextStep">
                    Next Step
                </x-button>
            @else
                <x-button variant="primary" size="sm" type="button" wire:click="saveContract" loading="saveContract">
                    {{ $contractId ? 'Save Contract Specifications' : 'Draft Lease Agreement' }}
                </x-button>
            @endif
        </div>

    </div>

</div>
