<div class="space-y-6" x-data="dashboardPage()" x-init="init()">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 reveal">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">
                Selamat Datang, <span class="text-gradient-primary">{{ auth()->user()->name }}</span>!
            </h1>
            @role('super_admin')
            <p class="text-xs text-slate-500 mt-1">Konsol tata kelola platform pusat dan kesehatan infrastruktur.</p>
            @elserole('owner')
            <p class="text-xs text-slate-500 mt-1">Ringkasan operasional dan keuangan ruang kerja hari ini.</p>
            @elserole('staff')
            <p class="text-xs text-slate-500 mt-1">Panel operasional harian operator dan check-in hunian.</p>
            @endrole
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-white border border-slate-200/80 text-slate-500 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Live — {{ now()->format('H:i') }}
            </span>
            @role('owner')
            <a href="{{ route('analytics.dashboard') }}"
               class="quick-action hidden sm:inline-flex">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/>
                </svg>
                Analisis
            </a>
            @endrole
        </div>
    </div>

    @role('super_admin')
    <!-- SUPER ADMIN DASHBOARD -->
    <!-- BENTO GRID — Platform KPI Cards -->
    <div class="bento-grid reveal">
        <!-- Total Workspaces -->
        <div class="bento-1x1">
            <div class="card-base card-hover h-full p-5 group cursor-default">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center shadow-sm shadow-indigo-500/30 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <a href="{{ route('workspaces.index') }}" class="text-slate-300 hover:text-indigo-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
                <div>
                    <p class="section-label mb-1">Total Ruang Kerja</p>
                    <h3 class="text-3xl font-black text-slate-900 kpi-counter" data-counter="{{ $totalTenants }}">{{ $totalTenants }}</h3>
                    <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-indigo-600">
                        <span>Penyewa SaaS terdaftar</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bento-1x1">
            <div class="card-base card-hover h-full p-5 group cursor-default">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-700 text-white flex items-center justify-center shadow-sm shadow-purple-500/30 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="section-label mb-1">Total Pengguna</p>
                    <h3 class="text-3xl font-black text-slate-900 kpi-counter" data-counter="{{ $totalUsers }}">{{ $totalUsers }}</h3>
                    <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-purple-600">
                        <span>Akun aktif platform</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Monthly Revenue -->
        <div class="bento-1x1">
            <div class="card-base card-hover h-full p-5 group cursor-default relative overflow-hidden">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center shadow-sm shadow-amber-500/30 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="section-label mb-1">Taksiran Pendapatan Platform</p>
                    <h3 class="text-2xl font-black text-slate-900 leading-tight">
                        Rp <span data-counter="{{ $platformRevenue }}" class="kpi-counter">{{ number_format($platformRevenue, 0, ',', '.') }}</span>
                    </h3>
                    <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                        <span>Langganan Aktif &amp; Trial</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Health Status -->
        <div class="bento-1x1">
            <div class="card-base card-hover h-full p-5 group cursor-default">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-white flex items-center justify-center shadow-sm shadow-emerald-500/30 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <a href="{{ route('monitoring.console') }}" class="text-slate-300 hover:text-emerald-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
                <div>
                    <p class="section-label mb-1">Status Keamanan &amp; SRE</p>
                    <h3 class="text-3xl font-black text-emerald-600">Aman</h3>
                    <div class="mt-3 flex items-center gap-1.5 text-xs text-slate-500">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Detak Jantung OK — Semua Node Aktif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div class="reveal flex flex-wrap gap-2.5 items-center bg-white border border-slate-200/80 rounded-2xl p-4 shadow-2xs">
        <span class="section-label mr-2">Aksi Platform:</span>
        <a href="{{ route('workspaces.index') }}" class="quick-action">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Kelola Ruang Kerja
        </a>
        <a href="{{ route('monitoring.console') }}" class="quick-action">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/></svg>
            Monitor Sistem
        </a>
        <a href="{{ route('security.center') }}" class="quick-action">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Keamanan &amp; Vault
        </a>
        <a href="{{ route('backup.center') }}" class="quick-action">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2"/></svg>
            Pencadangan &amp; Pemulihan
        </a>
    </div>

    <!-- Main Content Section: Subscriptions distribution & Audit logs -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <!-- Subscriptions distribution (3 cols) -->
        <div class="lg:col-span-3 reveal">
            <x-card title="Distribusi Paket Langganan" description="Jumlah penyewa terdaftar per paket langganan SaaS.">
                <x-table :headers="['Nama Paket', 'Tarif Bulanan', 'Jumlah Ruang Kerja']">
                    @foreach($plansDistribution as $plan)
                        <tr class="hover:bg-slate-50/60 transition-colors duration-100">
                            <td class="px-5 py-3.5 text-xs font-bold text-slate-800">{{ $plan->name }}</td>
                            <td class="px-5 py-3.5 text-xs font-semibold text-slate-600">Rp {{ number_format($plan->price_monthly, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5 text-xs text-slate-500">{{ $plan->tenants_count }} ruang kerja</td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card>
        </div>

        <!-- Global Activity Log (2 cols) -->
        <div class="lg:col-span-2 reveal">
            <x-card title="Log Audit Platform" description="Aktivitas global lintas ruang kerja.">
                <div class="space-y-0 max-h-[256px] overflow-y-auto pr-1">
                    @foreach($activities as $activity)
                        <div class="timeline-item">
                            <div class="timeline-dot bg-indigo-500"></div>
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-slate-800 truncate" title="{{ $activity->description }}">{{ $activity->description }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">Workspace: {{ $activity->tenant ? $activity->tenant->name : 'Sistem Platform' }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-[10px] font-semibold text-slate-500">{{ $activity->user ? $activity->user->name : 'Sistem' }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>
    </div>
    @elserole('staff')
    <!-- STAFF OPERATIONAL DASHBOARD -->
    <!-- BENTO GRID — Staff KPI Cards -->
    <div class="bento-grid reveal">
        <!-- Kamar Hunian -->
        <div class="bento-1x1">
            <div class="card-base card-hover h-full p-5 group cursor-default">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center shadow-sm shadow-indigo-500/30 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="section-label mb-1">Tingkat Hunian Kamar</p>
                    <h3 class="text-3xl font-black text-slate-900">{{ $occupancyRate }}%</h3>
                    <div class="mt-3 flex items-center gap-1.5 text-xs text-slate-500">
                        <span>{{ $occupiedRooms }} terisi dari {{ $totalRooms }} kamar</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Residents -->
        <div class="bento-1x1">
            <div class="card-base card-hover h-full p-5 group cursor-default">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-teal-500 to-teal-700 text-white flex items-center justify-center shadow-sm shadow-teal-500/30 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="section-label mb-1">Penghuni Hunian Aktif</p>
                    <h3 class="text-3xl font-black text-slate-900 kpi-counter" data-counter="{{ $activeResidentsCount }}">{{ $activeResidentsCount }}</h3>
                    <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-teal-650">
                        <span>Terdaftar aktif dalam sewa</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments to Verify -->
        <div class="bento-1x1">
            <div class="card-base card-hover h-full p-5 group cursor-default">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center shadow-sm shadow-amber-500/30 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <a href="{{ route('payments') }}" class="text-slate-300 hover:text-amber-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
                <div>
                    <p class="section-label mb-1">Butuh Verifikasi Bayar</p>
                    <h3 class="text-3xl font-black text-slate-900 kpi-counter" data-counter="{{ $paymentsWaitingVerification }}">{{ $paymentsWaitingVerification }}</h3>
                    <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-amber-600">
                        <span>Transfer bukti pembayaran masuk</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Repairs -->
        <div class="bento-1x1">
            <div class="card-base card-hover h-full p-5 group cursor-default">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-rose-400 to-rose-600 text-white flex items-center justify-center shadow-sm shadow-rose-500/30 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <a href="{{ route('complaints') }}" class="text-slate-300 hover:text-rose-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
                <div>
                    <p class="section-label mb-1">Tiket Keluhan Kerusakan</p>
                    <h3 class="text-3xl font-black text-slate-900">{{ $pendingComplaintsCount }}</h3>
                    <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold {{ $pendingComplaintsCount > 0 ? 'text-rose-650 animate-pulse' : 'text-emerald-650' }}">
                        <span>{{ $pendingComplaintsCount > 0 ? 'Memerlukan penanganan' : 'Semua keluhan selesai' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row for Staff -->
    <div class="reveal flex flex-wrap gap-2.5 items-center bg-white border border-slate-200/80 rounded-2xl p-4 shadow-2xs">
        <span class="section-label mr-2">Aksi Operasional:</span>
        <a href="{{ route('residents.create') }}" class="quick-action">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Tambah Penghuni
        </a>
        <a href="{{ route('contracts.create') }}" class="quick-action">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Check-In / Kontrak Baru
        </a>
        <a href="{{ route('payments') }}" class="quick-action">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Verifikasi Pembayaran
        </a>
    </div>

    <!-- Main Content for Staff: Operational Logs -->
    <div class="grid grid-cols-1 gap-6">
        <div class="reveal">
            <x-card title="Aktivitas Ruang Kerja" description="Aktivitas operasional ruang kerja terdekat.">
                <div class="space-y-0 max-h-[300px] overflow-y-auto pr-1">
                    @foreach($activities as $activity)
                        <div class="timeline-item">
                            <div class="timeline-dot bg-indigo-400"></div>
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-slate-800">{{ $activity->description }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right flex-shrink-0 text-[10px] font-semibold text-slate-500">
                                    {{ $activity->user ? $activity->user->name : 'Sistem' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>
    </div>
    @elserole('owner')
    <!-- OWNER LANDLORD DASHBOARD (ORIGINAL PREVIOUS FULL VIEW) -->
    <!-- BENTO GRID — KPI Cards -->
    <div class="bento-grid reveal">

        <!-- Kamar Kos (1×1) -->
        <div class="bento-1x1">
            <div class="card-base card-hover h-full p-5 group cursor-default">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center shadow-sm shadow-indigo-500/30 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <a href="{{ route('rooms') }}" class="text-slate-300 hover:text-indigo-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
                <div>
                    <p class="section-label mb-1">Total Kamar</p>
                    <h3 class="text-3xl font-black text-slate-900 kpi-counter"
                        data-counter="{{ $totalRooms }}">{{ $totalRooms }}</h3>
                    <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-indigo-600">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Terkelola di ruang ini</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Okupansi Ring (1×1) -->
        <div class="bento-1x1">
            <div class="card-base card-hover h-full p-5 group cursor-default">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <p class="section-label mb-1">Tingkat Okupansi</p>
                        <h3 class="text-3xl font-black text-slate-900">{{ $occupancyRate }}<span class="text-lg font-bold text-slate-400">%</span></h3>
                    </div>
                    <!-- SVG Ring Chart -->
                    <div class="relative w-14 h-14 occupancy-ring flex-shrink-0">
                        <svg viewBox="0 0 36 36" class="w-full h-full -rotate-90">
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e2e8f0" stroke-width="3"/>
                            <circle cx="18" cy="18" r="15.9" fill="none"
                                    stroke="{{ $occupancyRate >= 80 ? '#10b981' : ($occupancyRate >= 50 ? '#f59e0b' : '#f43f5e') }}"
                                    stroke-width="3"
                                    stroke-dasharray="{{ $occupancyRate }} {{ 100 - $occupancyRate }}"
                                    stroke-linecap="round"
                                    style="transition: stroke-dasharray 1.5s cubic-bezier(0.16,1,0.3,1)"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center text-[9px] font-black text-slate-600">
                            {{ $occupancyRate }}%
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0"></span>
                    {{ $occupiedRooms }}/{{ $totalRooms }} kamar terisi
                </div>
            </div>
        </div>

        <!-- Pendapatan (1×1) -->
        <div class="bento-1x1">
            <div class="card-base card-hover h-full p-5 group cursor-default overflow-hidden relative">
                <!-- Decorative gradient -->
                <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-gradient-to-br from-amber-400/10 to-amber-600/5 group-hover:scale-150 transition-transform duration-500"></div>

                <div class="flex items-start justify-between mb-4 relative">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center shadow-sm shadow-amber-500/30 flex-shrink-0 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="relative">
                    <p class="section-label mb-1">Pendapatan Bulan Ini</p>
                    <h3 class="text-2xl font-black text-slate-900 leading-tight">
                        Rp <span data-counter="{{ $currentMonthRevenue }}" class="kpi-counter">{{ number_format($currentMonthRevenue, 0, ',', '.') }}</span>
                    </h3>
                    <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Pembayaran terverifikasi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Kerusakan (1×1) -->
        <div class="bento-1x1">
            <div class="card-base card-hover h-full p-5 group cursor-default">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-rose-400 to-rose-600 text-white flex items-center justify-center shadow-sm shadow-rose-500/30 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <a href="{{ route('complaints') }}" class="text-slate-300 hover:text-rose-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
                <div>
                    <p class="section-label mb-1">Laporan Perbaikan</p>
                    <h3 class="text-3xl font-black text-slate-900">{{ $pendingComplaintsCount }}</h3>
                    <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold {{ $pendingComplaintsCount > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                        @if($pendingComplaintsCount > 0)
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                            Memerlukan penanganan
                        @else
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Semua terselesaikan
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Actions Row -->
    <div class="reveal flex flex-wrap gap-2.5 items-center bg-white border border-slate-200/80 rounded-2xl p-4 shadow-2xs">
        <span class="section-label mr-2 hidden sm:inline">Aksi Cepat:</span>
        <a href="{{ route('rooms.create') }}" class="quick-action">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kamar
        </a>
        <a href="{{ route('residents.create') }}" class="quick-action">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Tambah Penghuni
        </a>
        <a href="{{ route('invoices') }}" class="quick-action">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Lihat Tagihan
        </a>
        <a href="{{ route('payments') }}" class="quick-action">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Verifikasi Bayar
        </a>
    </div>

    <!-- Main Content Section: Chart & Activity Timeline -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        <!-- 1. Analisis Chart (3 cols) -->
        <div class="lg:col-span-3 reveal">
            <x-card title="Analisis Keuangan Bulanan" description="Total pendapatan terverifikasi per bulan pada tahun {{ date('Y') }}">
                <div class="h-64 flex items-end justify-between gap-3 px-2 pt-8 relative border-b border-slate-100/80 pb-3">
                    @php
                        $maxRevenue = max($revenueTrend) ?: 1;
                    @endphp
                    @foreach($revenueTrend as $month => $revenue)
                        @php
                            $percentage = ($revenue / $maxRevenue) * 100;
                            // Ensure there is always a tiny visually identifiable base line if revenue is 0
                            $barHeight = max($percentage, 2);
                        @endphp
                        <div class="flex-1 flex flex-col items-center group relative h-full justify-end">
                            <!-- Tooltip on hover -->
                            <div class="absolute bottom-full mb-2 bg-slate-900 text-white text-[10px] py-1.5 px-2.5 rounded-lg font-bold shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-15">
                                Rp {{ number_format($revenue, 0, ',', '.') }}
                            </div>

                            <!-- Bar with premium gradient -->
                            <div class="w-full max-w-[32px] bg-gradient-to-t from-indigo-600 to-indigo-400 rounded-t-md transition-all duration-300 group-hover:from-violet-600 group-hover:to-violet-400 group-hover:shadow-[0_0_12px_rgba(99,102,241,0.35)] cursor-pointer"
                                 style="height: {{ $barHeight }}%">
                            </div>

                            <!-- Month label -->
                            <span class="text-[9px] font-bold text-slate-400 font-mono mt-2 group-hover:text-indigo-650 transition-colors uppercase">
                                {{ substr($month, 0, 3) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>

        <!-- 2. Activity Log Timeline (2 cols) -->
        <div class="lg:col-span-2 reveal">
            <x-card :glass="true">
                <x-slot name="title">
                    <div class="flex items-center gap-2">
                        Audit Log Aktivitas
                        <x-badge variant="info" :dot="true">{{ $activities->count() }} aktivitas</x-badge>
                    </div>
                </x-slot>

                @if($activities->isNotEmpty())
                    <!-- Activity Timeline -->
                    <div class="space-y-0 max-h-[256px] overflow-y-auto pr-1">
                        @foreach($activities->take(5) as $activity)
                            @php
                                $color = 'bg-slate-300';
                                if (str_starts_with($activity->event, 'auth.login') && !str_contains($activity->event, 'failed')) $color = 'bg-emerald-400';
                                if (str_starts_with($activity->event, 'auth.login_failed')) $color = 'bg-rose-400';
                                if (str_starts_with($activity->event, 'tenant.')) $color = 'bg-indigo-400';
                                if (str_starts_with($activity->event, 'profile.')) $color = 'bg-amber-400';
                                if (str_starts_with($activity->event, 'settings.')) $color = 'bg-sky-400';
                            @endphp
                            <div class="timeline-item">
                                <div class="timeline-dot {{ $color }}"></div>
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-slate-800 truncate" title="{{ $activity->description }}">{{ $activity->description }}</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <x-badge variant="{{ str_starts_with($activity->event, 'auth.login_failed') ? 'danger' : (str_starts_with($activity->event, 'auth.') ? 'success' : 'neutral') }}" size="sm">{{ $activity->event }}</x-badge>
                                        </div>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <p class="text-[10px] font-semibold text-slate-500">{{ $activity->user ? $activity->user->name : 'Sistem' }}</p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($activities->count() > 5)
                        <div class="mt-3 pt-3 border-t border-slate-100/80">
                            <a href="{{ route('monitoring.console') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-colors">
                                Lihat semua {{ $activities->count() }} aktivitas
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    @endif
                @else
                    <x-empty-state
                        title="Belum ada aktivitas"
                        description="Setiap tindakan operasional akan muncul di sini."
                        icon="inbox"
                        size="sm"/>
                @endif
            </x-card>
        </div>
    </div>

    <!-- Full Activity Table (below the fold) -->
    <div class="reveal">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold text-slate-900">Log Aktivitas Lengkap</h2>
            <x-badge variant="neutral" :dot="false">{{ $activities->count() }} total</x-badge>
        </div>

        <x-table :headers="['Event', 'Deskripsi', 'Pengguna', 'Waktu', 'Alamat IP']" :stickyHeader="true">
            @forelse($activities as $activity)
                <tr class="hover:bg-slate-50/60 transition-colors duration-100">
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Event">
                        @php
                            $variant = 'neutral';
                            if (str_starts_with($activity->event, 'auth.login') && !str_contains($activity->event, 'failed')) $variant = 'success';
                            if (str_starts_with($activity->event, 'auth.login_failed')) $variant = 'danger';
                            if (str_starts_with($activity->event, 'tenant.')) $variant = 'info';
                            if (str_starts_with($activity->event, 'profile.')) $variant = 'warning';
                        @endphp
                        <x-badge :variant="$variant" :dot="true">{{ $activity->event }}</x-badge>
                    </td>
                    <td class="px-5 py-3.5 text-xs font-medium text-slate-700 max-w-xs truncate" data-label="Deskripsi">
                        {{ $activity->description }}
                    </td>
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs font-semibold text-slate-800" data-label="Pengguna">
                        {{ $activity->user ? $activity->user->name : 'Sistem' }}
                    </td>
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs text-slate-500" data-label="Waktu">
                        {{ $activity->created_at->diffForHumans() }}
                    </td>
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs text-slate-400 font-mono" data-label="IP">
                        {{ $activity->ip_address ?? '—' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-0">
                        <x-empty-state
                            title="Belum ada aktivitas tercatat"
                            description="Setiap aktivitas operasional pengguna dalam ruang kerja ini akan dicatat di sini."
                            icon="inbox"/>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>

    <!-- Developer Utilities Fold (at the bottom) -->
    <div class="reveal mt-6 pt-6 border-t border-slate-200/80">
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="space-y-1 text-center sm:text-left">
                <h4 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">Utilitas Developer &amp; Sistem</h4>
                <p class="text-[11px] text-slate-500 font-medium">Uji fungsionalitas sistem notifikasi toast secara langsung.</p>
            </div>
            <div class="flex flex-wrap gap-2 justify-center sm:justify-end">
                <x-button variant="success" size="sm" wire:click="triggerTestToast('success')" class="justify-center text-xs">
                    Sukses
                </x-button>
                <x-button variant="danger" size="sm" wire:click="triggerTestToast('error')" class="justify-center text-xs">
                    Error
                </x-button>
                <x-button variant="warning" size="sm" wire:click="triggerTestToast('warning')" class="justify-center text-xs">
                    Peringatan
                </x-button>
                <x-button variant="secondary" size="sm" wire:click="triggerTestToast('info')" class="justify-center text-xs">
                    Info
                </x-button>
            </div>
        </div>
    </div>
    @endrole

</div>

<script>
function dashboardPage() {
    return {
        init() {
            // Trigger counter animations after brief delay
            setTimeout(() => {
                document.querySelectorAll('[data-counter]').forEach(el => {
                    const target = parseFloat(el.getAttribute('data-counter'));
                    if (!isNaN(target)) {
                        const isFloat = target % 1 !== 0;
                        const duration = 1200;
                        const start = performance.now();
                        const update = (now) => {
                            const elapsed = now - start;
                            const progress = Math.min(elapsed / duration, 1);
                            const eased = 1 - Math.pow(1 - progress, 4);
                            const current = eased * target;
                            el.textContent = isFloat
                                ? current.toFixed(1)
                                : Math.floor(current).toLocaleString('id-ID');
                            if (progress < 1) requestAnimationFrame(update);
                        };
                        requestAnimationFrame(update);
                    }
                });
            }, 300);
        }
    };
}
</script>
