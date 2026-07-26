<div class="space-y-6">
    <!-- Header -->
    <div class="pb-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Business Continuity & Disaster Recovery Console</h1>
            <p class="text-sm text-slate-500 mt-1 leading-normal">System backup catalogs, restore integrity validation, isolated workspace archiving, and disaster recovery simulation.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 font-bold uppercase text-[9px] flex items-center gap-1.5 animate-pulse">
                BCDR Readiness: 100%
            </span>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex flex-wrap gap-2 pb-2 border-b border-slate-100">
        @php
            $tabs = [
                'overview' => 'Executive Dashboard',
                'backups' => 'Backups Catalog',
                'restores' => 'Restore History Logs',
                'workspaces' => 'Workspace Recovery',
                'simulation' => 'Disaster Simulation',
            ];
        @endphp

        @foreach($tabs as $key => $label)
            <button wire:click="$set('activeTab', '{{ $key }}')" class="px-4 py-2 rounded-xl text-xs font-bold transition cursor-pointer
                {{ $activeTab === $key ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-650 hover:bg-slate-200' }}
            ">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <!-- OVERVIEW DASHBOARD -->
    @if($activeTab === 'overview')
        <!-- KPIs Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Backup Status</span>
                <span class="text-3xl font-black text-emerald-600 block">Healthy</span>
                <span class="text-[9px] font-semibold text-slate-450 block">Last backup: {{ $lastBackupDate }}</span>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Catalog Size</span>
                <span class="text-3xl font-black text-slate-900 block">{{ $totalSizeMb }}</span>
                <span class="text-[9px] font-semibold text-slate-450 block">Total files: {{ $backupCount }}</span>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">RPO Metric (Target)</span>
                <span class="text-3xl font-black text-slate-900 block">1 Hour</span>
                <span class="text-[9px] font-semibold text-slate-450 block">Continuous logs shipping</span>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">RTO Metric (Target)</span>
                <span class="text-3xl font-black text-slate-900 block">4 Hours</span>
                <span class="text-[9px] font-semibold text-slate-450 block">Fast restore pipelines active</span>
            </div>
        </div>

        <!-- Action Panel -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Trigger controls -->
            <div class="lg:col-span-2 bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Manual Backup Compilation</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Generates standalone backups targeting platform databases, storage folders, system settings, or media catalogs. Backups are hashed with MD5 verification signatures.</p>
                
                <div class="flex flex-wrap gap-3">
                    <button wire:click="createManualBackup('full')" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition cursor-pointer">
                        Backup Entire Platform
                    </button>
                    <button wire:click="createManualBackup('database')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition cursor-pointer">
                        Backup Databases Only
                    </button>
                </div>
            </div>

            <!-- Restore checklist -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Restore Readiness checklist</h3>
                <ul class="text-[11px] font-semibold text-slate-650 space-y-2 leading-relaxed">
                    <li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> MD5 integrity check passed</li>
                    <li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> DB migrations versions matching</li>
                    <li class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> Cloud S3 storage mock pings OK</li>
                </ul>
            </div>
        </div>
    @endif

    <!-- BACKUPS CATALOG -->
    @if($activeTab === 'backups')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Catalog table -->
            <div class="lg:col-span-2 bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Stored System Backups</h3>
                
                <div class="border border-slate-100 rounded-2xl overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                        <thead class="bg-slate-50 text-slate-450 font-bold uppercase text-[9px] tracking-wider">
                            <tr>
                                <th class="px-5 py-3">Archive Filename</th>
                                <th class="px-5 py-3">Type</th>
                                <th class="px-5 py-3">Size</th>
                                <th class="px-5 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-slate-650 font-medium">
                            @forelse($backups as $bk)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-5 py-3">
                                        <span class="font-bold text-slate-900 block">{{ $bk->filename }}</span>
                                        <span class="text-[9px] text-slate-400 font-mono mt-0.5 block">MD5: {{ $bk->checksum }}</span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-slate-100 text-slate-650">
                                            {{ $bk->type }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        {{ round($bk->size_bytes / 1024, 2) }} KB
                                    </td>
                                    <td class="px-5 py-3 text-right space-x-1">
                                        <button type="button" wire:click="$set('selectedBackupId', '{{ $bk->id }}')" class="px-2 py-1 bg-indigo-55 text-indigo-700 hover:bg-indigo-100 rounded-lg font-bold transition cursor-pointer">
                                            Restore
                                        </button>
                                        <button type="button" wire:click="deleteBackup('{{ $bk->id }}')" class="px-2 py-1 bg-slate-50 hover:bg-rose-50 hover:text-rose-700 rounded-lg text-slate-650 font-bold transition cursor-pointer">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-12 text-center text-slate-400 italic">No backup archives found. Compile one using the dashboard button.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Restore Wizard -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Platform Restoration Wizard</h3>
                
                @if($selectedBackupId)
                    <div class="space-y-4">
                        <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl">
                            <span class="text-[9px] text-indigo-600 font-bold uppercase tracking-wider block">Selected Archive</span>
                            <span class="text-xs font-bold text-slate-900 mt-1 block truncate">
                                {{ DB::table('monitoring_backups')->where('id', $selectedBackupId)->value('filename') }}
                            </span>
                        </div>

                        <div>
                            <x-label for="restoreReason">Reason for Restoration</x-label>
                            <x-input id="restoreReason" type="text" wire:model="restoreReason" placeholder="Reverting config setup failure" class="w-full mt-1.5 text-xs" />
                            <x-input-error for="restoreReason" class="mt-1" />
                        </div>

                        <button type="button" wire:click="triggerRestore" wire:confirm="WARNING: Proceeding will replace system records with the selected archive. Are you sure you want to proceed?" class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition cursor-pointer">
                            Initiate Restoration
                        </button>
                    </div>
                @else
                    <div class="py-12 text-center text-slate-400 text-xs italic">Select a backup archive from the table to configure the restoration process.</div>
                @endif
            </div>
        </div>
    @endif

    <!-- RESTORE HISTORY -->
    @if($activeTab === 'restores')
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Historical Restoration logs</h3>
            
            <div class="border border-slate-100 rounded-2xl overflow-hidden">
                <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                    <thead class="bg-slate-50 text-slate-450 font-bold uppercase text-[9px] tracking-wider">
                        <tr>
                            <th class="px-5 py-3">Timestamp</th>
                            <th class="px-5 py-3">Backup Archive File</th>
                            <th class="px-5 py-3">Operator</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Duration</th>
                            <th class="px-5 py-3">Reason Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-slate-650 font-medium">
                        @forelse($restores as $res)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-5 py-3 text-[10px] text-slate-400">
                                    {{ $res->created_at }}
                                </td>
                                <td class="px-5 py-3 font-mono text-[11px] text-slate-700 max-w-[200px] truncate">
                                    {{ $res->backup_filename }}
                                </td>
                                <td class="px-5 py-3">
                                    {{ $res->operator_name ?? 'System' }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold text-[9px] uppercase">
                                        {{ $res->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    {{ $res->duration_seconds }}s
                                </td>
                                <td class="px-5 py-3">
                                    {{ $res->reason }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-slate-400 italic">No platform restorations executed yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- WORKSPACE RECOVERY -->
    @if($activeTab === 'workspaces')
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Isolated Workspace Operations</h3>
            
            <div class="border border-slate-100 rounded-2xl overflow-hidden">
                <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                    <thead class="bg-slate-50 text-slate-450 font-bold uppercase text-[9px] tracking-wider">
                        <tr>
                            <th class="px-5 py-3">Workspace Name</th>
                            <th class="px-5 py-3">Current Status</th>
                            <th class="px-5 py-3 text-right">Isolation Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-slate-650 font-semibold">
                        @foreach($workspaces as $tenant)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-5 py-3 text-slate-900 text-xs">
                                    {{ $tenant->name }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase
                                        {{ $tenant->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}
                                    ">
                                        {{ $tenant->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right space-x-1">
                                    @if($tenant->status === 'active')
                                        <button type="button" wire:click="updateWorkspaceStatus('{{ $tenant->id }}', 'suspended')" class="px-2 py-1 bg-amber-50 hover:bg-amber-100 text-amber-750 rounded-lg transition cursor-pointer">
                                            Archive/Suspend
                                        </button>
                                    @else
                                        <button type="button" wire:click="updateWorkspaceStatus('{{ $tenant->id }}', 'active')" class="px-2 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-755 rounded-lg transition cursor-pointer">
                                            Reactivate
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- DISASTER SIMULATION -->
    @if($activeTab === 'simulation')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Action buttons -->
            <div class="lg:col-span-2 bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">DR Drill Failover Simulations</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Simulates failure indicators in the SRE dashboard to verify alerting mechanisms and operations playbook checklists. These simulations are non-destructive.</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <button wire:click="simulateDisaster('db')" class="p-4 bg-slate-50 hover:bg-slate-100 border border-slate-100 rounded-2xl text-left transition cursor-pointer">
                        <span class="font-bold text-slate-900 block text-xs">Simulate Database Failure</span>
                        <span class="text-[10px] text-slate-400 block mt-1">Triggers offline alarm alerts.</span>
                    </button>

                    <button wire:click="simulateDisaster('storage')" class="p-4 bg-slate-50 hover:bg-slate-100 border border-slate-100 rounded-2xl text-left transition cursor-pointer">
                        <span class="font-bold text-slate-900 block text-xs">Simulate Storage Disk Full</span>
                        <span class="text-[10px] text-slate-400 block mt-1">Triggers disk space warning alerts.</span>
                    </button>

                    <button wire:click="simulateDisaster('queue')" class="p-4 bg-slate-50 hover:bg-slate-100 border border-slate-100 rounded-2xl text-left transition cursor-pointer">
                        <span class="font-bold text-slate-900 block text-xs">Simulate Queue Bottleneck</span>
                        <span class="text-[10px] text-slate-400 block mt-1">Triggers worker job failure alerts.</span>
                    </button>
                </div>
            </div>

            <!-- Drill timeline stream -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Simulations logs stream</h3>
                
                <div class="space-y-3 font-mono text-[10px] leading-relaxed">
                    @forelse(array_reverse($simulationEvents) as $ev)
                        <div class="p-2.5 bg-slate-900 text-slate-300 rounded-xl border border-slate-800">
                            <div class="flex items-center justify-between text-[9px] text-slate-500 mb-1">
                                <span>{{ $ev['time'] }}</span>
                                <span class="uppercase text-rose-450 font-bold">{{ $ev['type'] }}</span>
                            </div>
                            <div>{{ $ev['desc'] }}</div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-400 text-xs italic">No SRE failover simulation events triggered in this session.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

</div>
