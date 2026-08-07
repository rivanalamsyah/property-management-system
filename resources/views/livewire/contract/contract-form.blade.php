<div class="space-y-6">
    
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ $contractId ? 'Ubah Spesifikasi Kontrak' : 'Daftar Perjanjian Kontrak Sewa' }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">Konfigurasikan ketentuan sewa, pengaturan perpanjangan otomatis, biaya utilitas, dan draf file PDF bertanda tangan.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="outline" size="sm" onclick="window.location.href='{{ route('contracts') }}'">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar
                </span>
            </x-button>
        </div>
    </div>

    <!-- Progress Stepper Indicator -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 mb-6 flex items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 {{ $step >= 1 ? 'bg-indigo-650 text-white' : 'bg-slate-100 text-slate-400' }}">1</span>
            <span class="text-xs font-bold {{ $step === 1 ? 'text-slate-800' : 'text-slate-400' }}">Ketentuan Umum Sewa</span>
        </div>
        <div class="h-0.5 flex-1 bg-slate-100 max-w-[120px]"></div>
        <div class="flex items-center gap-2">
            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 {{ $step >= 2 ? 'bg-indigo-650 text-white' : 'bg-slate-100 text-slate-400' }}">2</span>
            <span class="text-xs font-bold {{ $step === 2 ? 'text-slate-800' : 'text-slate-400' }}">Estimasi Keuangan</span>
        </div>
        <div class="h-0.5 flex-1 bg-slate-100 max-w-[120px]"></div>
        <div class="flex items-center gap-2">
            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 {{ $step >= 3 ? 'bg-indigo-650 text-white' : 'bg-slate-100 text-slate-400' }}">3</span>
            <span class="text-xs font-bold {{ $step === 3 ? 'text-slate-800' : 'text-slate-400' }}">Dokumentasi Admin</span>
        </div>
    </div>

    <!-- Form Wizard Steps -->
    <div class="space-y-6">

        <!-- STEP 1: General Terms -->
        @if($step === 1)
            <x-card title="Spesifikasi Umum Sewa" description="Pilih properti rumah kos, target penghuni, alokasi kamar, dan batas durasi sewa.">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    
                    <!-- Property Boarding House -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Properti Rumah Kos</label>
                        <select wire:model.live="boarding_house_id" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none">
                            <option value="">Pilih Properti...</option>
                            @foreach($boardingHouses as $house)
                                <option value="{{ $house->id }}">{{ $house->name }}</option>
                            @endforeach
                        </select>
                        @error('boarding_house_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Room Selection -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Kamar Target</label>
                        <select wire:model.live="room_id" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none">
                            <option value="">Pilih Kamar...</option>
                            @foreach($availableRooms as $room)
                                <option value="{{ $room->id }}">Kamar {{ $room->room_number }} (Rp{{ number_format($room->monthly_rent, 0, ',', '.') }}/bln)</option>
                            @endforeach
                        </select>
                        @error('room_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Resident / Tenant Selection -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Penyewa / Penghuni</label>
                        <select wire:model="resident_id" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none">
                            <option value="">Pilih Penghuni...</option>
                            @foreach($residents as $res)
                                <option value="{{ $res->id }}">{{ $res->name }} (NIK: {{ $res->nik }})</option>
                            @endforeach
                        </select>
                        @error('resident_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-5">
                    <!-- Contract Type -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Tipe Tagihan</label>
                        <select wire:model="contract_type"
                            class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none">
                            <option value="monthly">Bulanan</option>
                            <option value="quarterly">Triwulanan</option>
                            <option value="semi_annual">Setengah Tahunan</option>
                            <option value="annual">Tahunan</option>
                            <option value="custom">Durasi Kustom</option>
                        </select>
                    </div>

                    <!-- Start date -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Tanggal Mulai</label>
                        <input wire:model="start_date" type="date" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        @error('start_date') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- End date -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Tanggal Selesai</label>
                        <input wire:model="end_date" type="date" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        @error('end_date') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Duration months -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Durasi (Bulan)</label>
                        <input wire:model="duration_months" type="number" required min="1" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                        @error('duration_months') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5 pt-4 border-t border-slate-50">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Tanggal Pindah Aktual</label>
                        <input wire:model="move_in_date" type="date" required class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    </div>
                    <div class="flex items-center gap-3 pt-6">
                        <input wire:model="auto_renewal" type="checkbox" id="auto_r" class="rounded border-slate-300 text-indigo-650 focus:ring-indigo-500">
                        <label for="auto_r" class="text-xs font-bold text-slate-700 select-none cursor-pointer">Opsi Perpanjangan Kontrak Otomatis diaktifkan</label>
                    </div>
                </div>
            </x-card>
        @endif

        <!-- STEP 2: Financial Details -->
        @if($step === 2)
            <x-card title="Estimasi Keuangan &amp; Biaya Tambahan" description="Tentukan detail matriks harga termasuk tarif sewa bulanan, utilitas, parameter deposit, dan diskon.">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Monthly Rent -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Harga Sewa Bulanan (IDR)</label>
                        <input wire:model="monthly_rent" type="number" required min="0" step="1000"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm">
                        @error('monthly_rent') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Security Deposit -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Deposit Keamanan Dibayar (IDR)</label>
                        <input wire:model="security_deposit" type="number" required min="0" step="1000"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm">
                        @error('security_deposit') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Discount -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Diskon Sewa Bulanan (IDR)</label>
                        <input wire:model="discount" type="number" required min="0" step="1000"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm">
                        @error('discount') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-5 pt-4 border-t border-slate-50">
                    <!-- Electricity -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Token Listrik</label>
                        <input wire:model="electricity_fee" type="number" required min="0" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    </div>

                    <!-- Water -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Biaya Air</label>
                        <input wire:model="water_fee" type="number" required min="0" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    </div>

                    <!-- Internet -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Koneksi Internet</label>
                        <input wire:model="internet_fee" type="number" required min="0" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    </div>

                    <!-- Parking -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Biaya Parkir</label>
                        <input wire:model="parking_fee" type="number" required min="0" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    </div>

                    <!-- Additional -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Biaya Tambahan</label>
                        <input wire:model="additional_charges" type="number" required min="0" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-xs">
                    </div>
                </div>
            </x-card>
        @endif

        <!-- STEP 3: Admin Notes -->
        @if($step === 3)
            <x-card title="Detail Dokumentasi Kontrak" description="Berikan deskripsi internal, anotasi aturan kos, dan catatan kaki perjanjian publik.">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan Kantor Internal (Privat)</label>
                        <textarea wire:model="internal_notes" rows="3"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm"
                            placeholder="Anotasi privat, catatan daftar periksa persetujuan, detail konteks latar belakang..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan Perjanjian Kontrak Publik (Catatan Kaki)</label>
                        <textarea wire:model="public_notes" rows="3"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm"
                            placeholder="Anotasi aturan publik tambahan, penambahan ketentuan pembayaran, perpanjangan durasi kustom..."></textarea>
                    </div>
                </div>
            </x-card>
        @endif

        <!-- Stepper Navigation Footer -->
        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            @if($step > 1)
                <x-button variant="outline" size="sm" type="button" wire:click="prevStep">
                    Kembali
                </x-button>
            @else
                <div></div>
            @endif

            @if($step < 3)
                <x-button variant="primary" size="sm" type="button" wire:click="nextStep">
                    Lanjut
                </x-button>
            @else
                <x-button variant="primary" size="sm" type="button" wire:click="saveContract" loading="saveContract">
                    {{ $contractId ? 'Simpan Spesifikasi Kontrak' : 'Buat Draf Perjanjian Sewa' }}
                </x-button>
            @endif
        </div>

    </div>

</div>
