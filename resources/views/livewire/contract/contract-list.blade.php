<div class="space-y-6">
    
    <!-- Title & Action -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Lease Contracts</h1>
            <p class="text-sm text-slate-500 mt-1">Manage rental agreement bounds, billing amounts, extensions, and version histories.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" onclick="window.location.href='{{ route('contracts.create') }}'">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Draft Agreement
                </span>
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total contracts</p>
            <h3 class="text-lg font-bold text-slate-900 mt-1">{{ $totalCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Drafts</p>
            <h3 class="text-lg font-bold text-slate-500 mt-1">{{ $draftCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Active leases</p>
            <h3 class="text-lg font-bold text-emerald-600 mt-1">{{ $activeCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Expiring soon</p>
            <h3 class="text-lg font-bold text-amber-600 mt-1">{{ $expiringCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4! col-span-1 md:col-span-2 lg:col-span-1">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Monthly Revenue</p>
            <h3 class="text-md font-bold text-indigo-650 mt-1">Rp{{ number_format($revenue, 0, ',', '.') }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Avg Lease Duration</p>
            <h3 class="text-lg font-bold text-slate-900 mt-1">{{ $avgDuration ?: '-' }} <span class="text-xs font-normal text-slate-400">mo</span></h3>
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
                        placeholder="Search by contract #, resident, boarding house, or room...">
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
                        <option value="pending_approval">Pending Approval</option>
                        <option value="active">Active</option>
                        <option value="expiring_soon">Expiring Soon</option>
                        <option value="renewed">Renewed (Archived)</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="terminated">Terminated</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
            </div>

            <!-- Date Bounds filters -->
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
        <x-table :headers="['Contract No', 'Resident', 'Accommodation', 'Type', 'Period Start/End', 'Monthly Rent', 'Status', 'Actions']">
            @forelse($contracts as $ctr)
                <tr class="hover:bg-slate-50/50 transition">
                    <!-- Number -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-slate-800">
                        {{ $ctr->contract_number }}
                    </td>

                    <!-- Resident -->
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-slate-900">{{ $ctr->resident->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">NIK: {{ $ctr->resident->nik }}</p>
                    </td>

                    <!-- Property -->
                    <td class="px-6 py-4 text-xs text-slate-650">
                        <p class="font-semibold">{{ $ctr->boardingHouse->name }}</p>
                        <p class="font-mono text-indigo-650 mt-0.5">Room {{ $ctr->room ? $ctr->room->room_number : '-' }}</p>
                    </td>

                    <!-- Type -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 font-medium">
                        {{ $ctr->contract_type->label() }}
                    </td>

                    <!-- Dates -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-650">
                        {{ $ctr->start_date->format('d M Y') }} - {{ $ctr->end_date->format('d M Y') }}
                    </td>

                    <!-- Monthly Rent -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">
                        Rp{{ number_format($ctr->monthly_rent, 0, ',', '.') }}
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $variant = 'neutral';
                            if ($ctr->status->value === 'active') $variant = 'success';
                            if ($ctr->status->value === 'draft') $variant = 'neutral';
                            if ($ctr->status->value === 'pending_approval') $variant = 'info';
                            if ($ctr->status->value === 'expiring_soon') $variant = 'warning';
                            if ($ctr->status->value === 'expired' || $ctr->status->value === 'terminated' || $ctr->status->value === 'cancelled') $variant = 'danger';
                        @endphp
                        <x-badge :variant="$variant" class="uppercase text-[8px] font-bold px-2 py-0.5">
                            {{ $ctr->status->label() }}
                        </x-badge>
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-indigo-600 transition cursor-pointer" onclick="window.location.href='{{ route('contracts.show', $ctr->id) }}'" title="Kelola Kontrak" aria-label="Kelola Kontrak">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </x-button>
                            @if($ctr->status->value === 'draft')
                                <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 transition cursor-pointer" onclick="window.location.href='{{ route('contracts.edit', $ctr->id) }}'" title="Ubah Kontrak" aria-label="Ubah Kontrak">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </x-button>
                            @endif
                            @can('delete', $ctr)
                                <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl text-rose-600 border border-slate-200 hover:border-rose-100 hover:bg-rose-50 cursor-pointer" wire:click="confirmDelete('{{ $ctr->id }}')" title="Hapus Kontrak" aria-label="Hapus Kontrak">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </x-button>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-0">
                        <x-empty-state title="No contracts drafted yet" description="Initiate a lease agreement stepper wizard for boarding house rooms, calculate rents, and print legal PDFs."></x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $contracts->links('components.pagination') }}
    </div>

    <!-- Single Delete Modal -->
    <x-modal wire:model="showDeleteModal" title="Delete Contract Draft" maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-slate-500">
                Are you sure you want to delete this lease contract draft? This operation will permanently remove all fee estimates and timelines history. Activated contracts cannot be deleted.
            </p>
            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Cancel</x-button>
                <x-button variant="danger" size="sm" type="button" wire:click="deleteContract">Delete Draft</x-button>
            </div>
        </div>
    </x-modal>

</div>
