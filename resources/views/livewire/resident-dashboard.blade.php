<div>
    <!-- Resident Portal Premium Banner -->
    <div class="mb-6 bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-700 text-white rounded-3xl p-6 shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute right-20 top-2 w-20 h-20 bg-indigo-400/20 rounded-full blur-xl"></div>
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-white/20 uppercase tracking-widest text-indigo-100">Portal Penghuni</span>
                    @if($activeContract)
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-400/20 uppercase tracking-widest text-emerald-200">Penghuni Aktif</span>
                    @endif
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight">Halo, {{ $resident->name }}!</h1>
                <p class="text-indigo-100/90 text-sm mt-1">Kamar {{ $resident->room ? $resident->room->room_number : 'N/A' }} &bull; {{ $resident->boardingHouse ? $resident->boardingHouse->name : 'Belum Ada Kos Terpilih' }}</p>
            </div>
            
            <div class="flex flex-wrap gap-2.5">
                @if($activeContract && $resident->status->value !== 'moving_out')
                    <x-button variant="outline" class="!bg-white/10 !border-white/20 !text-white hover:!bg-white/20" wire:click="$set('showCheckOutModal', true)">
                        Ajukan Check-Out
                    </x-button>
                @elseif($resident->status->value === 'moving_out')
                    <span class="px-4 py-2 rounded-xl text-sm font-semibold bg-amber-400/20 border border-amber-400/30 text-amber-200 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        Check-Out Sedang Ditinjau
                    </span>
                @endif
                <x-button variant="primary" class="!bg-white !text-indigo-600 hover:!bg-indigo-50" wire:click="$set('showComplaintModal', true)">
                    Laporkan Keluhan
                </x-button>
            </div>
        </div>
    </div>

    <!-- Quick Alerts for In-App Notifications / Announcements -->
    @if($notifications->count() > 0)
        <div class="mb-6 space-y-2">
            @foreach($notifications->take(2) as $notification)
                <div class="p-4 bg-indigo-50/60 border border-indigo-100/40 rounded-2xl flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.003 6.003 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-slate-800">{{ $notification->title }}</h4>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $notification->message }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Resident Navigation Tabs -->
    <div class="flex border-b border-slate-100 mb-6 gap-2">
        <button wire:click="switchResidentTab('room')" 
                class="px-4 py-2 text-sm font-semibold border-b-2 cursor-pointer transition {{ $activeResidentTab === 'room' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            Kamar & Peraturan Saya
        </button>
        <button wire:click="switchResidentTab('billing')" 
                class="px-4 py-2 text-sm font-semibold border-b-2 cursor-pointer transition {{ $activeResidentTab === 'billing' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            Tagihan & Pembayaran
        </button>
        <button wire:click="switchResidentTab('complaints')" 
                class="px-4 py-2 text-sm font-semibold border-b-2 cursor-pointer transition {{ $activeResidentTab === 'complaints' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            Keluhan & Diskusi
        </button>
    </div>

    <!-- Active Tab Sections -->
    <div class="space-y-6">
        @if($activeResidentTab === 'room')
            <!-- MY ROOM DETAILS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Room specs -->
                <div class="lg:col-span-2 space-y-6">
                    <x-card title="Spesifikasi Kamar" description="Detail tentang konfigurasi kamar kos Anda saat ini.">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-2">
                            <div class="p-3 bg-slate-50 rounded-xl">
                                <span class="text-xs text-slate-400 font-medium">Nomor Kamar</span>
                                <h4 class="text-base font-bold text-slate-800 mt-1">{{ $resident->room ? $resident->room->room_number : 'N/A' }}</h4>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl">
                                <span class="text-xs text-slate-400 font-medium">Lantai</span>
                                <h4 class="text-base font-bold text-slate-800 mt-1">{{ $resident->room ? $resident->room->floor : '1' }}</h4>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl">
                                <span class="text-xs text-slate-400 font-medium">Sewa Bulanan</span>
                                <h4 class="text-base font-bold text-slate-800 mt-1">Rp {{ number_format($resident->room ? $resident->room->monthly_rent : 0, 0, ',', '.') }}</h4>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl">
                                <span class="text-xs text-slate-400 font-medium">Status</span>
                                <h4 class="text-base font-bold text-emerald-600 mt-1 uppercase text-xs">{{ $resident->room ? $resident->room->status : 'tersedia' }}</h4>
                            </div>
                        </div>

                        <!-- Amenities -->
                        <div class="mt-6 border-t border-slate-100 pt-4">
                            <h4 class="text-sm font-semibold text-slate-700 mb-3">Fasilitas & Katalog Kamar</h4>
                            @if($resident->room && $resident->room->facilities->count() > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($resident->room->facilities as $fac)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-indigo-50 text-indigo-600 border border-indigo-100/40">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                            {{ $fac->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-xs text-slate-400 italic">Tidak ada fasilitas khusus yang dikonfigurasi untuk kamar ini.</p>
                            @endif
                        </div>
                    </x-card>

                    <!-- Active Contract Detail Card -->
                    @if($activeContract)
                        <x-card title="Kontrak Sewa Aktif" description="Ketentuan sewa, deposit, dan tanggal masa sewa Anda.">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                                    <div>
                                        <p class="text-xs text-slate-400">Nomor Kontrak</p>
                                        <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $activeContract->contract_number }}</p>
                                    </div>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                                        {{ $activeContract->status->label() }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <div>
                                        <p class="text-xs text-slate-400">Periode Kontrak</p>
                                        <p class="text-sm font-semibold text-slate-700 mt-0.5">
                                            {{ date('d M Y', strtotime($activeContract->start_date)) }} - {{ date('d M Y', strtotime($activeContract->end_date)) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">Tanggal Masuk</p>
                                        <p class="text-sm font-semibold text-slate-700 mt-0.5">
                                            {{ date('d M Y', strtotime($activeContract->move_in_date)) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">Jaminan Deposit</p>
                                        <p class="text-sm font-bold text-slate-700 mt-0.5">
                                            Rp {{ number_format($activeContract->security_deposit, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </x-card>
                    @endif
                </div>

                <!-- Boarding House Contacts & Rules -->
                <div class="space-y-6">
                    <x-card title="Informasi Kos">
                        @if($resident->boardingHouse)
                            <div class="space-y-4">
                                <h3 class="text-base font-bold text-slate-800">{{ $resident->boardingHouse->name }}</h3>
                                <p class="text-xs text-slate-500">{{ $resident->boardingHouse->address }}, {{ $resident->boardingHouse->city }}</p>
                                
                                @if($resident->boardingHouse->whatsapp_number)
                                    <a href="https://wa.me/{{ $resident->boardingHouse->whatsapp_number }}" target="_blank" 
                                       class="inline-flex items-center justify-center gap-2 w-full px-4 py-2 rounded-xl text-sm font-semibold bg-emerald-50 text-emerald-600 hover:bg-emerald-100/50 transition">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.513 2.262 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.731-1.456L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.743.003-2.602-1.012-5.05-2.859-6.898C16.63 2.115 14.183 1.1 11.582 1.1 6.148 1.1 1.72 5.47 1.716 10.843c-.001 1.64.453 3.24 1.314 4.678L2.006 20.9l5.097-1.336z"/>
                                        </svg>
                                        Hubungi Pemilik Kos (WhatsApp)
                                    </a>
                                @endif
                            </div>
                        @else
                            <p class="text-xs text-slate-400 italic">Belum ada kos aktif yang tertaut.</p>
                        @endif
                    </x-card>
                </div>
            </div>

        @elseif($activeResidentTab === 'billing')
            <!-- BILLING & PAYMENTS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Invoices -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-900">Tagihan Sewa Anda</h2>
                        <x-badge variant="info">{{ $invoices->count() }} tagihan</x-badge>
                    </div>

                    <x-table :headers="['No. Tagihan', 'Periode Tagihan', 'Total Tagihan', 'Jatuh Tempo', 'Status', 'Aksi']">
                        @forelse($invoices as $inv)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800">
                                    {{ $inv->invoice_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                                    {{ date('M Y', strtotime($inv->period_start)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-800">
                                    Rp {{ number_format($inv->grand_total, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                                    {{ date('d M Y', strtotime($inv->due_date)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $v = 'neutral';
                                        if($inv->status->value === 'paid') $v = 'success';
                                        if($inv->status->value === 'unpaid') $v = 'danger';
                                        if($inv->status->value === 'waiting_verification') $v = 'warning';
                                    @endphp
                                    <x-badge :variant="$v">{{ $inv->status->label() }}</x-badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs flex items-center gap-2">
                                    @if($inv->status->value === 'unpaid')
                                        <button wire:click="openPaymentModal('{{ $inv->id }}')" 
                                                class="inline-flex items-center justify-center p-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-600 transition cursor-pointer"
                                                title="Bayar / Unggah Bukti Transfer"
                                                aria-label="Bayar / Unggah Bukti Transfer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    <a href="#" 
                                       class="inline-flex items-center justify-center p-2 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-600 transition cursor-pointer"
                                       title="Unduh PDF"
                                       aria-label="Unduh PDF">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-0">
                                    <x-empty-state title="Tagihan tidak tersedia" description="Anda tidak memiliki tagihan yang dibuat atau tertunda di ruang kerja ini."></x-empty-state>
                                </td>
                            </tr>
                        @endforelse
                    </x-table>
                </div>

                <!-- Payments list / history -->
                <div class="space-y-6">
                    <h2 class="text-lg font-bold text-slate-900">Riwayat Bukti Pembayaran</h2>
                    
                    <div class="space-y-3">
                        @forelse($payments as $pay)
                            <div class="p-4 bg-white border border-slate-100 rounded-2xl">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-bold text-slate-800">{{ $pay->payment_number }}</span>
                                    @php
                                        $v = 'neutral';
                                        if($pay->status->value === 'completed') $v = 'success';
                                        if($pay->status->value === 'waiting_verification') $v = 'warning';
                                        if($pay->status->value === 'failed') $v = 'danger';
                                    @endphp
                                    <x-badge :variant="$v" size="sm">{{ $pay->status->label() }}</x-badge>
                                </div>
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-sm font-extrabold text-slate-900">Rp {{ number_format($pay->amount_paid, 0, ',', '.') }}</p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">{{ date('d M Y H:i', strtotime($pay->payment_date)) }} &bull; {{ strtoupper($pay->payment_method) }}</p>
                                    </div>
                                    @if($pay->status->value === 'completed')
                                        <a href="#" 
                                           class="inline-flex items-center justify-center p-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-105 text-indigo-650 transition cursor-pointer"
                                           title="Unduh Kwitansi"
                                           aria-label="Unduh Kwitansi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <x-empty-state title="Belum ada pembayaran tercatat" description="Ketika Anda menyelesaikan pembayaran, bukti pembayaran akan muncul di sini."></x-empty-state>
                        @endforelse
                    </div>
                </div>
            </div>

        @elseif($activeResidentTab === 'complaints')
            <!-- COMPLAINTS & REPAIRS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Complaints checklist -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-900">Tiket Perbaikan & Keluhan</h2>
                        <x-badge variant="info">{{ $complaints->count() }} total</x-badge>
                    </div>

                    <div class="space-y-4">
                        @forelse($complaints as $comp)
                            <div class="p-6 bg-white border border-slate-100 rounded-3xl shadow-sm space-y-4">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div>
                                        <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider">{{ $comp->complaint_number }}</span>
                                        <h3 class="text-base font-bold text-slate-800 mt-0.5">{{ $comp->title }}</h3>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 bg-slate-100 rounded text-[10px] font-semibold text-slate-600 uppercase">{{ $comp->category }}</span>
                                        @php
                                            $v = 'neutral';
                                            if($comp->status->value === 'open') $v = 'neutral';
                                            if($comp->status->value === 'assigned') $v = 'info';
                                            if($comp->status->value === 'in_progress') $v = 'warning';
                                            if($comp->status->value === 'completed') $v = 'success';
                                            if($comp->status->value === 'closed') $v = 'neutral';
                                        @endphp
                                        <x-badge :variant="$v">{{ $comp->status->label() }}</x-badge>
                                    </div>
                                </div>

                                <p class="text-sm text-slate-600 leading-relaxed">{{ $comp->description }}</p>

                                <!-- Maintenance details (technician and estimated date) -->
                                @if($comp->maintenanceTask)
                                    <div class="p-3 bg-slate-50 rounded-2xl flex items-center justify-between text-xs">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span class="font-medium text-slate-600">Teknisi telah ditugaskan</span>
                                        </div>
                                        @if($comp->maintenanceTask->estimated_completion_date)
                                            <span class="text-slate-500">Estimasi selesai: {{ date('d M Y', strtotime($comp->maintenanceTask->estimated_completion_date)) }}</span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Chat discussion comments section -->
                                <div class="border-t border-slate-100 pt-4 space-y-4">
                                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Papan Diskusi</h4>
                                    
                                    <!-- List comments -->
                                    <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                                        @forelse($comp->comments->where('is_tenant_visible', true) as $comm)
                                            <div class="p-3 rounded-2xl {{ $comm->resident_id ? 'bg-indigo-50/50 ml-8 border border-indigo-100/40' : 'bg-slate-50 mr-8' }}">
                                                <div class="flex justify-between items-center mb-1">
                                                    <span class="text-xs font-semibold text-slate-700">
                                                        {{ $comm->resident ? $comm->resident->name : ($comm->user ? $comm->user->name : 'Staf') }}
                                                    </span>
                                                    <span class="text-[9px] text-slate-400">
                                                        {{ $comm->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-slate-600">{{ $comm->comment }}</p>
                                            </div>
                                        @empty
                                            <p class="text-[10px] text-slate-400 italic">Belum ada pesan yang dikirim di utas ini.</p>
                                        @endforelse
                                    </div>

                                    <!-- Add comment field -->
                                    <div class="flex gap-2 items-center flex-1">
                                        <input placeholder="Kirim balasan..." class="w-full px-4 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" wire:model.defer="newCommentText" type="text" />
                                        <button wire:click="postComment('{{ $comp->id }}')" 
                                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                                            Kirim
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <x-empty-state title="Tidak ada tiket aktif" description="Anda tidak memiliki tiket keluhan yang diajukan saat ini."></x-empty-state>
                        @endforelse
                    </div>
                </div>

                <!-- Service Guideline rules -->
                <div>
                    <x-card title="Panduan Pengajuan Keluhan">
                        <ul class="text-xs text-slate-500 space-y-2 list-disc list-inside">
                            <li>Periksa masalah secara menyeluruh sebelum mengajukan.</li>
                            <li>Berikan lokasi yang tepat dan jelaskan masalah secara detail.</li>
                            <li>Unggah lampiran jika ada kerusakan fisik.</li>
                            <li>Respon normal biasanya diberikan dalam waktu 24-48 jam.</li>
                            <li>Untuk keadaan darurat listrik/pipa air, segera hubungi staf.</li>
                        </ul>
                    </x-card>
                </div>
            </div>
        @endif
    </div>

    <!-- MODAL: REQUEST CHECKOUT -->
    <x-modal title="Ajukan Permintaan Check-Out" :show="$showCheckOutModal" wire:model="showCheckOutModal">
        <div class="space-y-4">
            <div class="p-3.5 bg-amber-50 border border-amber-200/40 text-amber-800 rounded-2xl text-xs leading-relaxed">
                <strong>Perhatian!</strong> Mengajukan permintaan check-out akan mengubah status profil Anda menjadi <em>Keluar (Moving Out)</em>. Staf kami akan memeriksa kamar Anda, mencatat meteran utilitas akhir, memeriksa kerusakan properti, dan memverifikasi parameter pengembalian deposit.
            </div>
            <p class="text-sm text-slate-600">Apakah Anda yakin ingin mengajukan permintaan check-out untuk kontrak {{ $activeContract ? $activeContract->contract_number : '' }}?</p>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-button variant="outline" wire:click="$set('showCheckOutModal', false)">Batal</x-button>
                <x-button variant="danger" wire:click="submitCheckOut('{{ $activeContract ? $activeContract->id : '' }}')">Konfirmasi Permintaan</x-button>
            </div>
        </x-slot>
    </x-modal>

    <!-- MODAL: NEW COMPLAINT -->
    <x-modal title="Kirim Tiket Perbaikan" :show="$showComplaintModal" wire:model="showComplaintModal">
        <div class="space-y-4 text-left">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5" for="title">Judul / Masalah Singkat</label>
                <input id="title" placeholder="mis. Pipa kamar mandi bocor" wire:model.defer="complaintTitle" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" type="text" />
                @error('complaintTitle') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5" for="category">Kategori</label>
                <select id="category" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800 outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" wire:model.defer="complaintCategory">
                    <option value="general">Masalah Umum</option>
                    <option value="plumbing">Saluran Air / Kebocoran</option>
                    <option value="electrical">Kelistrikan / Kabel</option>
                    <option value="structural">Struktural / Dinding & Langit-langit</option>
                    <option value="furniture">Perbaikan Furnitur</option>
                    <option value="appliance">Pemeliharaan Peralatan</option>
                    <option value="internet">Koneksi Internet / Wi-Fi</option>
                    <option value="other">Masalah Lainnya</option>
                </select>
                @error('complaintCategory') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5" for="desc">Deskripsi Detail</label>
                <textarea id="desc" rows="4" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800 outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" placeholder="Jelaskan secara rinci kerusakan yang terjadi, kapan hal itu terjadi, dan bagaimana kami bisa mengakses kamar Anda..." wire:model.defer="complaintDescription"></textarea>
                @error('complaintDescription') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-button variant="outline" wire:click="$set('showComplaintModal', false)">Batal</x-button>
                <x-button variant="primary" wire:click="submitComplaint">Kirim Tiket</x-button>
            </div>
        </x-slot>
    </x-modal>

    <!-- MODAL: PAY INVOICE / UPLOAD RECEIPT -->
    <x-modal title="Unggah Bukti Transfer Bank" :show="$showPaymentModal" wire:model="showPaymentModal">
        <div class="space-y-4 text-left">
            <div class="p-3 bg-slate-50 rounded-xl text-xs space-y-1">
                <p class="font-semibold text-slate-700">Detail Rekening Bank untuk Transfer:</p>
                <p class="text-slate-600">Bank Central Asia (BCA) &bull; <span class="font-mono">8293740122</span></p>
                <p class="text-slate-600">A/N Manajemen Kos</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5" for="ref">Nomor Referensi Transfer Bank</label>
                <input id="ref" placeholder="mis. BCA-TRF-9821" wire:model.defer="paymentReferenceNumber" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" type="text" />
                @error('paymentReferenceNumber') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5" for="proof">Unggah Foto Bukti Transfer</label>
                <input id="proof" type="file" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer" wire:model="paymentProofFile" />
                @error('paymentProofFile') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-button variant="outline" wire:click="$set('showPaymentModal', false)">Batal</x-button>
                <x-button variant="primary" wire:click="uploadPaymentProof" wire:loading.attr="disabled">
                    Unggah Bukti
                </x-button>
            </div>
        </x-slot>
    </x-modal>
</div>
