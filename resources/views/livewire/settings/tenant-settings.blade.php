<div class="space-y-6">
    
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Workspace Settings</h1>
        <p class="text-sm text-slate-500 mt-1">Configure your boarding house workspace branding, domain settings, and preferences.</p>
    </div>

    <!-- General Settings Card -->
    <x-card title="General Information" description="Update the branding details of your boarding house workspace.">
        <form wire:submit="updateSettings" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Workspace Name -->
                <div>
                    <label for="set_name" class="block text-sm font-medium text-slate-700 mb-1.5">Boarding House Name</label>
                    <input wire:model="tenant_name" id="set_name" type="text" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                    @error('tenant_name')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Slug/Subdomain -->
                <div>
                    <label for="set_slug" class="block text-sm font-medium text-slate-700 mb-1.5">Workspace Slug (URL Subdomain)</label>
                    <div class="relative flex items-stretch">
                        <input wire:model="tenant_slug" id="set_slug" type="text" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-xs text-slate-400 select-none bg-slate-100 px-3 rounded-r-xl border border-l-0 border-slate-200">
                            .kosan.test
                        </div>
                    </div>
                    @error('tenant_slug')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                    <span class="text-[10px] text-slate-400 block mt-1.5">
                        This slug is used in dynamic subdomains. E.g. <strong>{{ Str::slug($tenant_slug) }}.kosan.test</strong>
                    </span>
                </div>
            </div>

            <!-- Workspace Status info -->
            <div class="p-4 bg-indigo-50/20 border border-indigo-100/50 rounded-xl flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-800">Workspace Status</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Active and fully synchronized with the database.</p>
                    </div>
                </div>
                <x-badge variant="success">{{ strtoupper($status) }}</x-badge>
            </div>

            <!-- Submit -->
            <div class="flex justify-end pt-2">
                <x-button type="submit" variant="primary" size="sm" loading="updateSettings">Update Settings</x-button>
            </div>
        </form>
    </x-card>
</div>
