<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    
    <!-- LEFT: Settings Sidebar Categories Navigation -->
    <div class="space-y-4">
        <!-- Search -->
        <div class="bg-white border border-slate-100 rounded-3xl p-4 shadow-sm">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Cari Konfigurasi</span>
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <x-input type="text" wire:model.live.debounce.250ms="search" placeholder="Cari pengaturan..." class="w-full pl-9 text-xs" />
            </div>
        </div>

        <!-- Sticky Tab selectors -->
        <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-1">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-3">Kategori</span>
            
            @php
                $tabs = [
                    'general' => 'Pengaturan Umum',
                    'localization' => 'Lokalisasi',
                    'email' => 'Server Email (SMTP)',
                    'notifications' => 'Notifikasi',
                    'payments' => 'Gateway Pembayaran',
                    'storage' => 'Penyimpanan & Batas',
                    'security' => 'Keamanan & Autentikasi',
                    'cache' => 'Cache & Tuning',
                    'scheduler' => 'Penjadwal Tugas',
                    'integrations' => 'API & Integrasi',
                    'diagnostics' => 'Spesifikasi Sistem',
                    'audits' => 'Audit Perubahan',
                ];
            @endphp

            @foreach($tabs as $key => $label)
                @if(empty($search) || str_contains(strtolower($label), strtolower($search)))
                    <button wire:click="$set('activeTab', '{{ $key }}')" class="w-full text-left px-3 py-2 text-xs font-semibold rounded-xl transition cursor-pointer flex items-center gap-2
                        {{ $activeTab === $key ? 'bg-indigo-50 text-indigo-650' : 'text-slate-600 hover:bg-slate-50' }}
                    ">
                        {{ $label }}
                    </button>
                @endif
            @endforeach
        </div>
    </div>

    <!-- RIGHT: Form categories editor details -->
    <div class="lg:col-span-3 space-y-6">
        
        <!-- GENERAL SETTINGS TAB -->
        @if($activeTab === 'general')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Pengaturan umum platform</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Konfigurasikan penamaan utama, logo, dan informasi alamat.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-label for="platform_name">Label Platform</x-label>
                        <x-input id="platform_name" type="text" wire:model="settingsData.platform_name" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="app_name">Nama Sistem Aplikasi</x-label>
                        <x-input id="app_name" type="text" wire:model="settingsData.app_name" class="w-full mt-1.5" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-label for="company_name">Nama Perusahaan Induk</x-label>
                        <x-input id="company_name" type="text" wire:model="settingsData.company_name" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="country">Negara Asal</x-label>
                        <x-input id="country" type="text" wire:model="settingsData.country" placeholder="Indonesia" class="w-full mt-1.5" />
                    </div>
                </div>

                <div>
                    <x-label for="business_address">Alamat Kantor Pusat</x-label>
                    <textarea id="business_address" wire:model="settingsData.business_address" rows="3" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Simpan Info Umum
                    </button>
                </div>
            </div>
        @endif

        <!-- LOCALIZATION TAB -->
        @if($activeTab === 'localization')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Parameter Lokalisasi</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Kelola zona waktu sistem, mata uang yang didukung, dan format tanggal.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-label for="default_language">Bahasa Platform</x-label>
                        <select id="default_language" wire:model="settingsData.default_language" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="en">English (US)</option>
                            <option value="id">Bahasa Indonesia</option>
                        </select>
                    </div>
                    <div>
                        <x-label for="default_timezone">Zona Waktu Default Sistem</x-label>
                        <x-input id="default_timezone" type="text" wire:model="settingsData.default_timezone" placeholder="Asia/Jakarta" class="w-full mt-1.5" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-label for="currency">Mata Uang Pembayaran Aktif</x-label>
                        <x-input id="currency" type="text" wire:model="settingsData.currency" placeholder="IDR" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="date_format">Format Tanggal Kanonis</x-label>
                        <select id="date_format" wire:model="settingsData.date_format" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm">
                            <option value="Y-m-d">YYYY-MM-DD</option>
                            <option value="d/m/Y">DD/MM/YYYY</option>
                            <option value="F j, Y">Month DD, YYYY</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Simpan Lokalisasi
                    </button>
                </div>
            </div>
        @endif

        <!-- EMAIL / SMTP TAB -->
        @if($activeTab === 'email')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Konfigurasi Server Email</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Atur server pengiriman SMTP. Kredensial dienkripsi pada penyimpanan.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <x-label for="mail_driver">Tipe Driver</x-label>
                        <x-input id="mail_driver" type="text" wire:model="settingsData.mail_driver" class="w-full mt-1.5" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-label for="smtp_host">Alamat Host SMTP</x-label>
                        <x-input id="smtp_host" type="text" wire:model="settingsData.smtp_host" placeholder="smtp.mailgun.org" class="w-full mt-1.5" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <x-label for="smtp_port">Port TCP Server</x-label>
                        <x-input id="smtp_port" type="text" wire:model="settingsData.smtp_port" placeholder="587" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="smtp_encryption">Protokol Enkripsi</x-label>
                        <x-input id="smtp_encryption" type="text" wire:model="settingsData.smtp_encryption" placeholder="tls" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="smtp_username">Username SMTP</x-label>
                        <x-input id="smtp_username" type="text" wire:model="settingsData.smtp_username" class="w-full mt-1.5" />
                    </div>
                </div>

                <!-- Password with Toggle visibility -->
                <div class="space-y-1.5">
                    <x-label for="smtp_password">Kata Sandi Server SMTP</x-label>
                    <div class="relative w-full">
                        <x-input id="smtp_password" type="{{ ($visibility['smtp_password'] ?? false) ? 'text' : 'password' }}" wire:model="settingsData.smtp_password" class="w-full pr-10" />
                        <button type="button" wire:click="toggleVisibility('smtp_password')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-650 cursor-pointer">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="sender_name">Nama Pengirim</x-label>
                        <x-input id="sender_name" type="text" wire:model="settingsData.sender_name" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="sender_address">Alamat Email Pengirim</x-label>
                        <x-input id="sender_address" type="email" wire:model="settingsData.sender_address" class="w-full mt-1.5" />
                    </div>
                </div>

                <!-- Test Connection Panel -->
                <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex flex-col sm:flex-row items-end gap-3 justify-between">
                    <div class="w-full sm:max-w-xs">
                        <x-label for="testEmail">Kirim Uji Coba SMTP</x-label>
                        <x-input id="testEmail" type="email" wire:model="testEmailAddress" class="w-full mt-1.5 bg-white text-xs" />
                    </div>
                    <button type="button" wire:click="sendTestEmail" class="py-2.5 px-4 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl text-xs transition cursor-pointer">
                        Kirim Email Uji Coba
                    </button>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Simpan Pengaturan SMTP
                    </button>
                </div>
            </div>
        @endif

        <!-- NOTIFICATION CHANNELS TAB -->
        @if($activeTab === 'notifications')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Jalur Pengiriman Notifikasi Aktif</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Kelola pengiriman notifikasi secara global.</p>
                </div>

                <div class="space-y-4">
                    <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 cursor-pointer">
                        <input type="checkbox" wire:model="settingsData.enable_email_notifications" class="rounded border-slate-200 text-indigo-600 focus:ring-indigo-500" />
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Notifikasi Email Tagihan</span>
                            <span class="text-[10px] text-slate-400">Kirim kuitansi transaksi dan catatan check-out kepada penyewa.</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 cursor-pointer">
                        <input type="checkbox" wire:model="settingsData.enable_db_notifications" class="rounded border-slate-200 text-indigo-600 focus:ring-indigo-500" />
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Log Pesan Internal Database</span>
                            <span class="text-[10px] text-slate-400">Catat notifikasi ke dalam pusat notifikasi internal aplikasi.</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 cursor-pointer">
                        <input type="checkbox" wire:model="settingsData.enable_whatsapp_notifications" class="rounded border-slate-200 text-indigo-600 focus:ring-indigo-500" />
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Jalur Pengiriman OTP WhatsApp (Persiapan)</span>
                            <span class="text-[10px] text-slate-400">Siapkan webhook dinamis untuk pengiriman ke portal pesan WhatsApp.</span>
                        </div>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Simpan Jalur Notifikasi
                    </button>
                </div>
            </div>
        @endif

        <!-- PAYMENT GATEWAYS TAB -->
        @if($activeTab === 'payments')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Integrasi Pembayaran Aktif</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Konfigurasikan kredensial gateway untuk Midtrans, Xendit, dan Stripe.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="payment_mode">Mode Gateway</x-label>
                        <select id="payment_mode" wire:model="settingsData.payment_mode" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm">
                            <option value="sandbox">Sandbox (Testing)</option>
                            <option value="production">Production (Live)</option>
                        </select>
                    </div>
                </div>

                <div class="border-t border-slate-50 pt-5 space-y-4">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Midtrans Indonesia</span>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="midtrans_merchant_id">Merchant ID</x-label>
                            <x-input id="midtrans_merchant_id" type="text" wire:model="settingsData.midtrans_merchant_id" class="w-full mt-1.5" />
                        </div>
                        <div>
                            <x-label for="midtrans_client_key">Client Key Token</x-label>
                            <div class="relative w-full mt-1.5">
                                <x-input id="midtrans_client_key" type="{{ ($visibility['midtrans_client_key'] ?? false) ? 'text' : 'password' }}" wire:model="settingsData.midtrans_client_key" class="w-full pr-10" />
                                <button type="button" wire:click="toggleVisibility('midtrans_client_key')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-50 pt-5 space-y-4">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Stripe Gateway</span>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-label for="stripe_publishable_key">Stripe Publishable Key</x-label>
                            <x-input id="stripe_publishable_key" type="text" wire:model="settingsData.stripe_publishable_key" class="w-full mt-1.5" />
                        </div>
                        <div>
                            <x-label for="stripe_secret">Stripe API Secret</x-label>
                            <div class="relative w-full mt-1.5">
                                <x-input id="stripe_secret" type="{{ ($visibility['stripe_secret'] ?? false) ? 'text' : 'password' }}" wire:model="settingsData.stripe_secret" class="w-full pr-10" />
                                <button type="button" wire:click="toggleVisibility('stripe_secret')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Simpan Kunci Gateway
                    </button>
                </div>
            </div>
        @endif

        <!-- STORAGE SETTINGS TAB -->
        @if($activeTab === 'storage')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Driver Penyimpanan Aktif</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Kelola tujuan unggahan file dan batas kompresi.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="storage_driver">Driver Penyimpanan File</x-label>
                        <select id="storage_driver" wire:model="settingsData.storage_driver" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm">
                            <option value="local">Disk Keras Lokal</option>
                            <option value="s3">Penyimpanan Objek Amazon S3</option>
                            <option value="gcs">Penyimpanan Google Cloud</option>
                        </select>
                    </div>
                    <div>
                        <x-label for="max_upload_size">Batas Unggahan Maksimum (MB)</x-label>
                        <x-input id="max_upload_size" type="number" wire:model="settingsData.max_upload_size" placeholder="10" class="w-full mt-1.5" />
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Simpan Driver Penyimpanan
                    </button>
                </div>
            </div>
        @endif

        <!-- SECURITY TAB -->
        @if($activeTab === 'security')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Kebijakan Keamanan &amp; Sesi</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Konfigurasikan persyaratan kompleksitas autentikasi.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="session_timeout">Batas Waktu Sesi Tidak Aktif (Menit)</x-label>
                        <x-input id="session_timeout" type="number" wire:model="settingsData.session_timeout" placeholder="120" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="password_policy">Ambang Batas Kompleksitas Kata Sandi</x-label>
                        <select id="password_policy" wire:model="settingsData.password_policy" class="mt-1.5 block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm">
                            <option value="normal">Standar (Min 8 Karakter)</option>
                            <option value="strict">Ketat (Wajib campuran huruf besar/kecil, angka, simbol khusus)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Simpan Kebijakan Keamanan
                    </button>
                </div>
            </div>
        @endif

        <!-- CACHE & TUNING TAB -->
        @if($activeTab === 'cache')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Parameter Penyetelan Cache</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Kelola nilai cache performa sistem.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="cache_driver">Penyimpanan Cache Penyetelan</x-label>
                        <x-input id="cache_driver" type="text" wire:model="settingsData.cache_driver" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="cache_ttl">Durasi Cache Standar (Detik)</x-label>
                        <x-input id="cache_ttl" type="number" wire:model="settingsData.cache_ttl" placeholder="3600" class="w-full mt-1.5" />
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-955 block">Kontrol Operasi Cache</span>
                        <span class="text-[10px] text-slate-400">Hapus semua catatan cache secara instan untuk merefleksikan pembaruan.</span>
                    </div>
                    <button type="button" wire:click="clearCache" class="py-2 px-3.5 bg-rose-50 border border-rose-100 text-rose-700 font-bold rounded-xl text-xs hover:bg-rose-100 transition cursor-pointer">
                        Bersihkan Cache
                    </button>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Simpan Pengaturan Cache
                    </button>
                </div>
            </div>
        @endif

        <!-- JOB SCHEDULER TAB -->
        @if($activeTab === 'scheduler')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Crontab Penjadwal</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Atur pemicu jadwal berulang dalam ekspresi cron.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="billing_cron">Jadwal Pembuatan Faktur Sewa</x-label>
                        <x-input id="billing_cron" type="text" wire:model="settingsData.billing_cron" placeholder="0 0 1 * *" class="w-full mt-1.5 font-mono text-xs" />
                    </div>
                    <div>
                        <x-label for="reminder_cron">Pemicu Pengingat Sewa</x-label>
                        <x-input id="reminder_cron" type="text" wire:model="settingsData.reminder_cron" placeholder="0 9 * * *" class="w-full mt-1.5 font-mono text-xs" />
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Simpan Jadwal Cron
                    </button>
                </div>
            </div>
        @endif

        <!-- APIS & INTEGRATIONS TAB -->
        @if($activeTab === 'integrations')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Integrasi &amp; Kredensial</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Konfigurasikan token Google, reCAPTCHA, dan WhatsApp.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-label for="google_analytics_id">Google Analytics UA/G-ID</x-label>
                        <x-input id="google_analytics_id" type="text" wire:model="settingsData.google_analytics_id" placeholder="G-XXXXXXXX" class="w-full mt-1.5" />
                    </div>
                    <div>
                        <x-label for="recaptcha_site_key">Google reCAPTCHA Site Key</x-label>
                        <x-input id="recaptcha_site_key" type="text" wire:model="settingsData.recaptcha_site_key" class="w-full mt-1.5" />
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="saveSettings" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Simpan Kunci Integrasi
                    </button>
                </div>
            </div>
        @endif

        <!-- DIAGNOSTICS TAB -->
        @if($activeTab === 'diagnostics')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Spesifikasi &amp; Diagnostik Platform</h3>
                    <p class="text-xs text-slate-450 mt-0.5 leading-normal">Indikator waktu nyata dari paket runtime.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Versi Laravel</span>
                        <span class="text-lg font-bold text-slate-900 mt-1 block">{{ $laravelVersion }}</span>
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Runtime PHP</span>
                        <span class="text-lg font-bold text-slate-900 mt-1 block">{{ $phpVersion }}</span>
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Ping Cache Redis</span>
                        <span class="text-xs font-bold mt-1.5 flex items-center gap-1.5
                            {{ $redisStatus === 'Connected' ? 'text-emerald-700' : 'text-rose-700' }}
                        ">
                            <span class="h-2 w-2 rounded-full {{ $redisStatus === 'Connected' ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                            {{ $redisStatus }}
                        </span>
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Koneksi Antrean</span>
                        <span class="text-xs font-bold text-emerald-700 mt-1.5 flex items-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            {{ $queueStatus }}
                        </span>
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Daemon Cron</span>
                        <span class="text-xs font-bold text-emerald-700 mt-1.5 flex items-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            {{ $schedulerStatus }}
                        </span>
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Ukuran Disk Lokal</span>
                        <span class="text-sm font-black text-slate-955 mt-1.5 block">{{ $storageUsage }}</span>
                    </div>
                </div>

                <!-- Export/Import Actions -->
                <div class="pt-6 border-t border-slate-100 space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Impor / Ekspor Konfigurasi</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-5 border border-slate-150 bg-slate-50/50 rounded-2xl space-y-3">
                            <span class="text-xs font-bold text-slate-900 block">Ekspor JSON Pengaturan</span>
                            <p class="text-[10px] text-slate-400">Unduh dump pengaturan ter-serialisasi penuh yang mewakili nilai kunci saat ini.</p>
                            <button type="button" wire:click="exportConfig" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition cursor-pointer">
                                Ekspor File Konfigurasi
                            </button>
                        </div>

                        <div class="p-5 border border-slate-150 bg-slate-50/50 rounded-2xl space-y-3">
                            <span class="text-xs font-bold text-slate-900 block">Impor JSON Pengaturan</span>
                            <p class="text-[10px] text-slate-400">Unggah file templat konfigurasi untuk menerapkan perubahan pengaturan.</p>
                            
                            <div class="flex items-center gap-3">
                                <input type="file" wire:model="importFile" class="text-xs text-slate-500" />
                                @if($importFile)
                                    <button type="button" wire:click="importConfig" class="px-3 py-1.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 cursor-pointer">
                                        Import
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- CHANGE AUDITS TAB -->
        @if($activeTab === 'audits')
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 tracking-tight">Log aktivitas pengaturan konfigurasi</h3>
                        <p class="text-xs text-slate-450 mt-0.5 leading-normal">Catatan kronologis perubahan pengaturan sistem.</p>
                    </div>
                    <button type="button" wire:click="clearAudits" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold cursor-pointer">
                        Bersihkan Log
                    </button>
                </div>

                <div class="border border-slate-100 rounded-2xl overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                        <thead class="bg-slate-50 text-slate-450 font-bold uppercase text-[9px] tracking-wider">
                            <tr>
                                <th class="px-5 py-3">Timestamp</th>
                                <th class="px-5 py-3">Operator</th>
                                <th class="px-5 py-3">Setting Key</th>
                                <th class="px-5 py-3">Changes (Old &rarr; New)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-slate-650 font-medium">
                            @forelse($audits as $audit)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-5 py-3 text-slate-450 text-[10px] whitespace-nowrap">
                                        {{ $audit->created_at->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td class="px-5 py-3 font-semibold text-slate-800">
                                        {{ $audit->user ? $audit->user->name : 'System Scheduler' }}
                                    </td>
                                    <td class="px-5 py-3 font-mono text-[11px] text-indigo-650">
                                        {{ $audit->properties['key'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-5 py-3 space-y-1">
                                        <div class="flex items-center gap-1.5">
                                            <span class="px-1.5 py-0.5 rounded bg-rose-50 text-rose-700 font-mono text-[10px] max-w-[120px] truncate">{{ $audit->properties['old_value'] ?? 'None' }}</span>
                                            <span class="text-slate-400">&rarr;</span>
                                            <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 font-mono text-[10px] max-w-[120px] truncate">{{ $audit->properties['new_value'] ?? 'None' }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-slate-400 italic">Tidak ada modifikasi pengaturan yang tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>
