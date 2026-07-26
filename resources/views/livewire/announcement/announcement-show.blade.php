<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Details & Attachment Documents -->
    <div class="col-span-1 lg:col-span-2 space-y-6">
        
        <!-- Announcement Content Card -->
        <x-card>
            <div class="space-y-5">
                <!-- Metadata Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start gap-3 border-b border-slate-50 pb-4">
                    <div>
                        <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px]">Announcement Broadcast</span>
                        <h2 class="text-lg font-bold font-mono text-slate-900 mt-0.5">{{ $announcement->announcement_number }}</h2>
                    </div>
                    <div class="sm:text-right">
                        <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px] mb-1">Priority</span>
                        @php
                            $pColor = 'bg-slate-100 text-slate-700';
                            if ($announcement->priority->value === 'important') $pColor = 'bg-indigo-50 text-indigo-700 border border-indigo-250';
                            if ($announcement->priority->value === 'high' || $announcement->priority->value === 'emergency') $pColor = 'bg-rose-50 text-rose-700 border border-rose-250';
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $pColor }}">{{ $announcement->priority->label() }}</span>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 py-2 text-xs border-b border-slate-50 pb-4">
                    <div>
                        <span class="text-slate-400 block font-bold uppercase tracking-wider text-[8px]">Scope Type</span>
                        <p class="font-bold text-slate-800 mt-1 capitalize">{{ str_replace('_', ' ', $announcement->target_type) }}</p>
                        @if($announcement->boardingHouse)
                            <p class="text-slate-450 mt-0.5">{{ $announcement->boardingHouse->name }}</p>
                        @endif
                    </div>
                    <div>
                        <span class="text-slate-400 block font-bold uppercase tracking-wider text-[8px]">Author User</span>
                        <p class="font-bold text-slate-800 mt-1">{{ $announcement->author ? $announcement->author->name : 'System' }}</p>
                        <p class="text-slate-450 mt-0.5">SaaS Landlord Admin</p>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-bold uppercase tracking-wider text-[8px]">Schedule Date</span>
                        <p class="font-semibold text-slate-800 mt-1">{{ $announcement->publish_at->format('d M Y, H:i') }}</p>
                        @if($announcement->expires_at)
                            <p class="text-rose-500 mt-0.5">Expires: {{ $announcement->expires_at->format('d M Y, H:i') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Content Area -->
                <div class="space-y-4 pt-2">
                    <h3 class="text-xl font-extrabold text-slate-900 leading-snug">{{ $announcement->title }}</h3>
                    @if($announcement->summary)
                        <p class="text-sm font-semibold text-slate-500 border-l-2 border-slate-350 pl-3 italic">{{ $announcement->summary }}</p>
                    @endif
                    <div class="text-xs text-slate-700 leading-relaxed whitespace-pre-wrap pt-2">{{ $announcement->content }}</div>
                </div>
            </div>
        </x-card>

        <!-- Document Attachments Card -->
        <x-card title="Attachment Documents" description="Additional document resources linked to this announcement broadcast.">
            @if($announcement->attachment_path)
                <div class="bg-slate-50/50 p-4 border border-slate-100 rounded-xl flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-indigo-50 text-indigo-650 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="text-xs">
                            <p class="font-bold text-slate-800">{{ $announcement->attachment_name ?: 'Supporting Document Attachment' }}</p>
                            <p class="text-slate-400 mt-0.5 font-mono">Storage path: {{ basename($announcement->attachment_path) }}</p>
                        </div>
                    </div>
                    <x-button variant="outline" size="sm" class="px-3! py-1.5! text-xs font-semibold cursor-pointer" onclick="window.open('{{ asset('storage/' . $announcement->attachment_path) }}', '_blank')">
                        Download File
                    </x-button>
                </div>
            @else
                <p class="text-xs italic text-slate-400">No attachments provided with this announcement broadcast.</p>
            @endif
        </x-card>

        <!-- Recipients read receipt logs -->
        <x-card title="Targeted Recipients Tracker" description="Verify which residents have received and read this broadcast.">
            <div class="space-y-4">
                <div class="flex justify-between items-center gap-3">
                    <div class="relative w-56">
                        <input wire:model.live.debounce.250ms="searchRecipient" type="text"
                            class="w-full pl-9 pr-3 py-1 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none text-[10px]"
                            placeholder="Search recipient name...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <x-table :headers="['Tenant Resident', 'Room Allocation', 'Delivered Date', 'Read Status', 'Read Timestamp']">
                    @forelse($recipients as $rec)
                        <tr class="hover:bg-slate-50/50 transition text-xs">
                            <td class="px-6 py-3 whitespace-nowrap font-bold text-slate-900">
                                {{ $rec->resident->name }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap font-mono text-indigo-650 font-semibold">
                                Room {{ $rec->resident->room ? $rec->resident->room->room_number : '-' }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-slate-500 font-mono text-[10px]">
                                {{ $rec->delivered_at ? $rec->delivered_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                @if($rec->read_at)
                                    <x-badge variant="success" class="text-[7px] font-bold px-1.5 py-0.5">READ</x-badge>
                                @else
                                    <x-badge variant="neutral" class="text-[7px] font-bold px-1.5 py-0.5">DELIVERED</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-slate-650 font-mono text-[10px]">
                                {{ $rec->read_at ? $rec->read_at->format('d M Y, H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-0">
                                <x-empty-state title="No recipients logged" description="This happens if the target filters did not match any active residents with signed contracts."></x-empty-state>
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </div>
        </x-card>

    </div>

    <!-- Right Column: Case Controls & Analytics -->
    <div class="space-y-6">
        
        <!-- Workflow / Status Card -->
        <x-card title="Broadcast controls" description="Manage announcement visibility status.">
            <div class="space-y-4">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-400 font-semibold">Broadcast Status:</span>
                    @php
                        $variant = 'neutral';
                        if ($announcement->status->value === 'published') $variant = 'success';
                        if ($announcement->status->value === 'scheduled') $variant = 'info';
                        if ($announcement->status->value === 'draft') $variant = 'neutral';
                        if ($announcement->status->value === 'expired' || $announcement->status->value === 'cancelled') $variant = 'danger';
                        if ($announcement->status->value === 'archived') $variant = 'neutral';
                    @endphp
                    <x-badge :variant="$variant" class="uppercase text-[8px] font-bold px-2.5 py-0.5">
                        {{ $announcement->status->label() }}
                    </x-badge>
                </div>

                <!-- Action controls -->
                @can('update', $announcement)
                    <div class="flex flex-col gap-2 pt-2 border-t border-slate-50 text-xs">
                        @if($announcement->status->value === 'published')
                            <x-button variant="outline" size="sm" class="justify-center cursor-pointer" wire:click="updateStatus('archived')">Archive Notice</x-button>
                        @endif

                        @if(in_array($announcement->status->value, ['published', 'scheduled']))
                            <x-button variant="outline" size="sm" class="justify-center cursor-pointer text-rose-600 border-slate-200" wire:click="updateStatus('cancelled')">Cancel Notice</x-button>
                        @endif
                    </div>
                @endcan
            </div>
        </x-card>

        <!-- Recipients Stats Card -->
        <x-card title="Receipts Engagement Stats" description="Broadcasting read receipts analytics.">
            <div class="space-y-3.5 text-xs">
                
                <!-- Progress engagement bar -->
                <div class="space-y-1.5">
                    <div class="flex justify-between font-semibold">
                        <span class="text-slate-500">Read Completion Rate</span>
                        <span class="text-slate-900 font-bold">{{ $engagementRate }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full transition-all duration-300" style="width: {{ $engagementRate }}%"></div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-50 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Total Targeted:</span>
                        <span class="font-bold text-slate-800">{{ $totalRecipients }} residents</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Viewed / Read:</span>
                        <span class="font-bold text-emerald-600">{{ $readCount }} read</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Delivered (Unread):</span>
                        <span class="font-bold text-slate-500">{{ $unreadCount }} unread</span>
                    </div>
                </div>

            </div>
        </x-card>

    </div>

</div>
