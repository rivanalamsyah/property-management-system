<div class="space-y-6">
    
    <!-- Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ $residentId ? 'Ubah Profil Penghuni' : 'Daftarkan Penghuni Baru' }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">Konfigurasikan profil umum, kontak darurat, detail dokumen identitas, dan prosedur check-in.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="outline" size="sm" onclick="window.location.href='{{ route('residents') }}'">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar
                </span>
            </x-button>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit="saveResident" class="space-y-6">
        
        <!-- Photo & General Info -->
        <x-card title="Informasi Profil Umum" description="Berikan detail kartu identitas lengkap, pekerjaan, dan foto profil penghuni.">
            
            <!-- Avatar upload preview -->
            <div class="flex items-center gap-4 pb-4 border-b border-slate-50 mb-5">
                <div class="relative">
                    <img class="h-20 w-20 rounded-full object-cover bg-slate-100 border border-slate-200" 
                         src="{{ $photoUpload ? $photoUpload->temporaryUrl() : ($resident && $resident->photo ? asset('storage/' . $resident->photo) : ($resident ? asset('assets/images/avatars/resident_' . ($resident->gender === 'female' ? 'female' : 'male') . '.png') : asset('assets/images/avatars/generic.png'))) }}">
                    <label for="p_up" class="absolute -bottom-1.5 -right-1.5 p-1.5 bg-indigo-600 text-white rounded-full shadow cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                    </label>
                    <input type="file" id="p_up" class="hidden" wire:model="photoUpload" accept="image/*">
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-700">Foto Profil</h4>
                    <p class="text-[10px] text-slate-400">Format persegi PNG atau JPG. Ukuran file maksimal: 1MB.</p>
                    @error('photoUpload') <span class="text-xs text-rose-500 block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input wire:model="name" type="text" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="cth. Budi Santoso">
                    @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor NIK</label>
                    <input wire:model="nik" type="text" required maxlength="16" minlength="16"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="cth. 3201234567890001">
                    @error('nik') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Kelamin</label>
                    <select wire:model="gender"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="male">Laki-laki</option>
                        <option value="female">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-4">
                <!-- Birth date -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Lahir</label>
                    <input wire:model="date_of_birth" type="date" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                    @error('date_of_birth') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Birth Place -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tempat Lahir</label>
                    <input wire:model="place_of_birth" type="text" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="cth. Jakarta">
                    @error('place_of_birth') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Nationality -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Kewarganegaraan</label>
                    <input wire:model="nationality" type="text" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                    @error('nationality') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-4">
                <!-- Occupation -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Pekerjaan</label>
                    <input wire:model="occupation" type="text" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="cth. Mahasiswa, Karyawan Swasta">
                    @error('occupation') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Marital -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Status Pernikahan</label>
                    <select wire:model="marital_status"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        <option value="single">Belum Menikah</option>
                        <option value="married">Menikah</option>
                        <option value="divorced">Cerai</option>
                    </select>
                </div>

                <!-- Religion -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Agama (Opsional)</label>
                    <input wire:model="religion" type="text"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="cth. Islam">
                </div>
            </div>
        </x-card>

        <!-- Contact details -->
        <x-card title="Spesifikasi Kontak" description="Tentukan kontak langsung. Tautan verifikasi akan merujuk pada data ini.">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Handphone</label>
                    <input wire:model="phone" type="text" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="cth. +62812345678">
                    @error('phone') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor WhatsApp</label>
                    <input wire:model="whatsapp" type="text" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="cth. +62812345678">
                    @error('whatsapp') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Email</label>
                    <input wire:model="email" type="email" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="cth. penghuni@email.com">
                    @error('email') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-card>

        <!-- Address Info -->
        <x-card title="Spesifikasi Alamat" description="Detail alamat sesuai kartu identitas.">
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Alamat Jalan</label>
                    <input wire:model="address" type="text" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="Jl. Merdeka No. 10">
                    @error('address') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Kecamatan</label>
                    <input wire:model="district" type="text" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="Sumur Bandung">
                    @error('district') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-card>

        <!-- Emergency Contact -->
        <x-card title="Kontak Darurat" description="Berikan detail kontak kerabat dekat atau wali.">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Kontak</label>
                    <input wire:model="emergency_name" type="text" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="cth. Slamet Wibowo">
                    @error('emergency_name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Hubungan</label>
                    <input wire:model="emergency_relationship" type="text" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="cth. Ayah, Ibu, Wali">
                    @error('emergency_relationship') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Telepon</label>
                    <input wire:model="emergency_phone" type="text" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                        placeholder="cth. 08122334455">
                    @error('emergency_phone') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Wali</label>
                <textarea wire:model="emergency_address" rows="2" required
                    class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                    placeholder="Alamat lengkap kontak darurat..."></textarea>
                @error('emergency_address') <span class="text-xs text-rose-500 block mt-1">{{ $message }}</span> @enderror
            </div>
        </x-card>

        <!-- Sticky Submit bar -->
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <x-button variant="primary" size="sm" type="submit" loading="saveResident">
                {{ $residentId ? 'Simpan Perubahan Profil' : 'Daftarkan Profil Penghuni &amp; Lanjutkan' }}
            </x-button>
        </div>

    </form>

</div>
