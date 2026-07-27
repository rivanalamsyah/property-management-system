<div class="space-y-6">
    
    <!-- Title & Action -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Rooms Management</h1>
            <p class="text-sm text-slate-500 mt-1">Configure room allocations, sizes, monthly rents, facilities, and generate check-in QR codes.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" onclick="window.location.href='{{ route('rooms.create') }}'">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Room
                </span>
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total Rooms</p>
            <h3 class="text-lg font-bold text-slate-900 mt-1">{{ $totalCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Available</p>
            <h3 class="text-lg font-bold text-emerald-600 mt-1">{{ $availableCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Occupied</p>
            <h3 class="text-lg font-bold text-indigo-600 mt-1">{{ $occupiedCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Occupancy %</p>
            <h3 class="text-lg font-bold text-slate-900 mt-1">{{ $occupancyRate }}%</h3>
        </x-card>
        <x-card class="py-3! px-4! col-span-2 md:col-span-1 lg:col-span-2">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Revenue Potential (Current / Max)</p>
            <h3 class="text-sm font-bold text-slate-900 mt-1">
                Rp{{ number_format($currentRevenue, 0, ',', '.') }} / <span class="text-slate-400 font-normal">Rp{{ number_format($monthlyRevenuePotential, 0, ',', '.') }}</span>
            </h3>
        </x-card>
    </div>

    <!-- Filters Section -->
    <x-card class="py-4 px-6">
        <div class="space-y-4">
            <div class="flex flex-col lg:flex-row items-center gap-4">
                <!-- Search -->
                <div class="flex-1 w-full relative">
                    <input wire:model.live.debounce.250ms="search" type="text"
                        class="w-full pl-10 pr-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="Search by room number, name, or code...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <!-- Boarding House Select Filter -->
                <div class="w-full lg:w-56">
                    <select wire:model.live="filterBoardingHouse"
                        class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="">All Boarding Houses</option>
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="w-full lg:w-44">
                    <select wire:model.live="filterStatus"
                        class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="">All Statuses</option>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="reserved">Reserved</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="cleaning">Cleaning</option>
                        <option value="unavailable">Unavailable</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Advanced Filter row: Price, Floor, Type -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 pt-3 border-t border-slate-50">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Room Type</label>
                    <select wire:model.live="filterType" class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        <option value="">All Types</option>
                        <option value="Standard">Standard</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Suite">Suite</option>
                        <option value="VIP">VIP</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Floor</label>
                    <select wire:model.live="filterFloor" class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        <option value="">All Floors</option>
                        <option value="1">1st Floor</option>
                        <option value="2">2nd Floor</option>
                        <option value="3">3rd Floor</option>
                        <option value="4">4th Floor</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Min Price (IDR)</label>
                    <input wire:model.live.debounce.300ms="filterMinPrice" type="number" class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="e.g. 500000">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Max Price (IDR)</label>
                    <input wire:model.live.debounce.300ms="filterMaxPrice" type="number" class="w-full px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="e.g. 3000000">
                </div>
            </div>

            <!-- Facilities filter badges selection -->
            <div class="pt-3 border-t border-slate-50">
                <label class="block text-xs font-semibold text-slate-400 mb-2">Filter by Facilities</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($allFacilities as $facility)
                        <label class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl border text-xs font-semibold cursor-pointer select-none transition {{ in_array($facility->id, $filterFacilities) ? 'bg-indigo-50 text-indigo-600 border-indigo-200' : 'bg-white border-slate-200 text-slate-650 hover:bg-slate-50' }}">
                            <input type="checkbox" wire:model.live="filterFacilities" value="{{ $facility->id }}" class="hidden">
                            <span>{{ $facility->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </x-card>

    <!-- Bulk Action floating bar (Sticky bottom) -->
    @if(count($selectedIds) > 0)
        <div class="fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-slate-900/95 border border-slate-800 shadow-xl px-6 py-3 rounded-2xl flex items-center gap-6 z-50 text-white animate-fade-in">
            <span class="text-xs font-semibold text-slate-350"><strong class="text-white">{{ count($selectedIds) }}</strong> selected</span>
            
            <div class="h-4 w-px bg-slate-800"></div>

            <div class="flex items-center gap-2">
                <x-button variant="outline" size="sm" class="bg-transparent! text-white border-slate-800 hover:bg-slate-800! py-1! px-2.5! text-xs font-semibold" wire:click="triggerBulkStatus">
                    Shift Status
                </x-button>
                <x-button variant="outline" size="sm" class="bg-transparent! text-white border-slate-800 hover:bg-slate-800! py-1! px-2.5! text-xs font-semibold" wire:click="exportSelected">
                    Export CSV
                </x-button>
                <x-button variant="danger" size="sm" class="py-1! px-2.5! text-xs font-semibold" wire:click="applyBulkDelete">
                    Delete
                </x-button>
            </div>
        </div>
    @endif

    <!-- Data Table -->
    <x-card class="overflow-hidden p-0!">
        <x-table :headers="['Select', 'Room Code', 'Room details', 'Boarding House', 'Monthly Rent', 'Status', 'Facilities', 'Actions']">
            @forelse($rooms as $room)
                <tr class="hover:bg-slate-50/50 transition">
                    <!-- Checkbox select -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" wire:model.live="selectedIds" value="{{ $room->id }}"
                            class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 bg-slate-50/50 cursor-pointer">
                    </td>

                    <!-- Code / QR Code Thumb -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs font-mono font-semibold text-slate-500">
                        <div class="flex items-center gap-2">
                            @if($room->qr_code_path)
                                <img class="w-8 h-8 rounded border border-slate-100 bg-white" src="{{ asset('storage/' . $room->qr_code_path) }}" alt="QR">
                            @endif
                            <span>{{ $room->room_code }}</span>
                        </div>
                    </td>

                    <!-- Number & Name / Floor -->
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-slate-900">Room {{ $room->room_number }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $room->room_type }} • Floor {{ $room->floor }} • {{ $room->room_size ?: '-' }}
                        </p>
                    </td>

                    <!-- Boarding house -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-650">
                        {{ $room->boardingHouse->name }}
                    </td>

                    <!-- Monthly Rent -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-800">
                        Rp{{ number_format($room->monthly_rent, 0, ',', '.') }}
                    </td>

                    <!-- Status badge -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $variant = 'neutral';
                            if ($room->status === 'available') $variant = 'success';
                            if ($room->status === 'occupied') $variant = 'info';
                            if ($room->status === 'reserved') $variant = 'warning';
                            if ($room->status === 'maintenance' || $room->status === 'cleaning') $variant = 'danger';
                        @endphp
                        <x-badge :variant="$variant" class="uppercase text-[9px] px-2 py-0.5 font-bold">{{ $room->status }}</x-badge>
                    </td>

                    <!-- Facilities Icons / Badges preview -->
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1 max-w-[150px]">
                            @forelse($room->facilities->take(3) as $facItem)
                                <x-badge variant="neutral" class="text-[9px] py-0 px-1">{{ $facItem->name }}</x-badge>
                            @empty
                                <span class="text-[10px] text-slate-400 italic">None</span>
                            @endforelse
                            @if($room->facilities->count() > 3)
                                <span class="text-[9px] text-slate-400 font-semibold">+{{ $room->facilities->count() - 3 }}</span>
                            @endif
                        </div>
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 transition cursor-pointer" onclick="window.location.href='{{ route('rooms.edit', $room->id) }}'" title="Atur Kamar" aria-label="Atur Kamar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </x-button>
                            <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl text-rose-600 border border-slate-200 hover:border-rose-100 hover:bg-rose-50 cursor-pointer" wire:click="confirmDelete('{{ $room->id }}')" title="Hapus Kamar" aria-label="Hapus Kamar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </x-button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-0">
                        <x-empty-state title="No rooms registered" description="Get started by creating rooms under your active properties to manage contracts and billings."></x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $rooms->links('components.pagination') }}
    </div>

    <!-- Single Delete Modal -->
    <x-modal wire:model="showDeleteModal" title="Delete Room" maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-slate-500">
                Are you sure you want to delete this room? All gallery image assets and facility links will be destroyed. This action is irreversible and occupied rooms containing active tenant bookings cannot be deleted.
            </p>
            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Cancel</x-button>
                <x-button variant="danger" size="sm" type="button" wire:click="deleteRoom">Delete Room</x-button>
            </div>
        </div>
    </x-modal>

    <!-- Bulk status modal -->
    <x-modal wire:model="showBulkStatusModal" title="Shift Selected Rooms Status" maxWidth="md">
        <div class="space-y-4">
            <div>
                <label for="b_status" class="block text-sm font-medium text-slate-700 mb-1.5">New Target Status</label>
                <select wire:model="bulkStatus" id="b_status"
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="reserved">Reserved</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="cleaning">Cleaning</option>
                    <option value="unavailable">Unavailable</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <p class="text-xs text-amber-600">
                <strong>Attention:</strong> Occupied rooms will bypass this update block to prevent tenant billing desynchronizations.
            </p>

            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Cancel</x-button>
                <x-button variant="primary" size="sm" type="button" wire:click="applyBulkStatus">Apply Bulk Change</x-button>
            </div>
        </div>
    </x-modal>

</div>
