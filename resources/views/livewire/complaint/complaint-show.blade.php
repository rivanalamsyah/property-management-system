<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Details, Attachments, Comments -->
    <div class="col-span-1 lg:col-span-2 space-y-6">
        
        <!-- Case Details Card -->
        <x-card>
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row justify-between items-start gap-3 border-b border-slate-50 pb-4">
                    <div>
                        <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px]">Complaint Case</span>
                        <h2 class="text-lg font-bold font-mono text-slate-900 mt-0.5">{{ $complaint->complaint_number }}</h2>
                    </div>
                    <div class="sm:text-right">
                        <span class="block text-slate-400 font-bold uppercase tracking-wider text-[8px] mb-1">Priority Level</span>
                        @php
                            $pColor = 'bg-slate-100 text-slate-700';
                            if ($complaint->priority->value === 'high') $pColor = 'bg-amber-50 text-amber-700 border border-amber-250';
                            if ($complaint->priority->value === 'critical' || $complaint->priority->value === 'emergency') $pColor = 'bg-rose-50 text-rose-700 border border-rose-250';
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $pColor }}">{{ $complaint->priority->label() }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 py-2 text-xs border-b border-slate-50 pb-4">
                    <div>
                        <span class="text-slate-400 block font-bold uppercase tracking-wider text-[8px]">Property & Room</span>
                        <p class="font-bold text-slate-800 mt-1">{{ $complaint->boardingHouse->name }}</p>
                        <p class="font-mono text-indigo-650 font-semibold mt-0.5">Room {{ $complaint->room ? $complaint->room->room_number : '-' }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-bold uppercase tracking-wider text-[8px]">Reporter Resident</span>
                        <p class="font-bold text-slate-800 mt-1">{{ $complaint->resident->name }}</p>
                        <p class="text-slate-450 mt-0.5">{{ $complaint->resident->phone }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-bold uppercase tracking-wider text-[8px]">Date Reported</span>
                        <p class="font-semibold text-slate-800 mt-1">{{ $complaint->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-slate-450 mt-0.5 capitalize">Category: {{ $complaint->category }}</p>
                    </div>
                </div>

                <div class="space-y-2.5">
                    <h3 class="text-md font-bold text-slate-900">{{ $complaint->subject }}</h3>
                    <div class="text-xs text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $complaint->description }}</div>
                </div>

                @if($complaint->internal_notes)
                    <div class="bg-amber-50/10 border border-amber-100/50 p-3.5 rounded-xl text-xs text-amber-800 leading-normal">
                        <p class="font-bold uppercase tracking-wider text-[8px] mb-1">Office Staff Internal Annotations:</p>
                        <p>{{ $complaint->internal_notes }}</p>
                    </div>
                @endif
            </div>
        </x-card>

        <!-- Attachments Card -->
        <x-card title="Supporting Case Attachments" description="Images or documentation uploaded representing the complaint.">
            @if($complaint->attachments->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach($complaint->attachments as $attach)
                        <div class="group border border-slate-100 rounded-xl overflow-hidden bg-slate-50 relative">
                            <img src="{{ asset('storage/' . $attach->file_path) }}" alt="{{ $attach->label ?: 'Attachment' }}" class="w-full h-32 object-cover">
                            <div class="p-2 text-[10px] text-center bg-white border-t border-slate-50">
                                <a href="{{ asset('storage/' . $attach->file_path) }}" target="_blank" class="text-indigo-650 font-bold hover:underline">
                                    {{ $attach->label ?: 'Download file' }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs italic text-slate-400">No attachments provided with this complaint.</p>
            @endif
        </x-card>

        <!-- Discussion / Comments Card -->
        <x-card title="Discussion & Case History Feed" description="Internal team coordination or communication logs visible to the resident.">
            
            <!-- Comment Timeline Feed -->
            <div class="space-y-4 max-h-[350px] overflow-y-auto pr-2">
                @forelse($complaint->comments as $cmt)
                    @php
                        $isInternal = !$cmt->is_tenant_visible;
                        $bgClass = $isInternal ? 'bg-amber-50/10 border border-amber-100/40  : 'bg-slate-50/50  border border-slate-100 ;
                    @endphp
                    <div class="p-3.5 rounded-xl text-xs {{ $bgClass }} space-y-2">
                        <div class="flex justify-between items-center text-[10px]">
                            <div class="flex items-center gap-1.5">
                                <span class="font-bold text-slate-800">
                                    {{ $cmt->user ? $cmt->user->name : ($cmt->resident ? $cmt->resident->name : 'Anonymous') }}
                                </span>
                                @if($cmt->user)
                                    <span class="bg-indigo-50 text-indigo-750 px-1 py-0.2 rounded text-[8px] font-bold">STAFF</span>
                                @else
                                    <span class="bg-slate-100 text-slate-600 px-1 py-0.2 rounded text-[8px] font-bold">RESIDENT</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                @if($isInternal)
                                    <span class="text-amber-600 font-extrabold text-[8px] uppercase tracking-wider">Internal Only</span>
                                @else
                                    <span class="text-slate-400 text-[8px] uppercase tracking-wider">Public (Resident Visible)</span>
                                @endif
                                <span class="text-slate-400 font-mono font-semibold">{{ $cmt->created_at->format('d M, H:i') }}</span>
                            </div>
                        </div>
                        <p class="text-slate-700 leading-normal">{{ $cmt->comment }}</p>
                        @if($cmt->attachment_path)
                            <div class="pt-1.5 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                <a href="{{ asset('storage/' . $cmt->attachment_path) }}" target="_blank" class="text-indigo-650 hover:underline font-bold text-[10px]">Attached File Document</a>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-xs italic text-slate-400 py-2">No comments posted yet.</p>
                @endforelse
            </div>

            <!-- Comment Input -->
            <form wire:submit.prevent="postComment" class="mt-4 pt-4 border-t border-slate-50 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Post Comment</label>
                    <textarea wire:model="newComment" rows="3" required
                        class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/25"
                        placeholder="Write comments, instructions for technicians, or responses to resident..."></textarea>
                    @error('newComment') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 text-xs">
                    <!-- File uploader -->
                    <div>
                        <input type="file" wire:model="commentAttachment" accept="image/*,application/pdf"
                            class="text-xs text-slate-400 file:mr-2.5 file:py-1 file:px-2 file:border-0 file:rounded-lg file:text-[9px] file:font-bold file:bg-indigo-50 file:text-indigo-650 cursor-pointer">
                        @error('commentAttachment') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Options and Submit -->
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-1.5 cursor-pointer font-semibold text-slate-600">
                            <input type="checkbox" wire:model="isCommentPublic" class="text-indigo-600 rounded focus:ring-indigo-500">
                            Visible to Resident
                        </label>
                        <x-button variant="primary" size="sm" type="submit" loading="postComment" class="cursor-pointer">Post Comment</x-button>
                    </div>
                </div>
            </form>

        </x-card>

    </div>

    <!-- Right Column: Case Controls, Maintenance promotion, Checklists -->
    <div class="space-y-6">
        
        <!-- Workflow / Status Card -->
        <x-card title="Case Status Control" description="Transition complaint lifecycle phases.">
            <div class="space-y-4">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-400 font-semibold">Current Phase:</span>
                    @php
                        $variant = 'neutral';
                        if (in_array($complaint->status->value, ['completed', 'verified', 'closed'])) $variant = 'success';
                        if ($complaint->status->value === 'open') $variant = 'neutral';
                        if (in_array($complaint->status->value, ['reviewed', 'assigned'])) $variant = 'info';
                        if (in_array($complaint->status->value, ['in_progress', 'waiting_parts'])) $variant = 'warning';
                        if ($complaint->status->value === 'cancelled') $variant = 'danger';
                    @endphp
                    <x-badge :variant="$variant" class="uppercase text-[8px] font-bold px-2.5 py-0.5">
                        {{ $complaint->status->label() }}
                    </x-badge>
                </div>

                <!-- Action buttons based on permissions -->
                @can('update', $complaint)
                    <div class="flex flex-col gap-2 pt-2 border-t border-slate-50">
                        @if($complaint->status->value === 'open')
                            <x-button variant="outline" size="sm" class="justify-center cursor-pointer" wire:click="changeStatus('reviewed')">Mark Reviewed</x-button>
                        @endif

                        @if($complaint->status->value === 'completed')
                            <x-button variant="primary" size="sm" class="justify-center cursor-pointer bg-emerald-600! hover:bg-emerald-700!" wire:click="changeStatus('verified')">Verify & Resolve</x-button>
                        @endif

                        @if(in_array($complaint->status->value, ['completed', 'verified']))
                            <x-button variant="outline" size="sm" class="justify-center cursor-pointer" wire:click="changeStatus('closed')">Close Case File</x-button>
                        @endif

                        @if($complaint->status->value !== 'closed' && $complaint->status->value !== 'cancelled')
                            <x-button variant="outline" size="sm" class="justify-center cursor-pointer text-rose-600 border-slate-200" wire:click="changeStatus('cancelled')">Cancel Case</x-button>
                        @endif
                    </div>
                @endcan
            </div>
        </x-card>

        <!-- Promotion / Maintenance Task Section -->
        @if(!$complaint->maintenanceTask)
            <!-- Promotes Case to task card -->
            <x-card title="Promote to Maintenance Task" description="Convert this complaint into a tracked technician task worksheet.">
                <div class="text-xs text-slate-550 leading-relaxed mb-4">
                    Creates an official maintenance order trace, allowing technician assignment, estimated dates, checklists, parts and costs auditing.
                </div>
                <x-button variant="primary" size="sm" class="w-full justify-center cursor-pointer" wire:click="$set('showPromoteModal', true)">
                    Promote to Maintenance Task
                </x-button>
            </x-card>
        @else
            <!-- Maintenance Task Details and checklist -->
            <x-card>
                <div class="space-y-4">
                    <div class="flex justify-between items-start border-b border-slate-50 pb-3">
                        <div>
                            <span class="block text-[8px] font-bold text-slate-400 uppercase tracking-wider">Maintenance Task</span>
                            <span class="font-mono text-xs font-bold text-slate-900 mt-0.5">{{ $complaint->maintenanceTask->task_number }}</span>
                        </div>
                        <span class="text-[9px] bg-indigo-50 text-indigo-750 px-1.5 py-0.5 rounded font-bold uppercase">Worksheet</span>
                    </div>

                    <!-- Task allocation information -->
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-semibold">Assigned Tech:</span>
                            <span class="font-bold text-slate-800">
                                {{ $complaint->maintenanceTask->assignedStaff ? $complaint->maintenanceTask->assignedStaff->name : 'Unassigned' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-semibold">Estimated limit:</span>
                            <span class="font-bold text-slate-800">
                                {{ $complaint->maintenanceTask->estimated_completion_date ? $complaint->maintenanceTask->estimated_completion_date->format('d M Y') : '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-semibold">Est. Cost:</span>
                            <span class="font-bold text-slate-800">
                                Rp{{ number_format($complaint->maintenanceTask->cost, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Checklist Manager -->
                    <div class="border-t border-slate-50 pt-3.5 space-y-2.5">
                        <span class="block text-[8px] font-bold text-slate-400 uppercase tracking-wider">Work Checklist</span>
                        
                        <div class="space-y-2">
                            @foreach($complaint->maintenanceTask->checklists as $chk)
                                <div class="flex items-center justify-between text-xs hover:bg-slate-50/50 p-1 rounded transition">
                                    <label class="flex items-center gap-2 cursor-pointer text-slate-700 {{ $chk->is_completed ? 'line-through text-slate-400' : '' }}">
                                        <input type="checkbox" wire:click="toggleChecklistItem({{ $chk->id }})" {{ $chk->is_completed ? 'checked' : '' }}
                                            class="text-indigo-600 rounded focus:ring-indigo-500">
                                        {{ $chk->item }}
                                    </label>
                                    <button wire:click="deleteChecklistItem({{ $chk->id }})" class="text-rose-500 hover:text-rose-700 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-7v6m5-7h-14"></path></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <!-- Add checklist item form -->
                        <form wire:submit.prevent="addChecklistItem" class="flex gap-2 pt-2">
                            <input wire:model="newChecklistItem" type="text" placeholder="Add checklist line..."
                                class="flex-1 px-2 py-1 bg-slate-50/50 border border-slate-200 rounded-lg text-xs">
                            <x-button variant="outline" size="sm" type="submit" class="px-2! py-1! text-[10px] cursor-pointer">+</x-button>
                        </form>
                    </div>

                    <!-- Progress updates panel -->
                    <div class="border-t border-slate-50 pt-3.5 space-y-3.5">
                        <span class="block text-[8px] font-bold text-slate-400 uppercase tracking-wider">Update Progress & cost</span>
                        
                        <form wire:submit.prevent="saveProgress" class="space-y-3 text-xs">
                            <div>
                                <label class="block text-[9px] font-semibold text-slate-500 mb-1">Repair Notes</label>
                                <textarea wire:model="repairNotes" rows="2"
                                    class="w-full px-2 py-1 bg-slate-50/50 border border-slate-200 rounded-lg text-xs"
                                    placeholder="Summary of repair actions taken..."></textarea>
                            </div>

                            <div>
                                <label class="block text-[9px] font-semibold text-slate-500 mb-1">Replacement Parts Used</label>
                                <input wire:model="replacementParts" type="text"
                                    class="w-full px-2 py-1 bg-slate-50/50 border border-slate-200 rounded-lg text-xs"
                                    placeholder="e.g. PVC pipe, 2x light bulb">
                            </div>

                            <div>
                                <label class="block text-[9px] font-semibold text-slate-500 mb-1">Actual cost incurred (IDR)</label>
                                <input wire:model="actualCost" type="number" step="1000" min="0"
                                    class="w-full px-2 py-1 bg-slate-50/50 border border-slate-200 rounded-lg text-xs">
                            </div>

                            @if($complaint->status->value !== 'completed')
                                <label class="flex items-center gap-1.5 cursor-pointer font-bold text-slate-700 pt-1.5">
                                    <input type="checkbox" wire:model="isCompletedWork" class="text-indigo-600 rounded focus:ring-indigo-500">
                                    Mark Repair Work as Completed
                                </label>
                            @endif

                            <div class="pt-2 flex justify-end">
                                <x-button variant="primary" size="sm" type="submit" loading="saveProgress" class="cursor-pointer text-xs">Save Progress Parameters</x-button>
                            </div>
                        </form>
                    </div>

                </div>
            </x-card>
        @endif

        <!-- Case Timelines log audit -->
        <x-card title="Complaint Event Timeline" description="Trace of all workflow transitions.">
            <div class="flow-root mt-2">
                <ul role="list" class="-mb-8">
                    @forelse($complaint->timeline as $index => $timelineItem)
                        <li>
                            <div class="relative pb-8 text-xs">
                                @if($index !== $complaint->timeline->count() - 1)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                @endif
                                
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white text-white text-[9px] font-bold {{ $timelineItem->color ?: 'bg-indigo-500' }}">
                                            @if($timelineItem->event === 'submitted')
                                                +
                                            @elseif($timelineItem->event === 'assigned')
                                                W
                                            @elseif($timelineItem->event === 'completed')
                                                V
                                            @elseif($timelineItem->event === 'failed')
                                                X
                                            @else
                                                I
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-xs font-bold text-slate-800">{{ $timelineItem->title }}</p>
                                            @if($timelineItem->description)
                                                <p class="text-xs text-slate-550 mt-1 leading-normal">{{ $timelineItem->description }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right text-[10px] whitespace-nowrap text-slate-400 font-mono font-bold">
                                            <time>{{ $timelineItem->created_at->format('d M, H:i') }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-center text-xs italic text-slate-400 py-4">No events logged.</li>
                    @endforelse
                </ul>
            </div>
        </x-card>

    </div>

    <!-- MAINTENANCE TASK PROMOTION SETUP MODAL -->
    <x-modal wire:model="showPromoteModal" title="Initiate Maintenance order Worksheet" maxWidth="md">
        <form wire:submit.prevent="promoteToMaintenance" class="space-y-4">
            
            <!-- Assigned staff -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Assign Maintenance Technician</label>
                <select wire:model="assignedStaffId"
                    class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900">
                    <option value="">Choose technician...</option>
                    @foreach($staffUsers as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->name }} ({{ $staff->role }})</option>
                    @endforeach
                </select>
                @error('assignedStaffId') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Est. completion date -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Estimated Completion</label>
                    <input wire:model="estimatedCompletionDate" type="date"
                        class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    @error('estimatedCompletionDate') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Est cost -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Estimated Cost Budget (IDR)</label>
                    <input wire:model="cost" type="number" required min="0" step="1000"
                        class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    @error('cost') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Checklists Raw items -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Work Checklist Items Blueprint (One item per line)</label>
                <textarea wire:model="checklistItemsRaw" rows="3"
                    class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900"
                    placeholder="e.g.&#10;Check water pump connections&#10;Clean pipe blockage&#10;Replace pipe joint sealant"></textarea>
                @error('checklistItemsRaw') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Cancel</x-button>
                <x-button variant="primary" size="sm" type="submit" loading="promoteToMaintenance">Promote Worksheet</x-button>
            </div>
        </form>
    </x-modal>

</div>
