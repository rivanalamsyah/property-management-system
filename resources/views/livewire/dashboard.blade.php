<div>
    <!-- Welcome Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p class="text-xs text-slate-500 mt-1">Berikut ringkasan aktivitas operasional dan keuangan ruang kerja Anda hari ini.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white border border-slate-200/80 text-slate-500 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Terakhir disinkronkan: {{ now()->format('H:i T') }}
            </span>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Rooms Card -->
        <x-card :hover="true" class="relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Total Kamar Kos</p>
                    <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalRooms }}</h3>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs text-indigo-600 font-bold">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Terkelola di ruang kerja ini</span>
            </div>
        </x-card>

        <!-- Active Residents Card -->
        <x-card :hover="true" class="relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Tingkat Okupansi</p>
                    <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $occupancyRate }}%</h3>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                <span>{{ $occupiedRooms }}/{{ $totalRooms }} kamar terisi</span>
            </div>
        </x-card>

        <!-- Revenue Card -->
        <x-card :hover="true" class="relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Pendapatan (Bulan Ini)</p>
                    <h3 class="text-2xl font-black text-slate-900 mt-1">Rp {{ number_format($currentMonthRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs text-emerald-600 font-bold">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Pembayaran terverifikasi</span>
            </div>
        </x-card>

        <!-- Complaints Card -->
        <x-card :hover="true" class="relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Laporan Perbaikan</p>
                    <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $pendingComplaintsCount }}</h3>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs text-rose-600 font-bold">
                <span>Memerlukan penanganan teknisi</span>
            </div>
        </x-card>
    </div>

    <!-- Quick Actions / Live Demo Area -->
    <x-card class="mb-8" title="Uji Coba Sistem Notifikasi Toast" description="Uji coba reaktivitas notifikasi toast melayang. Klik tombol di bawah untuk memicu notifikasi.">
        <div class="flex flex-wrap gap-3">
            <x-button variant="primary" size="sm" wire:click="triggerTestToast('success')">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-white"></span>
                    Picu Toast Sukses
                </span>
            </x-button>
            <x-button variant="danger" size="sm" wire:click="triggerTestToast('error')">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-white"></span>
                    Picu Toast Error
                </span>
            </x-button>
            <x-button variant="outline" size="sm" class="!text-amber-700 border-amber-200" wire:click="triggerTestToast('warning')">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    Picu Toast Peringatan
                </span>
            </x-button>
            <x-button variant="secondary" size="sm" wire:click="triggerTestToast('info')">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    Picu Toast Informasi
                </span>
            </x-button>
        </div>
    </x-card>

    <!-- Activity Log Section -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900 tracking-tight">Audit Log Aktivitas Ruang Kerja</h2>
            <x-badge variant="info" :dot="true">{{ $activities->count() }} total aktivitas</x-badge>
        </div>

        <x-table :headers="['Event / Kejadian', 'Deskripsi', 'Pengguna', 'Waktu', 'Alamat IP']">
            @forelse($activities as $activity)
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $variant = 'neutral';
                            if (str_starts_with($activity->event, 'auth.login')) $variant = 'success';
                            if (str_starts_with($activity->event, 'auth.login_failed')) $variant = 'danger';
                            if (str_starts_with($activity->event, 'tenant.')) $variant = 'info';
                            if (str_starts_with($activity->event, 'profile.')) $variant = 'warning';
                        @endphp
                        <x-badge :variant="$variant" :dot="true">{{ $activity->event }}</x-badge>
                    </td>
                    <td class="px-6 py-4 text-xs font-medium text-slate-700">
                        {{ $activity->description }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-800">
                        {{ $activity->user ? $activity->user->name : 'Sistem' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                        {{ $activity->created_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-400 font-mono">
                        {{ $activity->ip_address }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-0">
                        <x-empty-state title="Belum ada aktivitas tercatat" description="Setiap aktivitas operasional pengguna di dalam ruang kerja ini akan dicatat di sini."></x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>
</div>
