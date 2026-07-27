<div class="space-y-6">
    
    <!-- Title & Action -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Complaints & Maintenance</h1>
            <p class="text-sm text-slate-500 mt-1">Audit resident reported issues, assign maintenance task checklists, track costs, and verify completions.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" wire:click="openCreateModal" class="cursor-pointer">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    File Complaint Case
                </span>
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Open Complaints</p>
            <h3 class="text-lg font-bold text-slate-800 mt-1">{{ $openCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">High / Critical Priority</p>
            <h3 class="text-lg font-bold text-rose-600 mt-1">{{ $highPriorityCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Repairs in progress</p>
            <h3 class="text-lg font-bold text-amber-600 mt-1">{{ $inProgressCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Completed resolved</p>
            <h3 class="text-lg font-bold text-emerald-600 mt-1">{{ $completedCount }}</h3>
        </x-card>
    </div>

    <!-- View Mode Switcher & Filters -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-2">
        <!-- View Toggle buttons (linear styled) -->
        <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl w-fit">
            <button wire:click="toggleViewMode('table')" :class="{"bg-white  shadow-sm text-slate-850  @js($viewMode === 'table'), 'text-slate-500 hover:text-slate-700': @js($viewMode !== 'table')}"
                class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition cursor-pointer">Table view</button>
            <button wire:click="toggleViewMode('kanban')" :class="{"bg-white  shadow-sm text-slate-850  @js($viewMode === 'kanban'), 'text-slate-500 hover:text-slate-700': @js($viewMode !== 'kanban')}"
                class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition cursor-pointer">Kanban Board</button>
        </div>

        <!-- Filters Section -->
        <div class="flex flex-wrap items-center gap-3">
            <!-- Search -->
            <div class="relative w-full md:w-56">
                <input wire:model.live.debounce.250ms="search" type="text"
                    class="w-full pl-9 pr-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none text-xs"
                    placeholder="Search complaint #, rooms...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <!-- Property Filter -->
            <select wire:model.live="filterBoardingHouse"
                class="px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 text-xs">
                <option value="">All Boarding Houses</option>
                @foreach($boardingHouses as $house)
                    <option value="{{ $house->id }}">{{ $house->name }}</option>
                @endforeach
            </select>

            <!-- Category -->
            <select wire:model.live="filterCategory"
                class="px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 text-xs">
                <option value="">All Categories</option>
                <option value="electricity">Electricity</option>
                <option value="water">Water</option>
                <option value="bathroom">Bathroom</option>
                <option value="ac">Air Conditioner</option>
                <option value="internet">Internet</option>
                <option value="furniture">Furniture</option>
                <option value="door">Door / Lock</option>
                <option value="roof">Roof leakage</option>
                <option value="kitchen">Kitchen</option>
                <option value="security">Security</option>
                <option value="cleaning">Cleaning</option>
                <option value="other">Other</option>
            </select>

            <!-- Priority -->
            <select wire:model.live="filterPriority"
                class="px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 text-xs">
                <option value="">All Priorities</option>
                <option value="low">Low</option>
                <option value="normal">Normal</option>
                <option value="high">High</option>
                <option value="critical">Critical</option>
                <option value="emergency">Emergency</option>
            </select>
        </div>
    </div>

    <!-- MAIN VIEWS PANEL -->
    @if($viewMode === 'table')
        <!-- TABLE VIEW -->
        <x-card class="overflow-hidden p-0!">
            <x-table :headers="['Complaint No', 'Resident', 'Room/Property', 'Subject', 'Category', 'Priority', 'Assigned Task', 'Status', 'Actions']">
                @forelse($complaints as $cmp)
                    <tr class="hover:bg-slate-50/50 transition">
                        <!-- Number -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-slate-800">
                            {{ $cmp->complaint_number }}
                        </td>

                        <!-- Resident -->
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-slate-900">{{ $cmp->resident->name }}</p>
                        </td>

                        <!-- Room details -->
                        <td class="px-6 py-4 text-xs text-slate-650">
                            <p class="font-semibold">{{ $cmp->boardingHouse->name }}</p>
                            <p class="font-mono text-indigo-650 mt-0.5">Room {{ $cmp->room ? $cmp->room->room_number : '-' }}</p>
                        </td>

                        <!-- Subject -->
                        <td class="px-6 py-4 text-xs text-slate-700 max-w-xs truncate">
                            <p class="font-bold text-slate-900">{{ $cmp->subject }}</p>
                            <p class="text-slate-450 mt-0.5">{{ strLimit($cmp->description, 50) }}</p>
                        </td>

                        <!-- Category -->
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 font-medium capitalize">
                            {{ $cmp->category }}
                        </td>

                        <!-- Priority -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $pColor = 'text-slate-500';
                                if ($cmp->priority->value === 'high') $pColor = 'text-amber-600 font-semibold';
                                if ($cmp->priority->value === 'critical' || $cmp->priority->value === 'emergency') $pColor = 'text-rose-600 font-bold';
                            @endphp
                            <span class="text-xs {{ $pColor }}">{{ $cmp->priority->label() }}</span>
                        </td>

                        <!-- Assigned Maintenance Task -->
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-650 font-mono">
                            @if($cmp->maintenanceTask)
                                <p class="font-semibold text-slate-950">{{ $cmp->maintenanceTask->task_number }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $cmp->maintenanceTask->assignedStaff ? $cmp->maintenanceTask->assignedStaff->name : 'Unassigned' }}</p>
                            @else
                                <span class="text-slate-400 italic">No Task</span>
                            @endif
                        </td>

                        <!-- Status badge -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $variant = 'neutral';
                                if (in_array($cmp->status->value, ['completed', 'verified', 'closed'])) $variant = 'success';
                                if ($cmp->status->value === 'open') $variant = 'neutral';
                                if (in_array($cmp->status->value, ['reviewed', 'assigned'])) $variant = 'info';
                                if (in_array($cmp->status->value, ['in_progress', 'waiting_parts'])) $variant = 'warning';
                                if ($cmp->status->value === 'cancelled') $variant = 'danger';
                            @endphp
                            <x-badge :variant="$variant" class="uppercase text-[8px] font-bold px-2 py-0.5">
                                {{ $cmp->status->label() }}
                            </x-badge>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-indigo-600 transition cursor-pointer" onclick="window.location.href='{{ route('complaints.show', $cmp->id) }}'" title="Kelola Kasus" aria-label="Kelola Kasus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                            </x-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-0">
                            <x-empty-state title="No complaint cases registered" description="Record property maintenance checklists, log plumbing, or allocate tasks to technicians."></x-empty-state>
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </x-card>

        <div class="mt-4">
            {{ $complaints->links('components.pagination') }}
        </div>

    @else
        <!-- KANBAN BOARD VIEW -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-start">
            
            <!-- Column 1: Open / Reviewed -->
            <div class="bg-slate-50/50 border border-slate-100 p-3 rounded-2xl space-y-3 min-h-[450px]">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <span class="text-xs font-bold text-slate-700">Open & Reviewed</span>
                    <span class="text-[10px] bg-slate-200/50 text-slate-500 px-2 py-0.5 rounded-lg font-bold">{{ count($kanbanComplaints['open']) }}</span>
                </div>
                
                <div class="space-y-3">
                    @forelse($kanbanComplaints['open'] as $c)
                        <div class="bg-white p-4 border border-slate-150/40 rounded-xl shadow-xs space-y-2.5 hover:border-indigo-400 transition cursor-pointer" onclick="window.location.href='{{ route('complaints.show', $c->id) }}'">
                            <div class="flex justify-between items-start">
                                <span class="font-mono text-[10px] font-bold text-slate-400">{{ $c->complaint_number }}</span>
                                <x-badge variant="neutral" class="text-[7px] font-bold px-1.5 py-0.5 uppercase">{{ $c->priority->label() }}</x-badge>
                            </div>
                            <h4 class="text-xs font-bold text-slate-850">{{ $c->subject }}</h4>
                            <p class="text-[10px] text-slate-450 leading-normal">{{ strLimit($c->description, 60) }}</p>
                            <div class="border-t border-slate-50 pt-2 flex justify-between items-center text-[9px] text-slate-400">
                                <span>{{ $c->boardingHouse->name }}</span>
                                <span class="font-bold text-slate-700">Room {{ $c->room ? $c->room->room_number : '-' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-[10px] italic text-slate-400 py-6">Empty</p>
                    @endforelse
                </div>
            </div>

            <!-- Column 2: Assigned / Waiting Parts -->
            <div class="bg-slate-50/50 border border-slate-100 p-3 rounded-2xl space-y-3 min-h-[450px]">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <span class="text-xs font-bold text-slate-700">Assigned / Pending Parts</span>
                    <span class="text-[10px] bg-slate-200/50 text-slate-500 px-2 py-0.5 rounded-lg font-bold">{{ count($kanbanComplaints['assigned']) }}</span>
                </div>

                <div class="space-y-3">
                    @forelse($kanbanComplaints['assigned'] as $c)
                        <div class="bg-white p-4 border border-slate-150/40 rounded-xl shadow-xs space-y-2.5 hover:border-indigo-400 transition cursor-pointer" onclick="window.location.href='{{ route('complaints.show', $c->id) }}'">
                            <div class="flex justify-between items-start">
                                <span class="font-mono text-[10px] font-bold text-slate-400">{{ $c->complaint_number }}</span>
                                <x-badge variant="info" class="text-[7px] font-bold px-1.5 py-0.5 uppercase">{{ $c->priority->label() }}</x-badge>
                            </div>
                            <h4 class="text-xs font-bold text-slate-850">{{ $c->subject }}</h4>
                            <p class="text-[10px] text-slate-455 leading-normal">{{ strLimit($c->description, 60) }}</p>
                            
                            @if($c->maintenanceTask)
                                <div class="bg-slate-50 p-2 rounded-lg border border-slate-100 text-[9px]">
                                    <p class="font-bold text-slate-700">MNT: {{ $c->maintenanceTask->task_number }}</p>
                                    <p class="mt-0.5 text-slate-500">Staff: {{ $c->maintenanceTask->assignedStaff ? $c->maintenanceTask->assignedStaff->name : 'Unassigned' }}</p>
                                </div>
                            @endif

                            <div class="border-t border-slate-50 pt-2 flex justify-between items-center text-[9px] text-slate-400">
                                <span>{{ $c->boardingHouse->name }}</span>
                                <span class="font-bold text-slate-700">Room {{ $c->room ? $c->room->room_number : '-' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-[10px] italic text-slate-400 py-6">Empty</p>
                    @endforelse
                </div>
            </div>

            <!-- Column 3: In Progress -->
            <div class="bg-slate-50/50 border border-slate-100 p-3 rounded-2xl space-y-3 min-h-[450px]">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <span class="text-xs font-bold text-slate-700">In Progress</span>
                    <span class="text-[10px] bg-slate-200/50 text-slate-500 px-2 py-0.5 rounded-lg font-bold">{{ count($kanbanComplaints['in_progress']) }}</span>
                </div>

                <div class="space-y-3">
                    @forelse($kanbanComplaints['in_progress'] as $c)
                        <div class="bg-white p-4 border border-slate-150/40 rounded-xl shadow-xs space-y-2.5 hover:border-indigo-400 transition cursor-pointer" onclick="window.location.href='{{ route('complaints.show', $c->id) }}'">
                            <div class="flex justify-between items-start">
                                <span class="font-mono text-[10px] font-bold text-slate-400">{{ $c->complaint_number }}</span>
                                <x-badge variant="warning" class="text-[7px] font-bold px-1.5 py-0.5 uppercase">{{ $c->priority->label() }}</x-badge>
                            </div>
                            <h4 class="text-xs font-bold text-slate-850">{{ $c->subject }}</h4>
                            
                            @if($c->maintenanceTask)
                                <div class="bg-slate-50 p-2 rounded-lg border border-slate-100 text-[9px]">
                                    <p class="font-bold text-slate-700">MNT: {{ $c->maintenanceTask->task_number }}</p>
                                    <p class="mt-0.5 text-slate-500">Staff: {{ $c->maintenanceTask->assignedStaff ? $c->maintenanceTask->assignedStaff->name : 'Unassigned' }}</p>
                                </div>
                            @endif

                            <div class="border-t border-slate-50 pt-2 flex justify-between items-center text-[9px] text-slate-400">
                                <span>{{ $c->boardingHouse->name }}</span>
                                <span class="font-bold text-slate-700">Room {{ $c->room ? $c->room->room_number : '-' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-[10px] italic text-slate-400 py-6">Empty</p>
                    @endforelse
                </div>
            </div>

            <!-- Column 4: Completed / Resolved / Closed -->
            <div class="bg-slate-50/50 border border-slate-100 p-3 rounded-2xl space-y-3 min-h-[450px]">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <span class="text-xs font-bold text-slate-700">Resolved / Closed</span>
                    <span class="text-[10px] bg-slate-200/50 text-slate-500 px-2 py-0.5 rounded-lg font-bold">{{ count($kanbanComplaints['completed']) }}</span>
                </div>

                <div class="space-y-3">
                    @forelse($kanbanComplaints['completed'] as $c)
                        <div class="bg-white p-4 border border-slate-150/40 rounded-xl shadow-xs space-y-2.5 hover:border-indigo-400 transition cursor-pointer" onclick="window.location.href='{{ route('complaints.show', $c->id) }}'">
                            <div class="flex justify-between items-start">
                                <span class="font-mono text-[10px] font-bold text-slate-400">{{ $c->complaint_number }}</span>
                                <x-badge variant="success" class="text-[7px] font-bold px-1.5 py-0.5 uppercase">{{ $c->priority->label() }}</x-badge>
                            </div>
                            <h4 class="text-xs font-bold text-slate-850">{{ $c->subject }}</h4>
                            
                            <div class="border-t border-slate-50 pt-2 flex justify-between items-center text-[9px] text-slate-400">
                                <span>{{ $c->boardingHouse->name }}</span>
                                <span class="font-bold text-slate-700">Room {{ $c->room ? $c->room->room_number : '-' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-[10px] italic text-slate-400 py-6">Empty</p>
                    @endforelse
                </div>
            </div>

        </div>
    @endif

    <!-- CREATE COMPLAINT MODAL -->
    <x-modal wire:model="showCreateModal" title="File Complaint Case" maxWidth="lg">
        <form wire:submit.prevent="storeComplaint" class="space-y-4">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Resident/Tenant Selection -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Resident Reporter</label>
                    <select wire:model.live="resident_id" required
                        class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900">
                        <option value="">Select Resident...</option>
                        @foreach($residents as $res)
                            <option value="{{ $res->id }}">{{ $res->name }} (Room: {{ $res->room ? $res->room->room_number : '-' }})</option>
                        @endforeach
                    </select>
                    @error('resident_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Category</label>
                    <select wire:model="category" required
                        class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900">
                        <option value="electricity">Electricity</option>
                        <option value="water">Water</option>
                        <option value="bathroom">Bathroom</option>
                        <option value="ac">Air Conditioner</option>
                        <option value="internet">Internet</option>
                        <option value="furniture">Furniture</option>
                        <option value="door">Door / Lock</option>
                        <option value="roof">Roof leakage</option>
                        <option value="kitchen">Kitchen</option>
                        <option value="security">Security</option>
                        <option value="cleaning">Cleaning</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Boarding house -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Boarding House</label>
                    <select wire:model="boarding_house_id" disabled
                        class="w-full px-3 py-2 bg-slate-100 border border-slate-200 rounded-xl text-xs text-slate-500 cursor-not-allowed">
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Room -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Room</label>
                    <select wire:model="room_id" disabled
                        class="w-full px-3 py-2 bg-slate-100 border border-slate-200 rounded-xl text-xs text-slate-500 cursor-not-allowed">
                        <option value="">Choose Room...</option>
                        @foreach($availableRooms as $room)
                            <option value="{{ $room->id }}">Room {{ $room->room_number }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Priority -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Priority</label>
                <div class="grid grid-cols-5 gap-2 text-center">
                    @foreach(['low' => 'Low', 'normal' => 'Normal', 'high' => 'High', 'critical' => 'Critical', 'emergency' => 'Emergency'] as $val => $lbl)
                        <label class="flex flex-col items-center justify-center p-2 border rounded-xl cursor-pointer text-[10px] font-bold {{ $priority === $val ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'bg-slate-50/50 border-slate-150' }}">
                            <input type="radio" wire:model="priority" value="{{ $val }}" class="sr-only">
                            {{ $lbl }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Subject -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Subject Subject</label>
                <input wire:model="subject" type="text" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="e.g. Toilet flush not working">
                @error('subject') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Detailed Description</label>
                <textarea wire:model="description" rows="3" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="Provide detailed notes regarding the issue..."></textarea>
                @error('description') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Internal private notes -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Internal Private Notes (Office Staff only)</label>
                <input wire:model="internal_notes" type="text" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="Private internal annotations">
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Cancel</x-button>
                <x-button variant="primary" size="sm" type="submit" loading="storeComplaint">Register Case</x-button>
            </div>
        </form>
    </x-modal>

</div>
