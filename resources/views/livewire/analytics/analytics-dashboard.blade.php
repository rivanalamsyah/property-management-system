<div class="space-y-6">
    
    <!-- Title & Action -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Business Intelligence Reports</h1>
            <p class="text-sm text-slate-500 mt-1">Enterprise reporting hub tracking occupancy trends, payment rates, monthly cash flows, and diagnostic complaints.</p>
        </div>
        <div class="flex-shrink-0 flex gap-2">
            <x-button variant="outline" size="sm" class="cursor-pointer font-semibold border-slate-200" wire:click="$set('showSaveModal', true)">
                Save Filters Preset
            </x-button>
            <x-button variant="primary" size="sm" class="cursor-pointer" wire:click="exportCSV">
                <span class="flex items-center gap-1.5 font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export CSV Data
                </span>
            </x-button>
        </div>
    </div>

    <!-- Filters Section -->
    <x-card class="py-4 px-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            
            <div class="flex flex-wrap items-center gap-3">
                <!-- Boarding House Select -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Boarding House</label>
                    <select wire:model.live="boarding_house_id"
                        class="px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 text-xs">
                        <option value="">All Boarding Houses</option>
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Year Select -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Report Year</label>
                    <select wire:model.live="year"
                        class="px-3 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 text-xs">
                        @foreach([2025, 2026, 2027, 2028] as $yr)
                            <option value="{{ $yr }}">{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="text-[10px] text-slate-400 italic">
                Report parameters isolation enforced under active workspace.
            </div>

        </div>
    </x-card>

    <!-- Executive KPI Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-card class="py-3 px-4">
            <p class="text-[9px] font-bold text-slate-450 uppercase tracking-wider">Occupancy Rate</p>
            <h3 class="text-xl font-extrabold text-slate-800 mt-1">{{ $kpis['occupancyRate'] }}%</h3>
            <span class="text-[10px] text-slate-400 font-medium">Of {{ $kpis['totalRooms'] }} total rooms</span>
        </x-card>
        
        <x-card class="py-3 px-4">
            <p class="text-[9px] font-bold text-slate-450 uppercase tracking-wider">Collection Rate</p>
            <h3 class="text-xl font-extrabold text-emerald-600 mt-1">{{ $kpis['collectionRate'] }}%</h3>
            <span class="text-[10px] text-slate-400 font-medium">Cash to receivable ratio</span>
        </x-card>

        <x-card class="py-3 px-4">
            <p class="text-[9px] font-bold text-slate-450 uppercase tracking-wider">Outstanding Bills</p>
            <h3 class="text-xl font-extrabold text-rose-600 mt-1">Rp {{ number_format($kpis['outstandingBills'], 0, ',', '.') }}</h3>
            <span class="text-[10px] text-slate-400 font-medium">Unpaid invoices totals</span>
        </x-card>

        <x-card class="py-3 px-4">
            <p class="text-[9px] font-bold text-slate-450 uppercase tracking-wider">Monthly Revenue</p>
            <h3 class="text-xl font-extrabold text-slate-900 mt-1">Rp {{ number_format($kpis['monthlyRevenue'], 0, ',', '.') }}</h3>
            <span class="text-[10px] text-slate-400 font-medium">Total completed this month</span>
        </x-card>
    </div>

    <!-- Interactive Navigation Tabs -->
    <div class="border-b border-slate-100 flex items-center gap-1.5 text-xs font-semibold">
        <button wire:click="switchTab('financials')"
            class="px-4 py-2.5 border-b-2 cursor-pointer transition {{ $activeTab === 'financials' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
            Financial Analytics
        </button>
        <button wire:click="switchTab('occupancy')"
            class="px-4 py-2.5 border-b-2 cursor-pointer transition {{ $activeTab === 'occupancy' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
            Room Utilization
        </button>
        <button wire:click="switchTab('tenants')"
            class="px-4 py-2.5 border-b-2 cursor-pointer transition {{ $activeTab === 'tenants' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
            Tenant Demographics
        </button>
        <button wire:click="switchTab('maintenance')"
            class="px-4 py-2.5 border-b-2 cursor-pointer transition {{ $activeTab === 'maintenance' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
            Maintenance Analytics
        </button>
    </div>

    <!-- Active Tab Presentation Panel -->
    <div class="space-y-6">

        <!-- 1. FINANCIALS TAB -->
        @if($activeTab === 'financials')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Monthly Revenue Trend Area SVG Chart -->
                <x-card class="col-span-1 lg:col-span-2" title="Monthly Revenue Trend" description="Total completed payments recorded by month for year {{ $year }}">
                    @if(max($revenueTrend) > 0)
                        <div class="space-y-4 pt-2">
                            <!-- Responsive Inline SVG graph coordinates -->
                            <div class="relative w-full h-44 bg-slate-50/50 border border-slate-100 rounded-2xl p-4">
                                <svg class="w-full h-full" viewBox="0 0 500 150" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-revenue" x1="0%" y1="0%" x2="0%" y2="100%">
                                            <stop offset="0%" stop-color="#6366f1" stop-opacity="0.25"></stop>
                                            <stop offset="100%" stop-color="#6366f1" stop-opacity="0.0"></stop>
                                        </linearGradient>
                                    </defs>
                                    <!-- Horizontal Gridlines -->
                                    <line x1="0" y1="35" x2="500" y2="35" stroke="#f1f5f9" stroke-width="1" class=""></line>
                                    <line x1="0" y1="75" x2="500" y2="75" stroke="#f1f5f9" stroke-width="1" class=""></line>
                                    <line x1="0" y1="115" x2="500" y2="115" stroke="#f1f5f9" stroke-width="1" class=""></line>
                                    <!-- Gradient Area Fill -->
                                    <polygon points="{{ $svgCoords['areaPoints'] }}" fill="url(#grad-revenue)"></polygon>
                                    <!-- Trend Stroke Line -->
                                    <polyline points="{{ $svgCoords['points'] }}" fill="none" stroke="#4f46e5" stroke-width="2.5" stroke-linecap="round"></polyline>
                                </svg>
                            </div>

                            <!-- Legend Months Labels -->
                            <div class="grid grid-cols-12 text-[8px] font-bold text-slate-400 font-mono text-center">
                                @foreach($revenueTrend as $month => $val)
                                    <span>{{ substr($month, 0, 3) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="py-12 text-center text-slate-400 italic text-xs">
                            No payment history logged for year {{ $year }} to draw revenue curves.
                        </div>
                    @endif
                </x-card>

                <!-- Revenue breakdown by Boarding House -->
                <x-card title="Revenue By Property" description="Total historical cash collected.">
                    <div class="space-y-4 pt-2 text-xs">
                        @forelse($propertyRevenues as $name => $revenue)
                            <div class="space-y-1.5">
                                <div class="flex justify-between font-semibold text-slate-700">
                                    <span>{{ $name }}</span>
                                    <span class="font-bold text-slate-900">Rp {{ number_format($revenue, 0, ',', '.') }}</span>
                                </div>
                                <div class="w-full bg-slate-150 h-1.5 rounded-full overflow-hidden">
                                    @php
                                        $max = max($propertyRevenues) ?: 1;
                                        $percent = ($revenue / $max) * 100;
                                    @endphp
                                    <div class="bg-indigo-500 h-full rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic">No revenue recorded by properties.</p>
                        @endforelse
                    </div>
                </x-card>
            </div>
        @endif

        <!-- 2. ROOM UTILIZATION TAB -->
        @if($activeTab === 'occupancy')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <x-card title="Occupancy Ratios breakdown" description="Inventory analysis.">
                    <div class="space-y-4 pt-2 text-xs">
                        
                        <div class="flex items-center justify-between border-b pb-2">
                            <span class="text-slate-500 font-semibold">Total Inventory:</span>
                            <span class="font-bold text-slate-800">{{ $kpis['totalRooms'] }} rooms</span>
                        </div>

                        <div class="flex items-center justify-between border-b pb-2">
                            <span class="text-emerald-600 font-semibold">Occupied:</span>
                            <span class="font-bold text-emerald-600">{{ $kpis['occupiedRooms'] }} rooms</span>
                        </div>

                        <div class="flex items-center justify-between pb-1">
                            <span class="text-slate-400 font-semibold">Vacant Available:</span>
                            <span class="font-bold text-slate-800">{{ $kpis['vacantRooms'] }} rooms</span>
                        </div>

                    </div>
                </x-card>

                <x-card title="Inventory Utilization Gauge" description="Current room usage percentage.">
                    <div class="flex flex-col items-center justify-center py-6 text-center space-y-3">
                        <div class="relative flex items-center justify-center">
                            <!-- Premium concentric visual circular status indicator -->
                            <svg class="w-24 h-24 transform -rotate-90">
                                <circle cx="48" cy="48" r="40" stroke="#f1f5f9" stroke-width="8" fill="transparent" class=""></circle>
                                <circle cx="48" cy="48" r="40" stroke="#6366f1" stroke-width="8" fill="transparent" 
                                    stroke-dasharray="251.2" stroke-dashoffset="{{ 251.2 - (251.2 * ($kpis['occupancyRate'] / 100)) }}" class="transition-all duration-500"></circle>
                            </svg>
                            <span class="absolute text-lg font-extrabold text-slate-800">{{ $kpis['occupancyRate'] }}%</span>
                        </div>
                        <p class="text-xs text-slate-450">Active occupancy saturation rate</p>
                    </div>
                </x-card>

            </div>
        @endif

        <!-- 3. DEMOGRAPHICS TAB -->
        @if($activeTab === 'tenants')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Gender Breakdown -->
                <x-card title="Gender Demographics" description="Active tenant gender shares.">
                    <div class="space-y-4 pt-2 text-xs">
                        @forelse($demographics['genders'] as $gender => $count)
                            <div class="space-y-1.5">
                                <div class="flex justify-between font-semibold capitalize text-slate-700">
                                    <span>{{ $gender }}</span>
                                    <span class="font-bold text-slate-900">{{ $count }} tenants</span>
                                </div>
                                <div class="w-full bg-slate-150 h-1.5 rounded-full overflow-hidden">
                                    @php
                                        $tot = array_sum($demographics['genders']) ?: 1;
                                        $percent = ($count / $tot) * 100;
                                    @endphp
                                    <div class="bg-indigo-500 h-full rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic">No resident demographic records matched.</p>
                        @endforelse
                    </div>
                </x-card>

                <!-- Occupation Breakdown -->
                <x-card title="Occupations shares" description="Resident occupation distributions.">
                    <div class="space-y-4 pt-2 text-xs">
                        @forelse($demographics['occupations'] as $job => $count)
                            <div class="space-y-1.5">
                                <div class="flex justify-between font-semibold capitalize text-slate-700">
                                    <span>{{ $job ?: 'Other' }}</span>
                                    <span class="font-bold text-slate-900">{{ $count }} tenants</span>
                                </div>
                                <div class="w-full bg-slate-150 h-1.5 rounded-full overflow-hidden">
                                    @php
                                        $max = max($demographics['occupations']) ?: 1;
                                        $percent = ($count / $max) * 100;
                                    @endphp
                                    <div class="bg-indigo-500 h-full rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic">No resident occupation records matched.</p>
                        @endforelse
                    </div>
                </x-card>
            </div>
        @endif

        <!-- 4. MAINTENANCE TAB -->
        @if($activeTab === 'maintenance')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Complaint Categories -->
                <x-card title="Complaint Categories distribution" description="Frequent problem areas.">
                    <div class="space-y-4 pt-2 text-xs">
                        @forelse($maintenanceIssues as $category => $count)
                            <div class="space-y-1.5">
                                <div class="flex justify-between font-semibold capitalize text-slate-700">
                                    <span>{{ str_replace('_', ' ', $category) }}</span>
                                    <span class="font-bold text-slate-900">{{ $count }} cases</span>
                                </div>
                                <div class="w-full bg-slate-150 h-1.5 rounded-full overflow-hidden">
                                    @php
                                        $max = max($maintenanceIssues) ?: 1;
                                        $percent = ($count / $max) * 100;
                                    @endphp
                                    <div class="bg-rose-500 h-full rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic">No historical complaints registered yet.</p>
                        @endforelse
                    </div>
                </x-card>

                <!-- Pending Complaints KPI card -->
                <x-card title="Maintenance backlog diagnostics" description="Outstanding complaints count pending work.">
                    <div class="flex flex-col items-center justify-center py-6 text-center space-y-3">
                        <div class="p-4 bg-rose-50 rounded-2xl text-rose-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-rose-600">{{ $kpis['pendingComplaints'] }} cases</h3>
                        <p class="text-xs text-slate-450">Awaiting work assignment or technician dispatch</p>
                    </div>
                </x-card>
            </div>
        @endif

    </div>

    <!-- SAVE CURRENT REPORT MODAL DIALOG -->
    <x-modal wire:model="showSaveModal" title="Save Report Preset" maxWidth="md">
        <form wire:submit.prevent="saveCurrentReport" class="space-y-4 text-xs">
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Preset Name</label>
                <input wire:model="reportName" type="text" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="e.g. Ciumbuleuit Financials Q3">
                @error('reportName') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Description (Optional)</label>
                <input wire:model="reportDescription" type="text" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs" placeholder="e.g. Track monthly revenue metrics for Ciumbuleuit.">
                @error('reportDescription') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Cancel</x-button>
                <x-button variant="primary" size="sm" type="submit" loading="saveCurrentReport">Save Preset</x-button>
            </div>
        </form>
    </x-modal>

</div>
