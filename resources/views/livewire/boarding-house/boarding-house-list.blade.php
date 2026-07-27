<div class="space-y-6">
    
    <!-- Title & Action -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Boarding Houses</h1>
            <p class="text-sm text-slate-500 mt-1">Manage profiles, galleries, facilities, and rules for all boarding houses under your workspace.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" onclick="window.location.href='{{ route('boarding-houses.create') }}'">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Boarding House
                </span>
            </x-button>
        </div>
    </div>

    <!-- Quick Stats row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        <x-card class="py-4! px-5!">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total properties</p>
            <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $totalCount }}</h3>
        </x-card>
        <x-card class="py-4! px-5!">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Active</p>
            <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $activeCount }}</h3>
        </x-card>
        <x-card class="py-4! px-5!">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Fully Occupied</p>
            <h3 class="text-2xl font-bold text-indigo-650 mt-1">{{ $fullCount }}</h3>
        </x-card>
        <x-card class="py-4! px-5!">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Inactive</p>
            <h3 class="text-2xl font-bold text-rose-600 mt-1">{{ $inactiveCount }}</h3>
        </x-card>
    </div>

    <!-- Filters Section -->
    <x-card class="py-4 px-6">
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <!-- Search -->
            <div class="flex-1 w-full relative">
                <input wire:model.live.debounce.250ms="search" type="text"
                    class="w-full pl-10 pr-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                    placeholder="Search by name, address, or city...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="w-full sm:w-44">
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="full">Fully Booked</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <!-- City Filter -->
            <div class="w-full sm:w-44">
                <select wire:model.live="filterCity"
                    class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                    <option value="">All Cities</option>
                    @foreach($cities as $cityItem)
                        <option value="{{ $cityItem }}">{{ $cityItem }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </x-card>

    <!-- Grid List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($boardingHouses as $house)
            <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 flex flex-col group">
                <!-- Cover Image & Badges -->
                <div class="h-44 relative bg-slate-100 overflow-hidden">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition duration-500" 
                         src="{{ $house->cover_image ? asset('storage/' . $house->cover_image) : asset('assets/images/property/default_cover.png') }}" 
                         alt="{{ $house->name }}">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent pointer-events-none"></div>

                    <!-- Logo Overlay -->
                    @if($house->logo)
                        <div class="absolute bottom-3 left-3 w-10 h-10 rounded-xl bg-white/95 backdrop-blur shadow p-1 flex items-center justify-center">
                            <img class="max-w-full max-h-full object-contain rounded-lg" src="{{ asset('storage/' . $house->logo) }}" alt="Logo">
                        </div>
                    @endif

                    <!-- Badges Top Right -->
                    <div class="absolute top-3 right-3 flex flex-col gap-1.5 items-end">
                        @php
                            $statusVariant = 'neutral';
                            if ($house->status === 'active') $statusVariant = 'success';
                            if ($house->status === 'full') $statusVariant = 'info';
                            if ($house->status === 'inactive') $statusVariant = 'danger';
                        @endphp
                        <x-badge :variant="$statusVariant" class="shadow-sm uppercase text-[9px] px-2 py-0.5">{{ $house->status }}</x-badge>
                        
                        <x-badge :variant="$house->is_public ? 'info' : 'neutral'" class="shadow-sm uppercase text-[9px] px-2 py-0.5">
                            {{ $house->is_public ? 'Public' : 'Private' }}
                        </x-badge>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 line-clamp-1 group-hover:text-indigo-600 transition">{{ $house->name }}</h3>
                        <p class="text-xs text-slate-400 flex items-center gap-1 mt-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $house->city }}, {{ $house->province }}
                        </p>

                        <!-- Address details -->
                        <p class="text-xs text-slate-500 mt-3 line-clamp-2">{{ $house->address }}</p>

                        <!-- Features overview -->
                        <div class="flex items-center gap-4 mt-4 py-2 border-y border-slate-50 text-slate-500 text-xs">
                            <span class="flex items-center gap-1">
                                <strong>{{ $house->facilities()->count() }}</strong> Facilities
                            </span>
                            <span class="flex items-center gap-1">
                                <strong>{{ $house->rules()->count() }}</strong> Rules
                            </span>
                            <span class="flex items-center gap-1">
                                <strong>{{ $house->galleries()->count() }}</strong> Images
                            </span>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex items-center justify-between gap-2 mt-5">
                        <x-button variant="outline" size="sm" class="w-full py-1.5! text-xs font-semibold" onclick="window.location.href='{{ route('boarding-houses.edit', $house->id) }}'">
                            Configure
                        </x-button>
                        
                        @can('delete', $house)
                            <x-button variant="outline" size="sm" class="px-2.5! py-1.5! text-xs text-rose-600 hover:text-rose-700 hover:bg-rose-50 border-slate-200 hover:border-rose-200 cursor-pointer" wire:click="confirmDelete('{{ $house->id }}')" title="Delete property">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </x-button>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <x-empty-state title="No Boarding Houses Found" description="Start by creating a new boarding house to manage settings, rooms, rules, and facilities.">
                    <x-button variant="primary" size="sm" onclick="window.location.href='{{ route('boarding-houses.create') }}'">
                        Create Boarding House
                    </x-button>
                </x-empty-state>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $boardingHouses->links('components.pagination') }}
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal wire:model="showDeleteModal" title="Delete Boarding House" maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-slate-500">
                Are you sure you want to delete this boarding house? All settings, room assignments, active rules, and gallery assets will be deleted. This action is irreversible.
            </p>
            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Cancel</x-button>
                <x-button variant="danger" size="sm" type="button" wire:click="deleteBoardingHouse">Confirm Delete</x-button>
            </div>
        </div>
    </x-modal>

</div>
