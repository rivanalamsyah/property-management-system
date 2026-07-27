<div class="space-y-6">
    
    <!-- Title & Action -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Saved Report Presets</h1>
        <p class="text-sm text-slate-500 mt-1">Load or manage your favorite saved report filter parameters instantly.</p>
    </div>

    <!-- Table Card -->
    <x-card class="overflow-hidden p-0!">
        <x-table :headers="['Preset Name', 'Report Focus', 'Assigned Parameters', 'Created By', 'Created At', 'Actions']">
            @forelse($reports as $rep)
                <tr class="hover:bg-slate-50/50 transition text-xs">
                    <!-- Name -->
                    <td class="px-6 py-4 font-bold text-slate-900">
                        {{ $rep->name }}
                        @if($rep->description)
                            <p class="text-[10px] text-slate-450 font-normal mt-0.5">{{ $rep->description }}</p>
                        @endif
                    </td>

                    <!-- Focus -->
                    <td class="px-6 py-4 whitespace-nowrap capitalize text-indigo-650 font-semibold">
                        {{ $rep->report_type }} Analytics
                    </td>

                    <!-- Filters Summary -->
                    <td class="px-6 py-4 font-mono text-[10px] text-slate-500">
                        @php
                            $summary = [];
                            if (!empty($rep->filters['boarding_house_id'])) {
                                $summary[] = 'Prop: ' . substr($rep->filters['boarding_house_id'], 0, 8);
                            } else {
                                $summary[] = 'Prop: All';
                            }
                            if (!empty($rep->filters['year'])) {
                                $summary[] = 'Year: ' . $rep->filters['year'];
                            }
                        @endphp
                        {{ implode(' | ', $summary) }}
                    </td>

                    <!-- Creator -->
                    <td class="px-6 py-4 whitespace-nowrap text-slate-800 font-bold">
                        {{ $rep->user ? $rep->user->name : 'System' }}
                    </td>

                    <!-- Created Date -->
                    <td class="px-6 py-4 whitespace-nowrap text-slate-450 font-mono text-[10px]">
                        {{ $rep->created_at->format('d M Y, H:i') }}
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2">
                        @php
                            $dashboardUrl = route('analytics.dashboard', array_merge([
                                'activeTab' => $rep->report_type,
                            ], $rep->filters));
                        @endphp
                        <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-indigo-600 transition cursor-pointer" onclick="window.location.href='{{ $dashboardUrl }}'" title="Buka Laporan" aria-label="Buka Laporan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </x-button>

                        <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl text-rose-600 border border-slate-200 hover:border-rose-100 hover:bg-rose-50 cursor-pointer" wire:click="deleteReport('{{ $rep->id }}')" title="Hapus Laporan" aria-label="Hapus Laporan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </x-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-0">
                        <x-empty-state title="No saved presets" description="Save your active reporting filters from the main dashboard screen to retrieve them here later."></x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>

    <div class="mt-4">
        {{ $reports->links('components.pagination') }}
    </div>

</div>
