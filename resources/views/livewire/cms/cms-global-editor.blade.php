<div class="space-y-6 max-w-3xl">
    <!-- Header -->
    <div class="pb-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Global Website Information</h1>
            <p class="text-sm text-slate-500 mt-1 leading-normal">Configure global company profiles, addresses, contact metrics, and footer notices.</p>
        </div>
    </div>

    <!-- Main Forms Grid -->
    <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-8">
        
        <!-- Company Profile Section -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                Company Profile
            </h3>
            <div class="space-y-4">
                <div>
                    <x-label for="company_profile">Summary Description</x-label>
                    <textarea id="company_profile" wire:model="company_profile" rows="3" placeholder="Brief summary of your company..." class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
            </div>
        </div>

        <!-- Contact details -->
        <div class="pt-6 border-t border-slate-50 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                Contact & Office Details
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-label for="email">Public Contact Email</x-label>
                    <x-input id="email" type="email" wire:model="email" placeholder="e.g. info@kosan.test" class="w-full mt-1.5" />
                </div>
                <div>
                    <x-label for="phone">Public Office Phone</x-label>
                    <x-input id="phone" type="text" wire:model="phone" placeholder="e.g. 021-9999888" class="w-full mt-1.5" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-label for="whatsapp">WhatsApp Support Number</x-label>
                    <x-input id="whatsapp" type="text" wire:model="whatsapp" placeholder="e.g. 081234567890" class="w-full mt-1.5" />
                </div>
                <div>
                    <x-label for="business_hours">Business operational hours</x-label>
                    <x-input id="business_hours" type="text" wire:model="business_hours" placeholder="e.g. Mon - Fri, 09:00 - 18:00" class="w-full mt-1.5" />
                </div>
            </div>

            <div>
                <x-label for="address">Office Street Address</x-label>
                <x-input id="address" type="text" wire:model="address" placeholder="e.g. Jl. Jendral Sudirman No. 50" class="w-full mt-1.5" />
            </div>
        </div>

        <!-- Social Profiles -->
        <div class="pt-6 border-t border-slate-50 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                Social Media Links
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <x-label for="facebook">Facebook URL</x-label>
                    <x-input id="facebook" type="text" wire:model="facebook" placeholder="http://..." class="w-full mt-1.5" />
                </div>
                <div>
                    <x-label for="instagram">Instagram URL</x-label>
                    <x-input id="instagram" type="text" wire:model="instagram" placeholder="http://..." class="w-full mt-1.5" />
                </div>
                <div>
                    <x-label for="linkedin">LinkedIn URL</x-label>
                    <x-input id="linkedin" type="text" wire:model="linkedin" placeholder="http://..." class="w-full mt-1.5" />
                </div>
            </div>
        </div>

        <!-- Footer / Notices -->
        <div class="pt-6 border-t border-slate-50 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                Footer Branding & Copyright
            </h3>
            <div class="space-y-4">
                <div>
                    <x-label for="footer_info">Footer summary paragraph</x-label>
                    <textarea id="footer_info" wire:model="footer_info" rows="2" placeholder="Branding text shown in footer area..." class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                <div>
                    <x-label for="copyright">Footer copyright declaration</x-label>
                    <x-input id="copyright" type="text" wire:model="copyright" placeholder="e.g. © 2026 Kosan Inc. All rights reserved." class="w-full mt-1.5" />
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="pt-6 border-t border-slate-100 flex justify-end">
            <button wire:click="saveGlobals" class="px-5 py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition cursor-pointer">
                Save Global Info
            </button>
        </div>
    </div>
</div>
