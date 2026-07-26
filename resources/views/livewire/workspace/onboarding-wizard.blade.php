<div class="max-w-2xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <!-- Progress Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Setup Workspace</span>
            <span class="text-sm font-semibold text-slate-500">Step {{ $step }} of 5</span>
        </div>
        
        <!-- Bar Progress -->
        <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
            <div class="bg-indigo-650 h-full transition-all duration-300" style="width: {{ ($step / 5) * 100 }}%"></div>
        </div>
    </div>

    <!-- Step Content Card -->
    <div class="bg-white border border-slate-100 rounded-3xl shadow-xl overflow-hidden p-8 sm:p-10">
        
        <!-- Step 1: Settings -->
        @if($step === 1)
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Tell us about your organization</h2>
                <p class="mt-1.5 text-sm text-slate-500 leading-normal">Configure localization and naming settings for your premium boarding house workspace.</p>

                <div class="mt-8 space-y-6">
                    <div>
                        <x-label for="company_name">Company legal name</x-label>
                        <x-input id="company_name" type="text" wire:model="company_name" placeholder="e.g. Cihampelas Property Group" class="mt-1.5 w-full" />
                        <x-input-error for="company_name" class="mt-1.5" />
                    </div>

                    <div>
                        <x-label for="brand_name">Brand name</x-label>
                        <x-input id="brand_name" type="text" wire:model="brand_name" placeholder="e.g. Kosan Cihampelas" class="mt-1.5 w-full" />
                        <x-input-error for="brand_name" class="mt-1.5" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="timezone">Timezone</x-label>
                            <select id="timezone" wire:model="timezone" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Asia/Jakarta">Jakarta (GMT+7)</option>
                                <option value="Asia/Singapore">Singapore (GMT+8)</option>
                                <option value="UTC">UTC</option>
                            </select>
                            <x-input-error for="timezone" class="mt-1.5" />
                        </div>

                        <div>
                            <x-label for="currency">Currency</x-label>
                            <select id="currency" wire:model="currency" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="IDR">IDR (Rupiah)</option>
                                <option value="SGD">SGD (Dollar)</option>
                                <option value="USD">USD (Dollar)</option>
                            </select>
                            <x-input-error for="currency" class="mt-1.5" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="language">Language</x-label>
                            <select id="language" wire:model="language" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="id">Bahasa Indonesia</option>
                                <option value="en">English</option>
                            </select>
                            <x-input-error for="language" class="mt-1.5" />
                        </div>

                        <div>
                            <x-label for="country">Country</x-label>
                            <select id="country" wire:model="country" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="ID">Indonesia</option>
                                <option value="SG">Singapore</option>
                                <option value="US">United States</option>
                            </select>
                            <x-input-error for="country" class="mt-1.5" />
                        </div>
                    </div>
                </div>
            </div>

        <!-- Step 2: Primary Boarding House -->
        @elseif($step === 2)
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Create your first boarding house</h2>
                <p class="mt-1.5 text-sm text-slate-500 leading-normal">Every workspace requires at least one primary property branch to start operations.</p>

                <div class="mt-8 space-y-6">
                    <div>
                        <x-label for="house_name">Boarding house name</x-label>
                        <x-input id="house_name" type="text" wire:model="house_name" placeholder="e.g. Kost Premium Cihampelas" class="mt-1.5 w-full" />
                        <x-input-error for="house_name" class="mt-1.5" />
                    </div>

                    <div>
                        <x-label for="house_address">Full Street Address</x-label>
                        <x-input id="house_address" type="text" wire:model="house_address" placeholder="e.g. Jl. Cihampelas No. 123" class="mt-1.5 w-full" />
                        <x-input-error for="house_address" class="mt-1.5" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="house_city">City</x-label>
                            <x-input id="house_city" type="text" wire:model="house_city" placeholder="e.g. Bandung" class="mt-1.5 w-full" />
                            <x-input-error for="house_city" class="mt-1.5" />
                        </div>

                        <div>
                            <x-label for="house_province">Province</x-label>
                            <x-input id="house_province" type="text" wire:model="house_province" placeholder="e.g. Jawa Barat" class="mt-1.5 w-full" />
                            <x-input-error for="house_province" class="mt-1.5" />
                        </div>
                    </div>

                    <div>
                        <x-label for="house_whatsapp">Property WhatsApp number (for broadcasts)</x-label>
                        <x-input id="house_whatsapp" type="text" wire:model="house_whatsapp" placeholder="e.g. 081234567890" class="mt-1.5 w-full" />
                        <x-input-error for="house_whatsapp" class="mt-1.5" />
                    </div>
                </div>
            </div>

        <!-- Step 3: Room Import -->
        @elseif($step === 3)
            <div>
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Import Kamar (Rooms)</h2>
                        <p class="mt-1.5 text-sm text-slate-500 leading-normal">Upload CSV to bulk-create your rooms. You can skip this and create rooms manually later.</p>
                    </div>
                    <button type="button" wire:click="downloadRoomTemplate" class="inline-flex items-center gap-1 text-[11px] font-bold text-indigo-650 hover:underline">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Template.csv
                    </button>
                </div>

                <div class="mt-8 space-y-6">
                    <!-- Dropzone -->
                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-3xl hover:border-indigo-400 transition cursor-pointer relative">
                        <input type="file" wire:model="room_csv" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".csv" />
                        <div class="space-y-1 text-center pointer-events-none">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600">
                                <span class="font-semibold text-indigo-600">Upload a CSV file</span>
                            </div>
                            <p class="text-xs text-slate-400">CSV file format only</p>
                        </div>
                    </div>

                    <!-- Room CSV Loading indicators -->
                    <div wire:loading wire:target="room_csv" class="text-xs text-slate-500 font-medium">
                        Parsing CSV records and performing NIK verification...
                    </div>

                    <!-- Error Alert -->
                    @if($rooms_error_message)
                        <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl text-xs text-rose-700">
                            {{ $rooms_error_message }}
                        </div>
                    @endif

                    <!-- Preview Table -->
                    @if(!empty($rooms_preview))
                        <div class="border border-slate-100 rounded-2xl overflow-hidden max-h-56 overflow-y-auto">
                            <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                                <thead class="bg-slate-50 text-slate-500 font-bold">
                                    <tr>
                                        <th class="px-4 py-2">Room Number</th>
                                        <th class="px-4 py-2">Type</th>
                                        <th class="px-4 py-2">Rent</th>
                                        <th class="px-4 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($rooms_preview as $item)
                                        <tr class="{{ !$item['is_valid'] ? 'bg-rose-50/30' : '' }}">
                                            <td class="px-4 py-2 font-semibold">
                                                {{ $item['data']['room_number'] }}
                                                @if(!$item['is_valid'])
                                                    <span class="block text-[10px] text-rose-600 font-medium">{{ $item['errors'][0] }}</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-slate-500">{{ $item['data']['room_type'] }}</td>
                                            <td class="px-4 py-2 text-slate-700 font-mono">Rp {{ number_format($item['data']['monthly_rent']) }}</td>
                                            <td class="px-4 py-2">
                                                @if($item['is_valid'])
                                                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold">Valid</span>
                                                @else
                                                    <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10px] font-bold">Error</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        <!-- Step 4: Resident Import -->
        @elseif($step === 4)
            <div>
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Import Penghuni (Residents)</h2>
                        <p class="mt-1.5 text-sm text-slate-500 leading-normal">Upload CSV to bulk-create resident records. You can skip this and create them manually later.</p>
                    </div>
                    <button type="button" wire:click="downloadResidentTemplate" class="inline-flex items-center gap-1 text-[11px] font-bold text-indigo-650 hover:underline">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Template.csv
                    </button>
                </div>

                <div class="mt-8 space-y-6">
                    <!-- Dropzone -->
                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-3xl hover:border-indigo-400 transition cursor-pointer relative">
                        <input type="file" wire:model="resident_csv" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".csv" />
                        <div class="space-y-1 text-center pointer-events-none">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600">
                                <span class="font-semibold text-indigo-600">Upload a CSV file</span>
                            </div>
                            <p class="text-xs text-slate-400">CSV file format only</p>
                        </div>
                    </div>

                    <!-- Resident CSV Loading indicators -->
                    <div wire:loading wire:target="resident_csv" class="text-xs text-slate-500 font-medium">
                        Parsing CSV records and performing NIK verification...
                    </div>

                    <!-- Error Alert -->
                    @if($residents_error_message)
                        <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl text-xs text-rose-700">
                            {{ $residents_error_message }}
                        </div>
                    @endif

                    <!-- Preview Table -->
                    @if(!empty($residents_preview))
                        <div class="border border-slate-100 rounded-2xl overflow-hidden max-h-56 overflow-y-auto">
                            <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                                <thead class="bg-slate-50 text-slate-500 font-bold">
                                    <tr>
                                        <th class="px-4 py-2">Name</th>
                                        <th class="px-4 py-2">NIK</th>
                                        <th class="px-4 py-2">Email</th>
                                        <th class="px-4 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($residents_preview as $item)
                                        <tr class="{{ !$item['is_valid'] ? 'bg-rose-50/30' : '' }}">
                                            <td class="px-4 py-2 font-semibold">
                                                {{ $item['data']['name'] }}
                                                @if(!$item['is_valid'])
                                                    <span class="block text-[10px] text-rose-600 font-medium">{{ $item['errors'][0] }}</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-slate-500">{{ $item['data']['nik'] }}</td>
                                            <td class="px-4 py-2 text-slate-500 truncate max-w-[120px]">{{ $item['data']['email'] }}</td>
                                            <td class="px-4 py-2">
                                                @if($item['is_valid'])
                                                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold">Valid</span>
                                                @else
                                                    <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10px] font-bold">Error</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        <!-- Step 5: Finish -->
        @elseif($step === 5)
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-50">
                    <svg class="h-8 w-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <h2 class="mt-6 text-2xl font-bold text-slate-900 tracking-tight">Your workspace is ready!</h2>
                <p class="mt-2 text-sm text-slate-500 max-w-md mx-auto leading-normal">We've set up your brand configurations, created your primary boarding house, and validated your uploaded room and resident data.</p>

                <div class="mt-8 p-6 bg-slate-50 rounded-3xl border border-slate-100 inline-block text-left text-xs max-w-md w-full">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-slate-400 font-bold">Plan</span>
                        <span class="text-slate-700 font-bold">Professional Trial (14 Days Free)</span>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-slate-400 font-bold">Primary Property</span>
                        <span class="text-slate-700 font-bold truncate max-w-[200px]">{{ $house_name }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-slate-400 font-bold">Rooms imported</span>
                        <span class="text-slate-700 font-bold">{{ count($rooms_preview) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-bold">Residents imported</span>
                        <span class="text-slate-700 font-bold">{{ count($residents_preview) }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Card Footer Actions -->
        <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between">
            @if($step > 1)
                <button type="button" wire:click="prevStep" class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                    Back
                </button>
            @else
                <div></div>
            @endif

            @if($step < 5)
                <button type="button" wire:click="nextStep" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition shadow-md shadow-indigo-650/10 cursor-pointer">
                    Next Step
                </button>
            @else
                <button type="button" wire:click="finishOnboarding" class="inline-flex items-center gap-1.5 px-6 py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition shadow-md shadow-indigo-650/10 cursor-pointer">
                    Finish & Open Dashboard
                </button>
            @endif
        </div>

    </div>
</div>
