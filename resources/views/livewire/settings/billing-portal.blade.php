<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-5 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">SaaS Subscription & Billing</h1>
            <p class="text-sm text-slate-500 mt-1 leading-normal">Manage your plans, trial dates, resource usages, and workspace settings.</p>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-100 pb-px">
        <button wire:click="$set('activeTab', 'overview')" class="px-4 py-2 text-sm font-semibold border-b-2 transition cursor-pointer {{ $activeTab === 'overview' ? 'border-indigo-650 text-indigo-650' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            Overview
        </button>
        <button wire:click="$set('activeTab', 'plan')" class="px-4 py-2 text-sm font-semibold border-b-2 transition cursor-pointer {{ $activeTab === 'plan' ? 'border-indigo-650 text-indigo-650' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            Subscription Plans
        </button>
        <button wire:click="$set('activeTab', 'settings')" class="px-4 py-2 text-sm font-semibold border-b-2 transition cursor-pointer {{ $activeTab === 'settings' ? 'border-indigo-650 text-indigo-650' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            Workspace Settings
        </button>
        <button wire:click="$set('activeTab', 'history')" class="px-4 py-2 text-sm font-semibold border-b-2 transition cursor-pointer {{ $activeTab === 'history' ? 'border-indigo-650 text-indigo-650' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            Audit Log
        </button>
    </div>

    <!-- Tab Contents -->
    <div>
        <!-- OVERVIEW TAB -->
        @if($activeTab === 'overview')
            <div class="space-y-6">
                <!-- Trial / Subscription Banner -->
                @if($tenant->subscription_status === \App\Enums\SubscriptionStatus::TRIAL)
                    <div class="p-6 bg-gradient-to-r from-indigo-50 to-violet-50 rounded-3xl border border-indigo-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shadow-sm">
                        <div>
                            <h3 class="text-base font-bold text-indigo-900">Saat ini Anda menggunakan Uji Coba Gratis</h3>
                            <p class="text-sm text-indigo-750 mt-1 leading-normal">
                                Uji coba tingkat profesional Anda akan berakhir dalam **{{ $trialRemainingDays }} hari** ({{ $tenant->trial_ends_at?->format('d M Y') }}).
                            </p>
                        </div>
                        <button wire:click="$set('activeTab', 'plan')" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow transition-all cursor-pointer">
                            Tingkatkan Paket
                        </button>
                    </div>
                @elseif($tenant->subscription_status === \App\Enums\SubscriptionStatus::CANCELLED)
                    <div class="p-6 bg-rose-50 rounded-3xl border border-rose-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-base font-bold text-rose-900">Langganan Dibatalkan</h3>
                            <p class="text-sm text-rose-750 mt-1 leading-normal">
                                Akun Anda dijadwalkan untuk dibatalkan. Layanan tetap aktif hingga **{{ $tenant->subscription_ends_at?->format('d M Y') }}**.
                            </p>
                        </div>
                        <button wire:click="$set('activeTab', 'plan')" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold shadow transition-all cursor-pointer">
                            Aktifkan Kembali
                        </button>
                    </div>
                @endif

                <!-- Overview Card -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Paket Saat Ini</span>
                        <span class="text-2xl font-black text-slate-900 block mt-2">
                            {{ $tenant->subscriptionPlan ? $tenant->subscriptionPlan->name : 'Belum ada paket yang dipilih' }}
                        </span>
                        <span class="inline-block mt-3 px-2.5 py-0.5 rounded-full text-[10px] font-bold capitalize
                            {{ $tenant->subscription_status === \App\Enums\SubscriptionStatus::ACTIVE ? 'bg-emerald-50 text-emerald-700' : '' }}
                            {{ $tenant->subscription_status === \App\Enums\SubscriptionStatus::TRIAL ? 'bg-indigo-50 text-indigo-700' : '' }}
                            {{ $tenant->subscription_status === \App\Enums\SubscriptionStatus::CANCELLED || $tenant->subscription_status === \App\Enums\SubscriptionStatus::EXPIRED ? 'bg-rose-50 text-rose-700' : '' }}
                        ">
                            Status: {{ $tenant->subscription_status->label() }}
                        </span>
                    </div>

                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Tanggal Perpanjangan</span>
                        @if($tenant->next_billing_at)
                            <span class="text-2xl font-black text-slate-900 block mt-2">
                                {{ $tenant->next_billing_at->format('d M Y') }}
                            </span>
                            <span class="text-xs text-slate-400 block mt-3 leading-normal">
                                Perpanjangan otomatis bulanan menggunakan metode pilihan.
                            </span>
                        @else
                            <span class="text-2xl font-black text-slate-900 block mt-2">N/A</span>
                            <span class="text-xs text-slate-400 block mt-3 leading-normal">Tidak ada jadwal perpanjangan mendatang.</span>
                        @endif
                    </div>

                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Metode Pembayaran</span>
                        <span class="text-2xl font-black text-slate-900 block mt-2">Manual / Bank</span>
                        <span class="text-xs text-slate-400 block mt-3 leading-normal">Integrasi Midtrans/Stripe telah disiapkan.</span>
                    </div>
                </div>

                <!-- Resource Usage Widget -->
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 tracking-tight">Penggunaan Sumber Daya Ruang Kerja</h3>
                    <p class="text-xs text-slate-500 leading-normal mt-1">Alokasi sumber daya dihitung berdasarkan batas paket Anda.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                        <!-- Rooms Usage -->
                        <div>
                            <div class="flex justify-between items-center text-sm font-semibold mb-2">
                                 <span class="text-slate-700">Kamar (Rooms)</span>
                                 <span class="text-slate-900">
                                     {{ $usage['rooms'] }} / {{ $tenant->getLimit('rooms') === -1 ? 'Tak Terbatas' : $tenant->getLimit('rooms') }}
                                 </span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-indigo-650 h-full rounded-full transition-all duration-300" style="width: {{ $tenant->getLimit('rooms') === -1 ? 100 : min(100, ($usage['rooms'] / $tenant->getLimit('rooms')) * 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Tenants Usage -->
                        <div>
                            <div class="flex justify-between items-center text-sm font-semibold mb-2">
                                <span class="text-slate-700">Penghuni (Residents)</span>
                                <span class="text-slate-900">
                                     {{ $usage['residents'] }} / {{ $tenant->getLimit('tenants') === -1 ? 'Tak Terbatas' : $tenant->getLimit('tenants') }}
                                </span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-indigo-650 h-full rounded-full transition-all duration-300" style="width: {{ $tenant->getLimit('tenants') === -1 ? 100 : min(100, ($usage['residents'] / $tenant->getLimit('tenants')) * 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Staff Usage -->
                        <div>
                            <div class="flex justify-between items-center text-sm font-semibold mb-2">
                                <span class="text-slate-700">Staf Operasional</span>
                                <span class="text-slate-900">
                                     {{ $usage['staff'] }} / {{ $tenant->getLimit('staff') === -1 ? 'Tak Terbatas' : $tenant->getLimit('staff') }}
                                </span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-indigo-650 h-full rounded-full transition-all duration-300" style="width: {{ $tenant->getLimit('staff') === -1 ? 100 : min(100, ($usage['staff'] / $tenant->getLimit('staff')) * 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Storage Usage -->
                        <div>
                            <div class="flex justify-between items-center text-sm font-semibold mb-2">
                                <span class="text-slate-700">Penyimpanan Digunakan</span>
                                <span class="text-slate-900">
                                    {{ $usage['storage'] }} MB / {{ $tenant->getLimit('storage') }} MB
                                </span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-indigo-650 h-full rounded-full transition-all duration-300" style="width: {{ min(100, ($usage['storage'] / $tenant->getLimit('storage')) * 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- PLAN SELECTION TAB -->
        @elseif($activeTab === 'plan')
            <div>
                <h3 class="text-xl font-bold text-slate-900 tracking-tight">Pilih tingkatan Ruang Kerja Anda</h3>
                <p class="text-sm text-slate-500 mt-1 leading-normal">Tingkatkan atau alihkan paket secara dinamis. Peningkatan langsung berlaku.</p>

                <!-- Pricing Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
                    @foreach($plans as $p)
                        <div class="bg-white border {{ $tenant->subscription_plan_id === $p->id ? 'border-indigo-600 ring-2 ring-indigo-500/20 shadow-md' : 'border-slate-100 shadow-sm' }} rounded-3xl p-6 flex flex-col justify-between hover:scale-[1.01] transition-all relative overflow-hidden">
                            @if($tenant->subscription_plan_id === $p->id)
                                <div class="absolute top-0 right-0 bg-indigo-600 text-white text-[9px] font-black tracking-widest px-3 py-1 uppercase rounded-bl-xl">Paket Saat Ini</div>
                            @endif

                            <div>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $p->name }}</span>
                                <div class="mt-4 flex items-baseline gap-1">
                                    <span class="text-2xl font-black text-slate-900">Rp {{ number_format($p->price_monthly / 1000) }}k</span>
                                    <span class="text-xs text-slate-400 font-medium">/bln</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-normal mt-2">{{ $p->description }}</p>

                                <div class="border-t border-slate-50 my-5"></div>

                                <ul class="space-y-2.5 text-xs text-slate-600 font-medium">
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Kamar Maksimal: {{ $p->max_rooms === -1 ? 'Tak Terbatas' : $p->max_rooms }}</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Penghuni Maksimal: {{ $p->max_tenants === -1 ? 'Tak Terbatas' : $p->max_tenants }}</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Batas penyimpanan: {{ $p->storage_limit_mb }}MB</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Portal: {{ $p->has_resident_portal ? 'Tersedia' : 'Tidak' }}</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-50">
                                @if($tenant->subscription_plan_id === $p->id)
                                    <button disabled class="w-full py-2 bg-slate-100 text-slate-500 rounded-xl text-xs font-semibold select-none cursor-default">
                                        Aktif Saat Ini
                                    </button>
                                @else
                                    <button wire:click="changePlan('{{ $p->id }}')" class="w-full py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow transition-all cursor-pointer">
                                        Tingkatkan Paket
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        <!-- SETTINGS TAB -->
        @elseif($activeTab === 'settings')
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Konfigurasi Ruang Kerja</h3>
                <p class="text-xs text-slate-500 leading-normal mt-1">Konfigurasikan entitas hukum, format lokal, dan slug branding.</p>

                <div class="mt-8 space-y-6 max-w-xl">
                    <div>
                        <x-label for="name">Nama Ruang Kerja</x-label>
                        <x-input id="name" type="text" wire:model="name" class="mt-1.5 w-full" />
                        <x-input-error for="name" class="mt-1.5" />
                    </div>

                    <div>
                        <x-label for="company_name">Nama Perusahaan</x-label>
                        <x-input id="company_name" type="text" wire:model="company_name" class="mt-1.5 w-full" />
                        <x-input-error for="company_name" class="mt-1.5" />
                    </div>

                    <div>
                        <x-label for="brand_name">Nama Brand</x-label>
                        <x-input id="brand_name" type="text" wire:model="brand_name" class="mt-1.5 w-full" />
                        <x-input-error for="brand_name" class="mt-1.5" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="timezone">Zona Waktu</x-label>
                            <x-input id="timezone" type="text" wire:model="timezone" class="mt-1.5 w-full" />
                        </div>
                        <div>
                            <x-label for="currency">Mata Uang</x-label>
                            <x-input id="currency" type="text" wire:model="currency" class="mt-1.5 w-full" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="language">Bahasa</x-label>
                            <x-input id="language" type="text" wire:model="language" class="mt-1.5 w-full" />
                        </div>
                        <div>
                            <x-label for="country">Negara</x-label>
                            <x-input id="country" type="text" wire:model="country" class="mt-1.5 w-full" />
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button wire:click="saveSettings" class="px-5 py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition cursor-pointer">
                            Simpan Pengaturan Ruang Kerja
                        </button>
                    </div>
                </div>
            </div>

        <!-- AUDIT LOG TAB -->
        @elseif($activeTab === 'history')
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Log Audit Ruang Kerja</h3>
                <p class="text-xs text-slate-500 leading-normal mt-1">Catatan log audit dari setiap operasi SaaS yang dipicu di dalam ruang kerja ini.</p>

                <div class="mt-6 border border-slate-50 rounded-2xl overflow-hidden overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold">
                            <tr>
                                <th class="px-4 py-3">Aktivitas</th>
                                <th class="px-4 py-3">Deskripsi</th>
                                <th class="px-4 py-3">Alamat IP</th>
                                <th class="px-4 py-3">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($auditLogs as $log)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-4 py-3 font-semibold text-slate-700">{{ $log->event }}</td>
                                    <td class="px-4 py-3 text-slate-500">{{ $log->description }}</td>
                                    <td class="px-4 py-3 font-mono text-slate-400">{{ $log->ip_address }}</td>
                                    <td class="px-4 py-3 text-slate-450">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-400 italic">Belum ada operasi yang tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
