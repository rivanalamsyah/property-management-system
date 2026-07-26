<div class="space-y-6">
    <!-- Header -->
    <div class="pb-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Enterprise Security Control Center</h1>
            <p class="text-sm text-slate-500 mt-1 leading-normal">System firewall rules, session termination logs, identity matrices, and access threat detection.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold uppercase text-[9px] flex items-center gap-1.5">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                Zero Trust Shield Active
            </span>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex flex-wrap gap-2 pb-2 border-b border-slate-100">
        @php
            $tabs = [
                'dashboard' => 'Security Dashboard',
                'users' => 'IAM Role Matrix',
                'sessions' => 'Session Security',
                'firewall' => 'IP Firewall rules',
                'incidents' => 'Incident Center Alerts',
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

    <!-- DASHBOARD TAB -->
    @if($activeTab === 'dashboard')
        <!-- KPIs Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Security Score</span>
                <span class="text-3xl font-black text-emerald-600 block">A+ (98%)</span>
                <span class="text-[9px] font-semibold text-slate-400 block">Encryption enabled</span>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Open Threat Alerts</span>
                <span class="text-3xl font-black {{ $openAlertsCount > 0 ? 'text-rose-600' : 'text-slate-900' }} block">
                    {{ $openAlertsCount }}
                </span>
                <span class="text-[9px] font-semibold text-slate-450 block">Requires resolution notes</span>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Failed Logins (24h)</span>
                <span class="text-3xl font-black text-slate-900 block">{{ $failedLogins }}</span>
                <span class="text-[9px] font-semibold text-slate-450 block">Rate limits active</span>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Firewall Blocked Requests</span>
                <span class="text-3xl font-black text-slate-900 block">{{ $blockedRequests }}</span>
                <span class="text-[9px] font-semibold text-slate-450 block"> Banned IP requests blocked</span>
            </div>
        </div>

        <!-- Security policy cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Active Security Policies</h3>
                
                <div class="divide-y divide-slate-50 text-xs">
                    <div class="py-2.5 flex justify-between">
                        <span class="text-slate-550 font-medium">HTTPS Protocol Encryption</span>
                        <span class="text-slate-900 font-bold">Enforced (TLS 1.3)</span>
                    </div>
                    <div class="py-2.5 flex justify-between">
                        <span class="text-slate-550 font-medium">Session Idle Lifetime</span>
                        <span class="text-slate-900 font-bold">120 Minutes</span>
                    </div>
                    <div class="py-2.5 flex justify-between">
                        <span class="text-slate-550 font-medium">XSS & SQLi Shields</span>
                        <span class="text-slate-900 font-bold">Active (App level)</span>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Two-Factor Authentication (TOTP Preparation)</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Preparation architecture supports TOTP authentication apps (Google Authenticator, Authy) and emergency backup codes generator recovery.</p>
                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold uppercase text-[9px] inline-block">ready for migration</span>
            </div>
        </div>
    @endif

    <!-- IAM ROLE MATRIX TAB -->
    @if($activeTab === 'users')
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Identity Privilege Permission Matrix</h3>
            
            <div class="border border-slate-100 rounded-2xl overflow-hidden">
                <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                    <thead class="bg-slate-50 text-slate-450 font-bold uppercase text-[9px] tracking-wider">
                        <tr>
                            <th class="px-5 py-3">Permission Category</th>
                            @foreach($rolesList as $role)
                                <th class="px-5 py-3 text-center">{{ $role->label ?? $role->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-slate-650 font-semibold">
                        @foreach($permissionsList as $perm)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-5 py-3">
                                    <span class="text-slate-900 block font-bold">{{ $perm->label ?? $perm->name }}</span>
                                    <span class="text-[9px] text-slate-400 mt-0.5 block font-mono">{{ $perm->description }}</span>
                                </td>
                                @foreach($rolesList as $role)
                                    <td class="px-5 py-3 text-center">
                                        @if($role->permissions->contains('id', $perm->id))
                                            <span class="inline-block h-2 w-2 rounded-full bg-emerald-500" title="Granted"></span>
                                        @else
                                            <span class="inline-block h-2 w-2 rounded-full bg-slate-200" title="Denied"></span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- SESSION SECURITY TAB -->
    @if($activeTab === 'sessions')
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-50 pb-3">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Active User Sessions</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Protect remember logs and terminate unapproved devices.</p>
                </div>
                <button type="button" wire:click="terminateAllSessions" wire:confirm="Are you sure you want to log out all other active sessions?" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-100 text-rose-700 rounded-xl text-xs font-bold transition cursor-pointer">
                    Terminate All Other Sessions
                </button>
            </div>

            <div class="space-y-3">
                @foreach($sessions as $sess)
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-900">{{ $sess['user_name'] }}</span>
                                <span class="px-2 py-0.5 rounded-full bg-slate-200 text-slate-650 font-bold text-[9px] font-mono">{{ $sess['ip_address'] }}</span>
                            </div>
                            <p class="text-[10px] text-slate-450 leading-relaxed font-semibold">{{ $sess['user_agent'] }}</p>
                            <span class="text-[9px] text-indigo-600 font-bold block">Activity: {{ $sess['last_activity'] }}</span>
                        </div>
                        
                        <button type="button" wire:click="terminateSession('{{ $sess['id'] }}')" class="py-1.5 px-3 bg-white hover:bg-rose-50 border border-slate-200 hover:border-rose-200 rounded-xl text-xs font-bold text-slate-700 hover:text-rose-700 transition cursor-pointer">
                            Terminate Session
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- IP FIREWALL RULES TAB -->
    @if($activeTab === 'firewall')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Rules table list -->
            <div class="lg:col-span-2 bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Active Banned / Blocked IP rules</h3>
                
                <div class="border border-slate-100 rounded-2xl overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                        <thead class="bg-slate-50 text-slate-450 font-bold uppercase text-[9px] tracking-wider">
                            <tr>
                                <th class="px-5 py-3">Blocked IP Address</th>
                                <th class="px-5 py-3">Reason Description</th>
                                <th class="px-5 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-slate-650 font-medium">
                            @forelse($ipRules as $rule)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-5 py-3 font-mono text-slate-900 text-xs">
                                        {{ $rule->ip_address }}
                                    </td>
                                    <td class="px-5 py-3">
                                        {{ $rule->reason ?? 'No reason stated' }}
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <button type="button" wire:click="deleteIpRule('{{ $rule->id }}')" class="px-2 py-1 bg-slate-50 hover:bg-slate-100 rounded-lg text-slate-650 font-bold transition cursor-pointer">
                                            Remove Banning
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-8 text-center text-slate-400 italic">Zero IP addresses banned. Platform firewall is clear.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form: Add rule -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Add Firewall banning rule</h3>
                
                <div class="space-y-4">
                    <div>
                        <x-label for="newIp">Target IP Address</x-label>
                        <x-input id="newIp" type="text" wire:model="newIp" placeholder="e.g. 192.168.1.100" class="w-full mt-1.5 text-xs" />
                        <x-input-error for="newIp" class="mt-1" />
                    </div>

                    <div>
                        <x-label for="ipType">Rule Enforcement</x-label>
                        <select id="ipType" wire:model="ipType" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm">
                            <option value="block">Block Request (Ban IP)</option>
                        </select>
                    </div>

                    <div>
                        <x-label for="ipReason">Banning Description / Reason</x-label>
                        <x-input id="ipReason" type="text" wire:model="ipReason" placeholder="Brute force login attempts" class="w-full mt-1.5 text-xs" />
                    </div>

                    <button type="button" wire:click="addIpRule" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition cursor-pointer">
                        Add Ban Rule
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- INCIDENT CENTER TAB -->
    @if($activeTab === 'incidents')
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Security Alerts & Incidents Center</h3>

            <div class="space-y-4">
                @forelse($incidents as $inc)
                    <div class="p-5 border rounded-3xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6
                        {{ $inc->status === 'resolved' ? 'border-slate-100 bg-slate-50/20' : 'border-rose-200 bg-rose-50/10' }}
                    ">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded bg-rose-50 border border-rose-100 text-rose-700 font-bold text-[9px] font-mono uppercase">{{ $inc->event_type }}</span>
                                <span class="text-xs font-bold text-slate-900">{{ $inc->description }}</span>
                            </div>
                            <div class="text-[10px] text-slate-450 leading-relaxed font-semibold">
                                Timestamp: {{ $inc->created_at }} &bull; Source IP: <span class="font-mono">{{ $inc->ip_address }}</span>
                            </div>
                            @if($inc->status === 'resolved')
                                <div class="p-3 bg-slate-100 border border-slate-200 rounded-2xl text-[10px] font-semibold text-slate-650 whitespace-pre-line">
                                    <span class="font-bold text-slate-900 block mb-1">Resolution note:</span>
                                    {{ $inc->resolution_notes }}
                                </div>
                            @endif
                        </div>

                        @if($inc->status !== 'resolved')
                            <div class="w-full md:max-w-xs space-y-2">
                                <x-label>Resolve Incident Notes</x-label>
                                <x-input type="text" wire:model="resolutionNote" placeholder="Resolving actions taken..." class="w-full text-xs" />
                                <button type="button" wire:click="resolveIncident('{{ $inc->id }}')" class="w-full py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition cursor-pointer">
                                    Resolve Incident Alert
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-450 italic border border-dashed border-slate-200 rounded-2xl">Platform is secure. Zero security incidents detected.</div>
                @endforelse
            </div>
        </div>
    @endif

</div>
