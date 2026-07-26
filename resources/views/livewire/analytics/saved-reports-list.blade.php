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
                        <x-button variant="outline" size="sm" class="px-2.5! py-1! text-[10px] font-semibold cursor-pointer border-slate-200" onclick="window.location.href='{{ $dashboardUrl }}'">
                            Load Report
                        </x-button>

                        <x-button variant="outline" size="sm" class="px-2.5! py-1! text-[10px] font-semibold text-rose-600 border-slate-200 cursor-pointer" wire:click="deleteReport('{{ $rep->id }}')">
                            Delete
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
