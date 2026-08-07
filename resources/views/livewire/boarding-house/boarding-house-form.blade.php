<div class="space-y-6" x-data="{ activeTab: @entangle('activeTab') }">
    
    <!-- Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ $boardingHouseId ? 'Ubah Properti: ' . $name : 'Daftarkan Rumah Kos' }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">Konfigurasikan detail profil, koordinat peta, kebijakan operasional, fasilitas, aturan, dan aset gambar.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="outline" size="sm" onclick="window.location.href='{{ route('boarding-houses') }}'">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar
                </span>
            </x-button>
        </div>
    </div>

    <!-- Wizard Tabs -->
    @if($boardingHouseId)
        <div class="border-b border-slate-100 flex flex-wrap gap-2 mb-6">
            <button @click="activeTab = 'profile'" :class="{'border-indigo-600 text-indigo-600': activeTab === 'profile', 'border-transparent text-slate-500 hover:text-slate-700': activeTab !== 'profile'}"
                class="px-4 py-2.5 text-sm font-semibold border-b-2 transition cursor-pointer">Profil</button>
            <button @click="activeTab = 'settings'" :class="{'border-indigo-600 text-indigo-600': activeTab === 'settings', 'border-transparent text-slate-500 hover:text-slate-700': activeTab !== 'settings'}"
                class="px-4 py-2.5 text-sm font-semibold border-b-2 transition cursor-pointer">Pengaturan</button>
            <button @click="activeTab = 'facilities'" :class="{'border-indigo-600 text-indigo-600': activeTab === 'facilities', 'border-transparent text-slate-500 hover:text-slate-700': activeTab !== 'facilities'}"
                class="px-4 py-2.5 text-sm font-semibold border-b-2 transition cursor-pointer">Fasilitas</button>
            <button @click="activeTab = 'rules'" :class="{'border-indigo-600 text-indigo-600': activeTab === 'rules', 'border-transparent text-slate-500 hover:text-slate-700': activeTab !== 'rules'}"
                class="px-4 py-2.5 text-sm font-semibold border-b-2 transition cursor-pointer">Aturan Kos</button>
            <button @click="activeTab = 'gallery'" :class="{'border-indigo-600 text-indigo-600': activeTab === 'gallery', 'border-transparent text-slate-500 hover:text-slate-700': activeTab !== 'gallery'}"
                class="px-4 py-2.5 text-sm font-semibold border-b-2 transition cursor-pointer">Galeri Gambar</button>
        </div>
    @endif

    <!-- Content Sections -->

    <!-- Section 1: Profile -->
    <div x-show="activeTab === 'profile'" class="space-y-6">
        <x-card title="Profil Properti &amp; Geolokasi" description="Berikan identitas umum, detail kontak, dan koordinat untuk layanan geolokasi.">
            <form wire:submit="saveProfile" class="space-y-5">
                
                <!-- Logo & Cover Upload -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-4 border-b border-slate-50">
                    <!-- Logo Upload -->
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <img class="h-16 w-16 rounded-xl object-cover bg-slate-100 border border-slate-200" 
                                 src="{{ $logoUpload ? $logoUpload->temporaryUrl() : ($boardingHouse && $boardingHouse->logo ? asset('storage/' . $boardingHouse->logo) : asset('assets/images/logos/default_logo.png')) }}">
                            <label for="logo_up" class="absolute -bottom-1.5 -right-1.5 p-1 bg-indigo-600 text-white rounded-lg shadow cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                            </label>
                            <input type="file" id="logo_up" class="hidden" wire:model="logoUpload" accept="image/*">
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-700">Logo Ruang Kerja</h4>
                            <p class="text-[10px] text-slate-400">Format persegi PNG atau JPG hingga 1MB.</p>
                            @error('logoUpload') <span class="text-xs text-rose-500 block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Cover Upload -->
                    <div class="flex items-center gap-4">
                        <div class="relative w-28 h-16 bg-slate-100 border border-slate-200 rounded-xl overflow-hidden">
                            <img class="w-full h-full object-cover" 
                                 src="{{ $coverUpload ? $coverUpload->temporaryUrl() : ($boardingHouse && $boardingHouse->cover_image ? asset('storage/' . $boardingHouse->cover_image) : asset('assets/images/property/default_cover.png')) }}">
                            <label for="cover_up" class="absolute bottom-1 right-1 p-1 bg-indigo-600 text-white rounded-lg shadow cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                            </label>
                            <input type="file" id="cover_up" class="hidden" wire:model="coverUpload" accept="image/*">
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-700">Gambar Sampul</h4>
                            <p class="text-[10px] text-slate-400">Banner horizontal JPG hingga 2MB.</p>
                            @error('coverUpload') <span class="text-xs text-rose-500 block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Properti</label>
                        <input wire:model="name" type="text" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                            placeholder="cth. Kosan Eksklusif Cihampelas">
                        @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor WhatsApp (Kontak)</label>
                        <input wire:model="whatsapp_number" type="text" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                            placeholder="cth. 08123456789">
                        @error('whatsapp_number') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Email</label>
                        <input wire:model="email" type="email"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                            placeholder="kontak@properti.com">
                        @error('email') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
                            <select wire:model="status"
                                class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                                <option value="active">Aktif</option>
                                <option value="full">Penuh</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Visibilitas</label>
                            <select wire:model="is_public"
                                class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                                <option value="1">Publik (Tampilkan di situs)</option>
                                <option value="0">Privat (Hanya ruang kerja)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi / Tentang</label>
                    <textarea wire:model="description" rows="3"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="Tulis deskripsi dinamis tentang konfigurasi kamar, lingkungan sekitar, objek terdekat..."></textarea>
                </div>

                <!-- Geolocation details -->
                <div class="pt-4 border-t border-slate-50 space-y-4">
                    <h4 class="text-sm font-bold text-slate-700">Alamat &amp; Koordinat</h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Provinsi</label>
                            <input wire:model="province" type="text" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="Jawa Barat">
                            @error('province') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Kota/Kabupaten</label>
                            <input wire:model="city" type="text" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="Bandung">
                            @error('city') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Kode Pos</label>
                            <input wire:model="postal_code" type="text" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="40131">
                            @error('postal_code') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Detail Alamat Lengkap (Jalan, nomor rumah)</label>
                            <input wire:model="address" type="text" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="Jl. Cihampelas No. 120">
                            @error('address') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Kecamatan</label>
                            <input wire:model="district" type="text" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="Coblong">
                            @error('district') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Latitude</label>
                            <input wire:model.live.debounce.300ms="latitude" type="text" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="cth. -6.890456">
                            @error('latitude') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Longitude</label>
                            <input wire:model.live.debounce.300ms="longitude" type="text" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="cth. 107.610456">
                            @error('longitude') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Maps Embedded Preview -->
                    @if($latitude && $longitude)
                        <div class="mt-4">
                            <iframe class="w-full h-48 rounded-xl border border-slate-100" 
                                    src="https://maps.google.com/maps?q={{ $latitude }},{{ $longitude }}&z=15&output=embed" 
                                    allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-50">
                    <x-button type="submit" variant="primary" size="sm" loading="saveProfile">
                        {{ $boardingHouseId ? 'Simpan Perubahan Profil' : 'Daftarkan Profil &amp; Lanjutkan' }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>

    <!-- Section 2: Settings -->
    <div x-show="activeTab === 'settings'" class="space-y-6">
        <x-card title="Pengaturan Operasional &amp; Konfigurasi Tagihan" description="Tetapkan aturan untuk waktu akses kamar, sistem tagihan, dan parameter saluran pembayaran.">
            <form wire:submit="saveSettings" class="space-y-5">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Waktu Check-in</label>
                        <input wire:model="check_in_time" type="time" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Waktu Check-out</label>
                        <input wire:model="check_out_time" type="time" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Jatuh Tempo Tagihan Bulanan</label>
                        <select wire:model="billing_due_day" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm">
                            @for($i = 1; $i <= 28; $i++)
                                <option value="{{ $i }}">Tanggal {{ $i }} setiap bulan</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Metode Pembayaran yang Diterima</label>
                        <div class="space-y-2 mt-2">
                            <label class="flex items-center text-sm text-slate-700">
                                <input type="checkbox" wire:model="accepted_payment_channels" value="cash" class="h-4 w-4 rounded border-slate-355 text-indigo-600 focus:ring-indigo-500 mr-2"> Pembayaran Tunai
                            </label>
                            <label class="flex items-center text-sm text-slate-700">
                                <input type="checkbox" wire:model="accepted_payment_channels" value="bank_transfer" class="h-4 w-4 rounded border-slate-355 text-indigo-600 focus:ring-indigo-500 mr-2"> Transfer Bank (Verifikasi Manual)
                            </label>
                            <label class="flex items-center text-sm text-slate-700">
                                <input type="checkbox" wire:model="accepted_payment_channels" value="virtual_account" class="h-4 w-4 rounded border-slate-355 text-indigo-600 focus:ring-indigo-500 mr-2"> Virtual Account (Integrasi gateway Midtrans/Xendit)
                            </label>
                            <label class="flex items-center text-sm text-slate-700">
                                <input type="checkbox" wire:model="accepted_payment_channels" value="e_wallet" class="h-4 w-4 rounded border-slate-355 text-indigo-600 focus:ring-indigo-500 mr-2"> E-Wallet (OVO, GoPay, ShopeePay)
                            </label>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Prefiks Nomor Faktur</label>
                            <input wire:model="invoice_prefix" type="text" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="INV-KOS">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Pengaturan Mata Uang</label>
                            <select wire:model="currency" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm">
                                <option value="IDR">Rupiah (IDR)</option>
                                <option value="USD">US Dollar ($)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan Kaki Faktur Default</label>
                    <textarea wire:model="invoice_notes" rows="2" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="Catatan faktur yang dicetak pada tagihan PDF..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Kebijakan Pemesanan / Deposit Keamanan</label>
                        <textarea wire:model="booking_policy" rows="3" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="Ketentuan untuk reservasi kamar..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Kebijakan Pembatalan</label>
                        <textarea wire:model="cancellation_policy" rows="3" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="Panduan kebijakan pengembalian dana..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-50">
                    <x-button type="submit" variant="primary" size="sm" loading="saveSettings">Simpan Konfigurasi</x-button>
                </div>
            </form>
        </x-card>
    </div>

    <!-- Section 3: Facilities -->
    <div x-show="activeTab === 'facilities'" class="space-y-6">
        <x-card title="Pemetaan Fasilitas Properti" description="Tetapkan fasilitas umum untuk rumah kos ini. Pilih 'Unggulan' untuk menampilkannya pada daftar halaman publik.">
            <form wire:submit="saveFacilities" class="space-y-6">
                
                @php
                    $groupedFacilities = $allFacilities->groupBy('category');
                @endphp

                @forelse($groupedFacilities as $categoryName => $facilitiesList)
                    <div class="space-y-3">
                        <h4 class="text-sm font-bold text-slate-700 border-b border-slate-50 pb-2">Fasilitas {{ $categoryName }}</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($facilitiesList as $facilityItem)
                                <div class="flex items-start justify-between p-3 border border-slate-100 rounded-xl bg-slate-50/30">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" wire:model="selectedFacilities" value="{{ $facilityItem->id }}"
                                            id="fac_{{ $facilityItem->id }}"
                                            class="h-4.5 w-4.5 rounded border-slate-350 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                        <label for="fac_{{ $facilityItem->id }}" class="text-sm text-slate-700 font-semibold cursor-pointer select-none">
                                            {{ $facilityItem->name }}
                                        </label>
                                    </div>
                                    
                                    <!-- Highlight / Feature option (only enabled if facility is checked) -->
                                    @if(in_array((string)$facilityItem->id, $selectedFacilities))
                                        <label class="flex items-center gap-1 text-[10px] font-bold text-amber-600 cursor-pointer select-none">
                                            <input type="checkbox" wire:model="featuredFacilities" value="{{ $facilityItem->id }}"
                                                class="h-3.5 w-3.5 rounded border-amber-350 text-amber-500 focus:ring-amber-500">
                                            Unggulan
                                        </label>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <x-empty-state title="Tidak ada fasilitas aktif yang ditemukan" description="Buka Katalog Fasilitas Ruang Kerja untuk membuat fasilitas sebelum menghubungkannya ke profil properti."></x-empty-state>
                @endforelse

                <div class="flex justify-end pt-4 border-t border-slate-50">
                    <x-button type="submit" variant="primary" size="sm" loading="saveFacilities">Sinkronisasikan Fasilitas</x-button>
                </div>
            </form>
        </x-card>
    </div>

    <!-- Section 4: Rules -->
    <div x-show="activeTab === 'rules'" class="space-y-6">
        <x-card title="Aturan Kos &amp; Kurator" description="Buat kategori khusus aturan kos untuk kamar, panduan pengunjung, dan peraturan jam malam.">
            <x-slot name="headerActions">
                <x-button variant="primary" size="sm" wire:click="openAddRuleModal">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Aturan
                    </span>
                </x-button>
            </x-slot>

            <x-table :headers="['Urutan', 'Kategori', 'Judul Aturan', 'Publik', 'Aktif', 'Aksi']">
                @forelse($rulesList as $ruleItem)
                    <tr class="hover:bg-slate-50/50 transition">
                        <!-- Sorting Order -->
                        <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-400">
                            <div class="flex items-center gap-1">
                                <button wire:click="moveRuleUp({{ $ruleItem->id }})" class="p-1 text-slate-450 hover:bg-slate-100 rounded transition cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                </button>
                                <button wire:click="moveRuleDown({{ $ruleItem->id }})" class="p-1 text-slate-450 hover:bg-slate-100 rounded transition cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <span class="ml-1.5">{{ $ruleItem->display_order }}</span>
                            </div>
                        </td>

                        <!-- Category -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $ruleItem->category }}
                        </td>

                        <!-- Title & Description -->
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-800">{{ $ruleItem->title }}</p>
                            @if($ruleItem->description)
                                <p class="text-xs text-slate-400 truncate max-w-sm mt-0.5">{{ $ruleItem->description }}</p>
                            @endif
                        </td>

                        <!-- Public Visibility -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-badge :variant="$ruleItem->is_visible_public ? 'info' : 'neutral'">
                                {{ $ruleItem->is_visible_public ? 'Publik' : 'Privat' }}
                            </x-badge>
                        </td>

                        <!-- Active status -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-badge :variant="$ruleItem->is_active ? 'success' : 'danger'">
                                {{ $ruleItem->is_active ? 'Aktif' : 'Nonaktif' }}
                            </x-badge>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 transition cursor-pointer" wire:click="editRule({{ $ruleItem->id }})" title="Ubah Aturan" aria-label="Ubah Aturan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </x-button>
                                <x-button variant="outline" size="sm" class="inline-flex items-center justify-center p-2 rounded-xl text-rose-600 border border-slate-200 hover:border-rose-100 hover:bg-rose-50 cursor-pointer" wire:click="deleteRule({{ $ruleItem->id }})" title="Hapus Aturan" aria-label="Hapus Aturan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </x-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-0">
                            <x-empty-state title="Belum ada aturan kos yang dibuat" description="Buat aturan khusus properti untuk parkir, kebijakan hewan peliharaan, jam tenang pengunjung, dan batas jam malam."></x-empty-state>
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </x-card>
    </div>

    <!-- Section 5: Gallery -->
    <div x-show="activeTab === 'gallery'" class="space-y-6">
        <x-card title="Galeri Media Properti" description="Unggah beberapa foto rumah kos berkualitas tinggi. Pilih file sampul dan atur keterangan visual yang jelas.">
            
            <!-- Uploader Form -->
            <form wire:submit="uploadGalleryImage" class="space-y-4 pb-6 border-b border-slate-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-end">
                    
                    <!-- File input -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Unggah Gambar</label>
                        <input type="file" wire:model="galleryUpload" accept="image/*"
                            class="w-full px-4 py-2 bg-slate-50/50 border border-slate-255 border-dashed rounded-xl text-slate-500 text-sm focus:outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-650 file:cursor-pointer">
                        @error('galleryUpload') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Label -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Keterangan Gambar</label>
                        <div class="flex items-center gap-2">
                            <input wire:model="galleryLabel" type="text" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="cth. Tampak Depan, Kamar Deluxe">
                            <x-button variant="primary" size="sm" type="submit" loading="uploadGalleryImage">Unggah</x-button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Previews Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 mt-6">
                @forelse($galleryList as $galleryItem)
                    <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm flex flex-col group relative">
                        <div class="h-32 bg-slate-50 relative">
                            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $galleryItem->file_path) }}" alt="{{ $galleryItem->label }}">
                            
                            <!-- Cover Flag Badge -->
                            @if($galleryItem->is_cover)
                                <div class="absolute top-2 left-2">
                                    <x-badge variant="success" class="text-[8px] uppercase font-bold py-0.5 px-2">Sampul</x-badge>
                                </div>
                            @endif

                            <!-- Display Order Controls overlay -->
                            <div class="absolute top-2 right-2 flex gap-1">
                                <button wire:click="moveGalleryUp({{ $galleryItem->id }})" class="p-1 bg-white/90 text-slate-650 rounded shadow hover:bg-white cursor-pointer transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                </button>
                                <button wire:click="moveGalleryDown({{ $galleryItem->id }})" class="p-1 bg-white/90 text-slate-650 rounded shadow hover:bg-white cursor-pointer transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="p-3 flex-1 flex flex-col justify-between gap-3">
                            <p class="text-xs font-semibold text-slate-700 truncate">
                                {{ $galleryItem->label ?: 'Tidak ada keterangan' }}
                            </p>
                            
                            <div class="flex items-center gap-1.5">
                                @if(!$galleryItem->is_cover)
                                    <x-button variant="outline" size="sm" class="w-full py-1! text-[10px] font-bold" wire:click="setAsCover({{ $galleryItem->id }})">Jadikan Sampul</x-button>
                                @endif
                                <x-button variant="outline" size="sm" class="py-1! px-2! text-[10px] text-rose-600 hover:bg-rose-50 border-slate-200 hover:border-rose-100 cursor-pointer" wire:click="deleteGalleryImage({{ $galleryItem->id }})">
                                    Hapus
                                </x-button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <x-empty-state title="Belum ada gambar galeri yang diunggah" description="Unggah foto untuk menampilkan eksterior rumah kos, lobi, ruang kamar, dan lingkungan bersama Anda."></x-empty-state>
                    </div>
                @endforelse
            </div>

        </x-card>
    </div>

    <!-- Rule creation Modal -->
    <x-modal wire:model="showRuleModal" title="{{ $editingRuleId ? 'Ubah Aturan Kos' : 'Tambah Aturan Kos' }}" maxWidth="md">
        <form wire:submit="saveRule" class="space-y-4">
            <!-- Rule Title -->
            <div>
                <label for="rule_title" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Aturan</label>
                <input wire:model="ruleTitle" id="rule_title" type="text" required
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                    placeholder="cth. jam malam jam 10 malam, jam tenang">
                @error('ruleTitle') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Category & Icon -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="rule_cat" class="block text-sm font-medium text-slate-700 mb-1.5">Kategori</label>
                    <select wire:model="ruleCategory" id="rule_cat"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="General">Umum</option>
                        <option value="Curfew">Peraturan jam malam</option>
                        <option value="Visitor">Panduan pengunjung</option>
                        <option value="Pet">Kebijakan hewan peliharaan</option>
                        <option value="Cleanliness">Kebersihan</option>
                        <option value="Security">Keamanan</option>
                    </select>
                </div>
                <div>
                    <label for="rule_ic" class="block text-sm font-medium text-slate-700 mb-1.5">Ikon Visual</label>
                    <select wire:model="ruleIcon" id="rule_ic"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="key">Kunci gembok</option>
                        <option value="clock">Jam malam</option>
                        <option value="user">Pengunjung</option>
                        <option value="shield-check">Keamanan</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="rule_desc" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi (Detail S&amp;K)</label>
                <textarea wire:model="ruleDescription" id="rule_desc" rows="3"
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                    placeholder="Berikan deskripsi penjelasan untuk penghuni..."></textarea>
            </div>

            <!-- Toggles status / visibility -->
            <div class="grid grid-cols-2 gap-4 pt-1">
                <label class="flex items-center text-sm text-slate-750 cursor-pointer select-none">
                    <input type="checkbox" wire:model="ruleIsActive" class="h-4 w-4 rounded border-slate-350 text-indigo-600 focus:ring-indigo-500 mr-2"> Aktif
                </label>
                <label class="flex items-center text-sm text-slate-750 cursor-pointer select-none">
                    <input type="checkbox" wire:model="ruleIsVisiblePublic" class="h-4 w-4 rounded border-slate-350 text-indigo-600 focus:ring-indigo-500 mr-2"> Visibilitas publik
                </label>
            </div>

            <!-- Actions footer -->
            <div class="flex justify-end gap-3 pt-2">
                <x-button variant="outline" size="sm" type="button" @click="show = false">Batal</x-button>
                <x-button variant="primary" size="sm" type="submit" loading="saveRule">Simpan Aturan</x-button>
            </div>
        </form>
    </x-modal>

</div>
