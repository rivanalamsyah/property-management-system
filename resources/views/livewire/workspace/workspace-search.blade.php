<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-5 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Workspace Management</h1>
            <p class="text-sm text-slate-500 mt-1 leading-normal">Search and manage platform workspaces, subscription tiers, and owner accounts.</p>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm flex flex-col md:flex-row items-center gap-4">
        <!-- Search Input -->
        <div class="relative w-full md:flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="h-4.5 w-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <x-input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, company, or slug..." class="w-full pl-10" />
        </div>

        <!-- Status Filter -->
        <div class="w-full md:w-48">
            <select wire:model.live="status" class="block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Statuses</option>
                @foreach(\App\Enums\WorkspaceStatus::cases() as $state)
                    <option value="{{ $state->value }}">{{ $state->label() }}</option>
                @endforeach
            </select>
        </div>

        <!-- Plan Filter -->
        <div class="w-full md:w-48">
            <select wire:model.live="plan" class="block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Plans</option>
                @foreach($plans as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Table List -->
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-6 py-3 cursor-pointer" wire:click="sortBy('name')">Workspace</th>
                        <th class="px-6 py-3">Owner Account</th>
                        <th class="px-6 py-3 cursor-pointer" wire:click="sortBy('subscription_plan_id')">Plan</th>
                        <th class="px-6 py-3 cursor-pointer" wire:click="sortBy('status')">Status</th>
                        <th class="px-6 py-3">Localization</th>
                        <th class="px-6 py-3 cursor-pointer" wire:click="sortBy('created_at')">Created Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($workspaces as $item)
                        <tr class="hover:bg-slate-50/50">
                            <!-- Workspace Detail -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $item->name }}</div>
                                <div class="text-slate-400 font-mono mt-0.5">{{ $item->slug }}</div>
                                @if($item->company_name)
                                    <div class="text-[10px] text-slate-500 font-semibold mt-1">{{ $item->company_name }}</div>
                                @endif
                            </td>

                            <!-- Owners linked -->
                            <td class="px-6 py-4">
                                @php
                                    $owner = $item->users->first();
                                @endphp
                                @if($owner)
                                    <div class="font-bold text-slate-700">{{ $owner->name }}</div>
                                    <div class="text-slate-400 mt-0.5">{{ $owner->email }}</div>
                                @else
                                    <span class="text-slate-400 italic">No owners attached</span>
                                @endif
                            </td>

                            <!-- Subscription plan -->
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800">
                                    {{ $item->subscriptionPlan ? $item->subscriptionPlan->name : 'N/A' }}
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5 capitalize">
                                    Sub status: {{ $item->subscription_status?->value ?? 'N/A' }}
                                </div>
                            </td>

                            <!-- Workspace Status -->
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold capitalize
                                    {{ $item->status === \App\Enums\WorkspaceStatus::ACTIVE ? 'bg-emerald-50 text-emerald-700' : '' }}
                                    {{ $item->status === \App\Enums\WorkspaceStatus::TRIAL ? 'bg-indigo-50 text-indigo-700' : '' }}
                                    {{ $item->status === \App\Enums\WorkspaceStatus::PENDING ? 'bg-amber-50 text-amber-700' : '' }}
                                    {{ $item->status === \App\Enums\WorkspaceStatus::SUSPENDED || $item->status === \App\Enums\WorkspaceStatus::BLOCKED ? 'bg-rose-50 text-rose-700' : '' }}
                                ">
                                    {{ $item->status ? $item->status->label() : 'N/A' }}
                                </span>
                            </td>

                            <!-- Localization details -->
                            <td class="px-6 py-4">
                                <div class="text-slate-700 font-medium">Currency: {{ $item->currency }}</div>
                                <div class="text-slate-400 mt-0.5">Timezone: {{ $item->timezone }}</div>
                            </td>

                            <!-- Created At -->
                            <td class="px-6 py-4 text-slate-500 font-medium">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">
                                No workspaces found matching the filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($workspaces->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-50">
                {{ $workspaces->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
