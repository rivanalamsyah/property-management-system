<div class="space-y-6">
    
    <!-- Title & Action -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Announcement & Broadcasts</h1>
            <p class="text-sm text-slate-500 mt-1">Broadcast notifications to tenants, schedule reminders, track read receipts engagement, and post updates.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" wire:click="openCreateModal" class="cursor-pointer">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    New Announcement
                </span>
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Published Alerts</p>
            <h3 class="text-lg font-bold text-slate-800 mt-1">{{ $publishedCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Scheduled Queue</p>
            <h3 class="text-lg font-bold text-indigo-650 mt-1">{{ $scheduledCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Drafts</p>
            <h3 class="text-lg font-bold text-slate-600 mt-1">{{ $draftCount }}</h3>
        </x-card>
        <x-card class="py-3! px-4!">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Tenant Read Rate</p>
            <h3 class="text-lg font-bold text-emerald-600 mt-1">{{ $readRate }}%</h3>
        </x-card>
    </div>

    <!-- Filters Section -->
    <x-card class="py-4 px-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            
            <!-- Left inputs -->
            <div class="flex flex-wrap items-center gap-3">
                <!-- Search -->
                <div class="relative w-56">
                    <input wire:model.live.debounce.250ms="search" type="text"
                        class="w-full pl-9 pr-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none text-xs"
                        placeholder="Search title or content...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <!-- Category -->
                <select wire:model.live="filterCategory"
                    class="px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 text-xs">
                    <option value="">All Categories</option>
                    <option value="general">General</option>
                    <option value="maintenance">Maintenance Notice</option>
                    <option value="water_shutdown">Water Shutdown</option>
                    <option value="cleaning">Cleaning Schedule</option>
                    <option value="rent_reminder">Rent Reminder</option>
                    <option value="emergency">Emergency Notice</option>
                    <option value="holiday">Holiday Notice</option>
                    <option value="promotional">Promotional Notice</option>
                    <option value="other">Other</option>
                </select>

                <!-- Priority -->
                <select wire:model.live="filterPriority"
                    class="px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 text-xs">
                    <option value="">All Priorities</option>
                    <option value="low">Low</option>
                    <option value="normal">Normal</option>
                    <option value="important">Important</option>
                    <option value="high">High</option>
                    <option value="emergency">Emergency</option>
                </select>

                <!-- Status -->
                <select wire:model.live="filterStatus"
                    class="px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 text-xs">
                    <option value="">All Statuses</option>
                    <option value="draft">Draft</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="published">Published</option>
                    <option value="expired">Expired</option>
                    <option value="archived">Archived</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="text-[10px] text-slate-400 italic">
                WhatsApp, email, and mobile push broadcasts pre-integrated.
            </div>

        </div>
    </x-card>

    <!-- Announcement list table -->
    <x-card class="overflow-hidden p-0!">
        <x-table :headers="['Announcement ID', 'Title', 'Target Type', 'Author', 'Schedule Date', 'Priority', 'Pin', 'Status', 'Actions']">
            @forelse($announcements as $ann)
                <tr class="hover:bg-slate-50/50 transition">
                    <!-- ID -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-slate-800">
                        {{ $ann->announcement_number }}
                    </td>

                    <!-- Title -->
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-slate-900">{{ $ann->title }}</p>
                        @if($ann->summary)
                            <p class="text-xs text-slate-450 mt-0.5">{{ $ann->summary }}</p>
                        @endif
                    </td>

                    <!-- Target type -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-650 font-semibold capitalize">
                        {{ str_replace('_', ' ', $ann->target_type) }}
                    </td>

                    <!-- Author -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-800 font-bold">
                        {{ $ann->author ? $ann->author->name : 'System' }}
                    </td>

                    <!-- Date -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-450">
                        {{ $ann->publish_at->format('d M Y, H:i') }}
                    </td>

                    <!-- Priority -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $pColor = 'text-slate-500';
                            if ($ann->priority->value === 'important') $pColor = 'text-indigo-650 font-semibold';
                            if ($ann->priority->value === 'high' || $ann->priority->value === 'emergency') $pColor = 'text-rose-600 font-bold';
                        @endphp
                        <span class="text-xs {{ $pColor }}">{{ $ann->priority->label() }}</span>
                    </td>

                    <!-- Pinned -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($ann->pinned_at)
                            <span class="text-amber-500 text-xs font-bold font-mono">Pinned</span>
                        @else
                            <span class="text-slate-350">-</span>
                        @endif
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $variant = 'neutral';
                            if ($ann->status->value === 'published') $variant = 'success';
                            if ($ann->status->value === 'scheduled') $variant = 'info';
                            if ($ann->status->value === 'draft') $variant = 'neutral';
                            if ($ann->status->value === 'expired' || $ann->status->value === 'cancelled') $variant = 'danger';
                            if ($ann->status->value === 'archived') $variant = 'neutral';
                        @endphp
                        <x-badge :variant="$variant" class="uppercase text-[8px] font-bold px-2 py-0.5">
                            {{ $ann->status->label() }}
                        </x-badge>
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-indigo-600 transition cursor-pointer" onclick="window.location.href='{{ route('announcements.show', $ann->id) }}'" title="Pelacak Pembaca" aria-label="Pelacak Pembaca">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </x-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="p-0">
                        <x-empty-state title="No announcements broadcasted" description="Publish notices, schedule maintenance alerts, or warn tenants regarding utility shutoffs."></x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>

    <div class="mt-4">
        {{ $announcements->links('components.pagination') }}
    </div>

    <!-- CREATE ANNOUNCEMENT MODAL DIALOG -->
    <x-modal wire:model="showCreateModal" title="Compose Announcement Broadcast" maxWidth="lg">
        <form wire:submit.prevent="storeAnnouncement" class="space-y-4 text-xs">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Announcement Title</label>
                    <input wire:model="title" type="text" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="e.g. Emergency water pipe replacement repair">
                    @error('title') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Category -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Category</label>
                    <select wire:model="category" required
                        class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900">
                        <option value="general">General</option>
                        <option value="maintenance">Maintenance Notice</option>
                        <option value="water_shutdown">Water Shutdown</option>
                        <option value="cleaning">Cleaning Schedule</option>
                        <option value="rent_reminder">Rent Reminder</option>
                        <option value="emergency">Emergency Notice</option>
                        <option value="holiday">Holiday Notice</option>
                        <option value="promotional">Promotional Notice</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Priority -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Priority</label>
                    <select wire:model="priority" required
                        class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900">
                        <option value="low">Low</option>
                        <option value="normal">Normal</option>
                        <option value="important">Important</option>
                        <option value="high">High</option>
                        <option value="emergency">Emergency Alert!</option>
                    </select>
                </div>
            </div>

            <!-- Summary -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Summary (Short mobile push text preview)</label>
                <input wire:model="summary" type="text" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="e.g. Water will be shut off on Friday 10 AM to 1 PM for repairs.">
                @error('summary') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Content -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Message Content (Full detail announcement)</label>
                <textarea wire:model="content" rows="4" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900" placeholder="Type announcement markdown message here..."></textarea>
                @error('content') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Target Audience Selector (Alpine.js driven) -->
            <div x-data="{ targetType: @entangle('targetType') }" class="border-t border-slate-100 pt-3 space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-550 mb-1.5">Target Audience</label>
                    <select x-model="targetType" required
                        class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900">
                        <option value="all">All Active Tenants (All Properties)</option>
                        <option value="boarding_house">Selected Boarding House</option>
                        <option value="floor">Selected Floors</option>
                        <option value="room">Selected Rooms</option>
                        <option value="selected_tenants">Specific Tenants List</option>
                    </select>
                </div>

                <!-- Boarding House Targeting -->
                <div x-show="targetType === 'boarding_house' || targetType === 'floor' || targetType === 'room'" class="space-y-3 pt-2">
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Boarding House Property</label>
                    <select wire:model.live="boarding_house_id"
                        class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Floors Targeting -->
                <div x-show="targetType === 'floor'" class="space-y-2 pt-2">
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Target Floors</label>
                    <div class="grid grid-cols-5 gap-2">
                        @foreach([1, 2, 3, 4, 5] as $fl)
                            <label class="flex items-center gap-1.5 p-2 border rounded-xl cursor-pointer">
                                <input type="checkbox" wire:model="selectedFloors" value="{{ $fl }}" class="rounded text-indigo-600 focus:ring-indigo-500">
                                Floor {{ $fl }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Rooms Targeting -->
                <div x-show="targetType === 'room'" class="space-y-2 pt-2">
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Target Rooms</label>
                    <div class="grid grid-cols-4 gap-2 max-h-32 overflow-y-auto border border-slate-100 p-2 rounded-xl">
                        @foreach($rooms as $rm)
                            <label class="flex items-center gap-1.5 text-[10px]">
                                <input type="checkbox" wire:model="selectedRooms" value="{{ $rm->id }}" class="rounded text-indigo-600 focus:ring-indigo-500">
                                Room {{ $rm->room_number }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Specific Tenants Targeting -->
                <div x-show="targetType === 'selected_tenants'" class="space-y-2 pt-2">
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Target Residents</label>
                    <div class="grid grid-cols-2 gap-2 max-h-32 overflow-y-auto border border-slate-100 p-2 rounded-xl">
                        @foreach($residents as $res)
                            <label class="flex items-center gap-1.5 text-[10px]">
                                <input type="checkbox" wire:model="selectedResidents" value="{{ $res->id }}" class="rounded text-indigo-600 focus:ring-indigo-500">
                                {{ $res->name }} (Rm: {{ $res->room ? $res->room->room_number : '-' }})
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Schedule Options -->
            <div x-data="{ publishOption: @entangle('publishOption') }" class="border-t border-slate-100 pt-3 space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Publish Schedule</label>
                        <select x-model="publishOption" required
                            class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900">
                            <option value="now">Publish Now (Immediate)</option>
                            <option value="later">Publish Later (Scheduled)</option>
                        </select>
                    </div>

                    <div x-show="publishOption === 'later'">
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Release Date & Time</label>
                        <input wire:model="publishAtDate" type="datetime-local"
                            class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        @error('publishAtDate') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Automatic Expiration (Optional)</label>
                        <input wire:model="expiresAtDate" type="datetime-local"
                            class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        @error('expiresAtDate') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="flex items-center gap-2 cursor-pointer font-semibold text-slate-650">
                            <input type="checkbox" wire:model="isPinned" class="rounded text-indigo-600 focus:ring-indigo-500">
                            Pin announcement to dashboard
                        </label>
                    </div>
                </div>
            </div>

            <!-- File attachment upload -->
            <div class="border-t border-slate-100 pt-3">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Supporting PDF or Image Attachment Document (Optional)</label>
                <input type="file" wire:model="attachmentFile" accept="image/*,application/pdf"
                    class="text-xs text-slate-500 file:mr-3 file:py-1 file:px-2 file:border-0 file:rounded-lg file:text-[10px] file:bg-indigo-50 file:text-indigo-650 cursor-pointer">
                @error('attachmentFile') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Cancel</x-button>
                <x-button variant="primary" size="sm" type="submit" loading="storeAnnouncement">Publish Broadcast</x-button>
            </div>
        </form>
    </x-modal>

</div>
