<div class="space-y-6">
    
    <!-- Title & Action -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Residents & Tenants</h1>
            <p class="text-sm text-slate-500 mt-1">Manage boarding house residents profile files, check-in timelines, emergency contacts, and checks status.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" onclick="window.location.href='{{ route('residents.create') }}'">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Resident
                </span>
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total records</p>
            <h3 class="text-lg font-bold text-slate-900 mt-1">{{ $totalCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Active residents</p>
            <h3 class="text-lg font-bold text-emerald-600 mt-1">{{ $activeCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Reserved (DP)</p>
            <h3 class="text-lg font-bold text-indigo-600 mt-1">{{ $reservedCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Late payments</p>
            <h3 class="text-lg font-bold text-amber-600 mt-1">{{ $latePaymentCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Occupancy Rate</p>
            <h3 class="text-lg font-bold text-slate-900 mt-1">{{ $occupancyRate }}%</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Avg Stay Duration</p>
            <h3 class="text-lg font-bold text-slate-900 mt-1">{{ $avgStay ?: '-' }} <span class="text-xs font-normal text-slate-400">days</span></h3>
        </x-card>
    </div>

    <!-- Filters Section -->
    <x-card class="py-4 px-6">
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <!-- Search -->
            <div class="flex-1 w-full relative">
                <input wire:model.live.debounce.250ms="search" type="text"
                    class="w-full pl-10 pr-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                    placeholder="Search by name, NIK, phone, or assigned room...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <!-- Property Filter -->
            <div class="w-full sm:w-56">
                <select wire:model.live="filterBoardingHouse"
                    class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                    <option value="">All Boarding Houses</option>
                    @foreach($boardingHouses as $house)
                        <option value="{{ $house->id }}">{{ $house->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="w-full sm:w-44">
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending Review</option>
                    <option value="reserved">Reserved</option>
                    <option value="active">Active</option>
                    <option value="late_payment">Late Payment</option>
                    <option value="moving_out">Moving Out</option>
                    <option value="former">Former Tenant</option>
                    <option value="blacklisted">Blacklisted</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </x-card>

    <!-- Data Table -->
    <x-card class="overflow-hidden p-0!">
        <x-table :headers="['Photo', 'Resident Identity', 'Property', 'Room', 'Contact No', 'Status', 'Actions']">
            @forelse($residents as $res)
                <tr class="hover:bg-slate-50/50 transition">
                    <!-- Photo -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img class="h-10 w-10 rounded-full object-cover bg-slate-100 border border-slate-200" 
                             src="{{ $res->photo ? asset('storage/' . $res->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($res->name) . '&background=f3f4f6&color=1f2937' }}" 
                             alt="{{ $res->name }}">
                    </td>

                    <!-- Identity -->
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-slate-900">{{ $res->name }}</p>
                        <p class="text-xs text-slate-400 font-mono mt-0.5">NIK: {{ $res->nik }}</p>
                    </td>

                    <!-- Boarding House -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-650">
                        {{ $res->boardingHouse ? $res->boardingHouse->name : '-' }}
                    </td>

                    <!-- Room -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono">
                        @if($res->room)
                            <x-badge variant="info" class="text-[10px]">Room {{ $res->room->room_number }}</x-badge>
                        @else
                            <span class="text-slate-400 italic text-xs">Unassigned</span>
                        @endif
                    </td>

                    <!-- Contact -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-650">
                        {{ $res->phone }}
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $variant = 'neutral';
                            if ($res->status->value === 'active') $variant = 'success';
                            if ($res->status->value === 'reserved') $variant = 'info';
                            if ($res->status->value === 'late_payment') $variant = 'warning';
                            if ($res->status->value === 'former' || $res->status->value === 'blacklisted') $variant = 'danger';
                        @endphp
                        <x-badge :variant="$variant" class="uppercase text-[8px] font-bold px-2 py-0.5">
                            {{ $res->status->label() }}
                        </x-badge>
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <x-button variant="outline" size="sm" class="px-2! py-1! text-xs font-semibold" onclick="window.location.href='{{ route('residents.show', $res->id) }}'">
                                Manage Check
                            </x-button>
                            <x-button variant="outline" size="sm" class="px-2! py-1! text-xs" onclick="window.location.href='{{ route('residents.edit', $res->id) }}'">
                                Edit
                            </x-button>
                            @can('delete', $res)
                                <x-button variant="outline" size="sm" class="px-2! py-1! text-xs text-rose-600 border-slate-200 hover:border-rose-100 hover:bg-rose-50 cursor-pointer" wire:click="confirmDelete('{{ $res->id }}')">
                                    Delete
                                </x-button>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-0">
                        <x-empty-state title="No residents registered" description="Add resident profiles, run check-in processes, and link document vaults."></x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $residents->links('components.pagination') }}
    </div>

    <!-- Single Delete Modal -->
    <x-modal wire:model="showDeleteModal" title="Delete Resident Record" maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-slate-500">
                Are you sure you want to delete this resident record? All linked document attachments and history event logs will be permanently deleted. Active residents cannot be deleted.
            </p>
            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Cancel</x-button>
                <x-button variant="danger" size="sm" type="button" wire:click="deleteResident">Delete Record</x-button>
            </div>
        </div>
    </x-modal>

</div>
