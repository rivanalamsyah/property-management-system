<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ activeTab: @entangle('activeTab') }">
    
    <!-- Left Column: Profile Card -->
    <div class="space-y-6">
        <x-card class="text-center py-6 px-4">
            <!-- Avatar -->
            <div class="relative inline-block mx-auto mb-4">
                <img class="h-24 w-24 rounded-full object-cover bg-slate-100 border-2 border-indigo-600 p-0.5" 
                     src="{{ $resident->photo ? asset('storage/' . $resident->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($resident->name) . '&background=ede9fe&color=4f46e5' }}">
                
                <div class="absolute bottom-0 right-0">
                    @php
                        $variant = 'neutral';
                        if ($resident->status->value === 'active') $variant = 'success';
                        if ($resident->status->value === 'reserved') $variant = 'info';
                        if ($resident->status->value === 'late_payment') $variant = 'warning';
                        if ($resident->status->value === 'former' || $resident->status->value === 'blacklisted') $variant = 'danger';
                    @endphp
                    <span class="w-3.5 h-3.5 rounded-full border-2 border-white block {{ $resident->status->value === 'active' ? 'bg-emerald-500' : '' }}
                        {{ $resident->status->value === 'reserved' ? 'bg-indigo-500' : '' }}
                        {{ $resident->status->value === 'former' ? 'bg-rose-500' : '' }}
                        {{ $resident->status->value === 'pending' ? 'bg-slate-400' : '' }}
                    "></span>
                </div>
            </div>

            <h2 class="text-lg font-bold text-slate-900">{{ $resident->name }}</h2>
            <p class="text-xs text-slate-400 font-mono mt-0.5">NIK: {{ $resident->nik }}</p>

            <div class="mt-4 flex justify-center">
                <x-badge :variant="$variant" class="uppercase text-[9px] px-3 py-1 font-bold">{{ $resident->status->label() }}</x-badge>
            </div>

            <!-- Contacts Info list -->
            <div class="mt-6 text-left border-t border-slate-50 pt-5 space-y-3.5">
                <div>
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Mobile Contact</h5>
                    <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $resident->phone }}</p>
                </div>
                <div>
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Email Address</h5>
                    <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $resident->email }}</p>
                </div>
                <div>
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Identity Address</h5>
                    <p class="text-xs text-slate-600 mt-0.5">{{ $resident->address }}, {{ $resident->district }}, {{ $resident->city }}, {{ $resident->province }} ({{ $resident->postal_code }})</p>
                </div>
            </div>
        </x-card>

        <!-- Emergency Contact Card -->
        <x-card title="Emergency Contacts" description="Immediate relative information.">
            <div class="space-y-4">
                <div>
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Guardian Name</h5>
                    <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $resident->emergency_name }}</p>
                    <p class="text-[10px] text-slate-400 font-medium">Relationship: {{ $resident->emergency_relationship }}</p>
                </div>
                <div>
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Phone No.</h5>
                    <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $resident->emergency_phone }}</p>
                </div>
                <div>
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Guardian Address</h5>
                    <p class="text-xs text-slate-650 mt-0.5">{{ $resident->emergency_address }}</p>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Right Column: Tabs & Lifecycle Check processes -->
    <div class="col-span-1 lg:col-span-2 space-y-6">
        
        <!-- Tabs Header -->
        <div class="border-b border-slate-100 flex flex-wrap gap-2 mb-2 bg-white p-2.5 rounded-2xl border border-slate-100">
            <button @click="activeTab = 'check'" :class="{'bg-indigo-50 text-indigo-600': activeTab === 'check', 'text-slate-500 hover:text-slate-700': activeTab !== 'check'}"
                class="px-4 py-2 text-xs font-bold rounded-xl transition cursor-pointer">Lifecycle Actions</button>
            <button @click="activeTab = 'documents'" :class="{'bg-indigo-50 text-indigo-600': activeTab === 'documents', 'text-slate-500 hover:text-slate-700': activeTab !== 'documents'}"
                class="px-4 py-2 text-xs font-bold rounded-xl transition cursor-pointer">Documents Vault</button>
            <button @click="activeTab = 'timeline'" :class="{'bg-indigo-50 text-indigo-600': activeTab === 'timeline', 'text-slate-500 hover:text-slate-700': activeTab !== 'timeline'}"
                class="px-4 py-2 text-xs font-bold rounded-xl transition cursor-pointer">Activity Timeline</button>
        </div>

        <!-- Tab 1: Check-In/Check-Out Action wizard -->
        <div x-show="activeTab === 'check'" class="space-y-6">
            
            <!-- Check-in process if pending/reserved -->
            @if($resident->status->value === 'pending' || $resident->status->value === 'reserved')
                <x-card title="Execute Check-In Process" description="Assign a room, set initial meter readings, security deposit parameters, and confirm keys handover.">
                    <form wire:submit="executeCheckIn" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Boarding House select -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Property Boarding House</label>
                                <select wire:model.live="check_in_boarding_house_id" required
                                    class="w-full px-3 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none">
                                    <option value="">Select Property...</option>
                                    @foreach($boardingHouses = \App\Models\BoardingHouse::all() as $house)
                                        <option value="{{ $house->id }}">{{ $house->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Room selection -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Available Room</label>
                                <select wire:model="check_in_room_id" required
                                    class="w-full px-3 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none">
                                    <option value="">Choose Room...</option>
                                    @foreach($availableRooms as $room)
                                        <option value="{{ $room->id }}">Room {{ $room->room_number }} (Rp{{ number_format($room->monthly_rent, 0, ',', '.') }}/mo)</option>
                                    @endforeach
                                </select>
                                @error('check_in_room_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Check-in Date</label>
                                <input wire:model="check_in_date" type="date" required
                                    class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Move-In Time</label>
                                <input wire:model="move_in_time" type="time"
                                    class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Initial Meter Reading (kWh)</label>
                                <input wire:model="initial_meter_reading" type="number" step="0.01"
                                    class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none" placeholder="e.g., 100.50">
                                @error('initial_meter_reading') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Paid Security Deposit (IDR)</label>
                            <input wire:model="security_deposit" type="number" required min="0" step="1000"
                                class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. 500000">
                            @error('security_deposit') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Check-in Notes</label>
                            <textarea wire:model="check_in_notes" rows="2" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="Handover checklist details, key conditions..."></textarea>
                        </div>

                        <div class="flex justify-end pt-2">
                            <x-button variant="primary" size="sm" type="submit" loading="executeCheckIn">Confirm Check-In Handover</x-button>
                        </div>
                    </form>
                </x-card>
            @endif

            <!-- Active Resident Detail & Checkout -->
            @if($resident->status->value === 'active' || $resident->status->value === 'late_payment' || $resident->status->value === 'moving_out')
                <!-- Active Room summary -->
                <x-card title="Active Accommodation Info" description="Current checked-in boarding house and room parameters.">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-xs">
                        <div>
                            <span class="block text-slate-400 uppercase tracking-wider font-semibold">Boarding House</span>
                            <span class="block text-sm font-bold text-slate-800 mt-1">{{ $resident->boardingHouse->name }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-400 uppercase tracking-wider font-semibold">Room Number</span>
                            <span class="block text-sm font-bold text-indigo-600 mt-1">Room {{ $resident->room->room_number }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-400 uppercase tracking-wider font-semibold">Check-in Date</span>
                            <span class="block text-sm font-semibold text-slate-800 mt-1">{{ $resident->check_in_date->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-400 uppercase tracking-wider font-semibold">Initial Meter Reading</span>
                            <span class="block text-sm font-semibold text-slate-800 mt-1">{{ $resident->initial_meter_reading ?? '-' }} kWh</span>
                        </div>
                    </div>
                </x-card>

                <!-- Check-out wizard -->
                <x-card title="Process Check-Out" description="Initiate checkout procedures, finalize meter readings, assess room damage, and release room availability.">
                    <form wire:submit="executeCheckOut" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Check-Out Date</label>
                                <input wire:model="check_out_date" type="date" required
                                    class="w-full px-3 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none">
                                @error('check_out_date') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Final Meter Reading (kWh)</label>
                                <input wire:model="final_meter_reading" type="number" step="0.01"
                                    class="w-full px-3 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none" placeholder="e.g. 150.75">
                                @error('final_meter_reading') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Damage Notes / Fines</label>
                                <textarea wire:model="damage_notes" rows="2" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="List wall paint scratches, broken lights, lost keys..."></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Final Check-Out Notes</label>
                                <textarea wire:model="check_out_notes" rows="2" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="Deposit refund details, checklist approvals..."></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <x-button variant="danger" size="sm" type="submit" loading="executeCheckOut">Confirm Check-Out & Release Room</x-button>
                        </div>
                    </form>
                </x-card>
            @endif

            <!-- Former Tenant Summary -->
            @if($resident->status->value === 'former')
                <x-card title="Historical Check logs" description="Checkout details and archives.">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div class="space-y-2">
                            <p class="text-slate-500"><strong>Check-In Date:</strong> {{ $resident->check_in_date ? $resident->check_in_date->format('d M Y') : '-' }}</p>
                            <p class="text-slate-500"><strong>Check-Out Date:</strong> {{ $resident->check_out_date ? $resident->check_out_date->format('d M Y') : '-' }}</p>
                            <p class="text-slate-500"><strong>Paid Security Deposit:</strong> Rp{{ number_format($resident->security_deposit, 0, ',', '.') }}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-slate-500"><strong>Initial / Final Meter:</strong> {{ $resident->initial_meter_reading ?? '-' }} / {{ $resident->final_meter_reading ?? '-' }} kWh</p>
                            @if($resident->damage_notes)
                                <p class="text-rose-600"><strong>Damage logs:</strong> {{ $resident->damage_notes }}</p>
                            @endif
                            @if($resident->check_out_notes)
                                <p class="text-slate-500"><strong>Notes:</strong> {{ $resident->check_out_notes }}</p>
                            @endif
                        </div>
                    </div>
                </x-card>
            @endif

        </div>

        <!-- Tab 2: Identity Documents -->
        <div x-show="activeTab === 'documents'" class="space-y-6">
            <x-card title="Documents Upload & Vault" description="Attach identity KTP, Passport, Student/Work verification certificates.">
                
                <form wire:submit="uploadDocument" class="space-y-4 pb-6 border-b border-slate-50 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <!-- Doc type selection -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Document Type</label>
                            <select wire:model="docType"
                                class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none">
                                <option value="KTP">KTP Card</option>
                                <option value="Passport">Passport File</option>
                                <option value="Family Card">Family Card (KK)</option>
                                <option value="Student Card">Student ID Card</option>
                                <option value="Employee Card">Employee ID Card</option>
                            </select>
                        </div>

                        <!-- Choose file -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Select File (JPG, PNG, PDF max 2MB)</label>
                            <input type="file" wire:model="docUpload" accept="image/*,application/pdf"
                                class="w-full px-2.5 py-1.5 bg-slate-50/50 border border-dashed border-slate-300 rounded-xl text-xs text-slate-500 focus:outline-none file:mr-3 file:py-1 file:px-2 file:border-0 file:rounded-lg file:text-[10px] file:bg-indigo-50 file:text-indigo-650 file:cursor-pointer">
                            @error('docUpload') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Caption label -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Doc Caption Label</label>
                            <div class="flex items-center gap-2">
                                <input wire:model="docLabel" type="text" class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="e.g. KTP Budi">
                                <x-button variant="primary" size="sm" type="submit" loading="uploadDocument">Upload</x-button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Document Previews List Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($resident->documents as $docItem)
                        <div class="flex items-center justify-between p-4 border border-slate-100 rounded-xl bg-slate-50/20">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                    DOC
                                </div>
                                <div class="max-w-[150px]">
                                    <h4 class="text-xs font-bold text-slate-800 truncate">{{ $docItem->document_type }}</h4>
                                    <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ $docItem->label ?: 'Attached File' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <x-button variant="outline" size="sm" class="px-2.5! py-1! text-[10px] font-bold" onclick="window.open('{{ asset('storage/' . $docItem->file_path) }}', '_blank')">Preview</x-button>
                                <x-button variant="outline" size="sm" class="px-2.5! py-1! text-[10px] text-rose-600 hover:bg-rose-50 border-slate-200 cursor-pointer" wire:click="deleteDocument({{ $docItem->id }})">Delete</x-button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <x-empty-state title="No identity documents attached" description="Upload digital scans of KTP cards, student credentials, or passports for identity screening logs."></x-empty-state>
                        </div>
                    @endforelse
                </div>

            </x-card>
        </div>

        <!-- Tab 3: Timeline -->
        <div x-show="activeTab === 'timeline'" class="space-y-6">
            <x-card title="Activity Timeline" description="Chronological log of events associated with this resident.">
                
                <div class="flow-root mt-4">
                    <ul role="list" class="-mb-8">
                        @forelse($resident->timeline as $index => $timelineItem)
                            <li>
                                <div class="relative pb-8">
                                    @if($index !== $resident->timeline->count() - 1)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                    @endif
                                    
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white text-white text-xs font-bold {{ $timelineItem->color ?:"bg-indigo-500' }}">
                                                <!-- Icon fallback text characters -->
                                                @if($timelineItem->event === 'created')
                                                    +
                                                @elseif($timelineItem->event === 'check_in')
                                                    IN
                                                @elseif($timelineItem->event === 'check_out')
                                                    OUT
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
                            <x-empty-state title="Timeline logs are empty" description="Events will record here automatically as checkout processes or uploads occur."></x-empty-state>
                        @endforelse
                    </ul>
                </div>

            </x-card>
        </div>

    </div>

</div>
