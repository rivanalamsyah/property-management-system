<div class="space-y-6">
    <!-- Header -->
    <div class="pb-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">SRE Observability & Monitoring Console</h1>
            <p class="text-sm text-slate-500 mt-1 leading-normal">Real-time metrics, HTTP latencies, grouped exceptions logs, and background worker queues.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
            <span class="text-xs font-bold text-slate-500">Live Streaming</span>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex flex-wrap gap-2 pb-2 border-b border-slate-100">
        @php
            $tabs = [
                'overview' => 'Overview Dashboard',
                'requests' => 'HTTP Request Stream',
                'exceptions' => 'Exceptions (Sentry)',
                'queues' => 'Queues & Scheduler',
                'logs' => 'Laravel Log Viewer',
                'workspaces' => 'Workspace Health',
                'alerts' => 'Alert Center',
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

    <!-- TAB CONTENTS -->

    <!-- OVERVIEW DASHBOARD -->
    @if($activeTab === 'overview')
        <!-- Metric KPI Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-2">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">P95 Response Latency</span>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-black text-slate-950">{{ $p95 }}</span>
                    <span class="text-xs text-slate-450 font-semibold">ms</span>
                </div>
                <div class="h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-500" style="width: {{ min(100, ($p95/800)*100) }}%"></div>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-2">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">P99 Response Latency</span>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-black text-slate-950">{{ $p99 }}</span>
                    <span class="text-xs text-slate-450 font-semibold">ms</span>
                </div>
                <div class="h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-violet-500" style="width: {{ min(100, ($p99/1200)*100) }}%"></div>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-2">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">CPU load / Memory</span>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-black text-slate-950">{{ $cpuUsage }}</span>
                    <span class="text-xs text-slate-450 font-semibold">/ {{ $memoryUsage }}</span>
                </div>
                <span class="text-[9px] font-bold text-emerald-600 block">System within parameters</span>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-2">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Background Workers load</span>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-black text-slate-950">{{ $pendingJobs }}</span>
                    <span class="text-xs text-slate-450 font-semibold">pending</span>
                </div>
                <span class="text-[9px] font-bold {{ $failedJobs > 0 ? 'text-rose-600' : 'text-slate-400' }} block">
                    {{ $failedJobs }} failed jobs registered
                </span>
            </div>
        </div>

        <!-- Timeline Status & Operations Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Health status timeline -->
            <div class="lg:col-span-2 bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Platform Availability SLA</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-bold text-slate-700">HTTP Latency SLAs (99.8%)</span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold uppercase text-[9px]">operational</span>
                    </div>

                    <!-- Green block bar timeline -->
                    <div class="flex gap-1">
                        @for($i=0; $i<40; $i++)
                            <div class="h-8 flex-1 bg-emerald-500/90 rounded hover:scale-110 hover:bg-emerald-600 transition cursor-pointer" title="Day -{{40-$i}}: 100% Up"></div>
                        @endfor
                    </div>

                    <div class="flex justify-between text-[10px] text-slate-400 font-bold">
                        <span>40 days ago</span>
                        <span>99.98% overall uptime</span>
                        <span>Today</span>
                    </div>
                </div>
            </div>

            <!-- Operational controls -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Operations Widgets</h3>
                
                <div class="space-y-3">
                    <button wire:click="flushCache" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition cursor-pointer">
                        Flush Redis Cache
                    </button>
                    <button wire:click="flushFailedJobs" wire:confirm="Are you sure you want to delete all failed queue jobs?" class="w-full py-2.5 bg-rose-50 hover:bg-rose-100 border border-rose-100 text-rose-700 text-xs font-bold rounded-xl transition cursor-pointer">
                        Clear Failed Queues
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- HTTP REQUESTS LOG STREAM -->
    @if($activeTab === 'requests')
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Incoming Requests (Live Stream)</h3>
            
            <div class="border border-slate-100 rounded-2xl overflow-hidden">
                <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                    <thead class="bg-slate-50 text-slate-450 font-bold uppercase text-[9px] tracking-wider">
                        <tr>
                            <th class="px-5 py-3">Timestamp</th>
                            <th class="px-5 py-3">Method</th>
                            <th class="px-5 py-3">Path</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Latency</th>
                            <th class="px-5 py-3">Source IP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 font-medium text-slate-650">
                        @forelse($requestLogs as $log)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-5 py-3 text-slate-400 text-[10px]">
                                    {{ $log->created_at }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-bold uppercase
                                        {{ $log->method === 'GET' ? 'bg-indigo-50 text-indigo-700' : 'bg-amber-50 text-amber-700' }}
                                    ">
                                        {{ $log->method }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 font-mono text-[11px] text-slate-700 max-w-[240px] truncate">
                                    {{ $log->url }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold
                                        {{ $log->status_code >= 400 ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}
                                    ">
                                        {{ $log->status_code }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 font-semibold">
                                    <span class="
                                        {{ $log->duration_ms > 500 ? 'text-rose-600' : ($log->duration_ms > 200 ? 'text-amber-600' : 'text-slate-600') }}
                                    ">
                                        {{ $log->duration_ms }} ms
                                    </span>
                                </td>
                                <td class="px-5 py-3 font-mono text-slate-400 text-[11px]">
                                    {{ $log->ip_address }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center text-slate-400 italic">No incoming requests captured yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- GROUPED EXCEPTIONS TRACKER -->
    @if($activeTab === 'exceptions')
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Grouped Exception Traces (Sentry Mock)</h3>

            <div class="space-y-3">
                @forelse($exceptions as $exc)
                    <div class="border border-slate-150 rounded-2xl overflow-hidden bg-slate-50/20">
                        <div wire:click="selectException('{{ $exc->id }}')" class="p-4 bg-slate-50 hover:bg-slate-100/50 flex items-center justify-between cursor-pointer border-b border-slate-100">
                            <div>
                                <span class="px-2 py-0.5 rounded bg-rose-50 border border-rose-100 text-rose-700 font-bold text-[9px] font-mono mr-2">{{ $exc->exception_class }}</span>
                                <span class="font-bold text-slate-900 text-xs">{{ $exc->message }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-0.5 rounded-full bg-slate-200 text-slate-700 font-bold text-[9px]">{{ $exc->occurrences_count }} events</span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform {{ $selectedExceptionId === $exc->id ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        @if($selectedExceptionId === $exc->id)
                            <div class="p-5 bg-white space-y-3 border-t border-slate-100">
                                <div class="text-[10px] space-y-1">
                                    <div class="flex gap-2"><span class="text-slate-400 font-bold">First URL:</span> <span class="font-mono text-slate-700">{{ $exc->url }}</span></div>
                                    <div class="flex gap-2"><span class="text-slate-400 font-bold">Last seen:</span> <span class="text-slate-700">{{ $exc->last_occurred_at }}</span></div>
                                </div>
                                <div class="border border-slate-100 rounded-xl p-4 bg-slate-50/50">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Stack Trace</span>
                                    <pre class="text-[10px] text-slate-650 font-mono overflow-x-auto whitespace-pre-wrap max-h-64">{{ $exc->stack_trace }}</pre>
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-400 italic border border-dashed border-slate-200 rounded-2xl">Excellent. Zero uncaught exceptions recorded.</div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- QUEUES & SCHEDULER -->
    @if($activeTab === 'queues')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Queues details -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-5">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Background Worker Queues</h3>

                <div class="space-y-4">
                    <div class="flex justify-between items-center text-xs p-3.5 bg-slate-50 border border-slate-100 rounded-2xl font-semibold">
                        <span class="text-slate-500">Active Pending Jobs</span>
                        <span class="text-slate-900 font-bold font-mono">{{ $pendingJobs }}</span>
                    </div>

                    <div class="flex justify-between items-center text-xs p-3.5 bg-slate-50 border border-slate-100 rounded-2xl font-semibold">
                        <span class="text-slate-500">Failed Worker Jobs</span>
                        <span class="text-rose-700 font-bold font-mono">{{ $failedJobs }}</span>
                    </div>

                    <div class="flex justify-between items-center text-xs p-3.5 bg-slate-50 border border-slate-100 rounded-2xl font-semibold">
                        <span class="text-slate-500">Daemon Workers Status</span>
                        <span class="text-emerald-700 font-bold flex items-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Active
                        </span>
                    </div>
                </div>
            </div>

            <!-- Scheduler details -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-5">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Schedules Tasks</h3>
                
                <div class="space-y-3.5">
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl text-[11px] font-semibold flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-900 block">generate:invoices</span>
                            <span class="text-slate-400 font-mono text-[9px]">0 0 1 * *</span>
                        </div>
                        <span class="text-slate-500 text-[10px]">Monthly, 1st Day</span>
                    </div>

                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl text-[11px] font-semibold flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-900 block">reminders:lease</span>
                            <span class="text-slate-400 font-mono text-[9px]">0 9 * * *</span>
                        </div>
                        <span class="text-slate-500 text-[10px]">Daily, 09:00 AM</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- LARAVEL LOG VIEWER -->
    @if($activeTab === 'logs')
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-3 border-b border-slate-50">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Searchable laravel.log file</h3>
                    <p class="text-[11px] text-slate-400">Direct read from storage/logs/laravel.log.</p>
                </div>
                <x-input type="text" wire:model.live.debounce.300ms="logSearch" placeholder="Filter logs level or message..." class="text-xs max-w-[200px]" />
            </div>

            <div class="bg-slate-900 rounded-2xl p-4 overflow-hidden border border-slate-800">
                <div class="max-h-96 overflow-y-auto space-y-2 pr-1 font-mono text-[10px] text-slate-350">
                    @forelse($laravelLogs as $log)
                        <div class="p-2 bg-slate-950 rounded border border-slate-900 leading-relaxed">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[9px] text-slate-500">{{ $log['date'] }}</span>
                                <span class="px-1 py-0.5 rounded text-[8px] font-bold uppercase
                                    {{ $log['level'] === 'ERROR' ? 'bg-rose-500/20 text-rose-400' : 'bg-slate-800 text-slate-400' }}
                                ">
                                    {{ $log['level'] }}
                                </span>
                            </div>
                            <div class="text-slate-300">{{ $log['message'] }}</div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-650 italic">No matches logs found in the trace file.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    <!-- WORKSPACE HEALTH -->
    @if($activeTab === 'workspaces')
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Multi-Tenant Workspaces Health Indexes</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($workspaces as $tenant)
                    <div class="p-5 border border-slate-100 bg-slate-50/20 rounded-3xl space-y-3.5">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-900 text-sm truncate max-w-[120px]">{{ $tenant['name'] }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-emerald-50 text-emerald-700">
                                {{ $tenant['status'] }}
                            </span>
                        </div>
                        <div class="text-[11px] space-y-1.5 font-semibold text-slate-550 border-t border-slate-50 pt-3">
                            <div class="flex justify-between"><span>Disk Size:</span> <span class="text-slate-800">{{ $tenant['storage'] }}</span></div>
                            <div class="flex justify-between"><span>Staff & Users:</span> <span class="text-slate-800">{{ $tenant['users_count'] }} active</span></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- ALERT CENTER -->
    @if($activeTab === 'alerts')
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">SRE Alarm Alert Rules</h3>
            
            <div class="space-y-3">
                @foreach($alertRules as $rule)
                    <div class="p-4 bg-slate-50 border rounded-2xl flex items-center justify-between
                        {{ $rule['status'] === 'CRITICAL' ? 'border-rose-200 bg-rose-50/10' : ($rule['status'] === 'WARNING' ? 'border-amber-250 bg-amber-50/10' : 'border-slate-100') }}
                    ">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">{{ $rule['rule'] }}</span>
                            <span class="text-[10px] text-slate-400 font-semibold font-mono block mt-0.5">{{ $rule['condition'] }}</span>
                            <p class="text-[10px] text-slate-500 mt-2 font-medium">{{ $rule['description'] }}</p>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase
                            {{ $rule['status'] === 'CRITICAL' ? 'bg-rose-100 text-rose-700' : ($rule['status'] === 'WARNING' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700') }}
                        ">
                            {{ $rule['status'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
