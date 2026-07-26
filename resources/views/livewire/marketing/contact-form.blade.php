<div class="p-8 bg-white border border-slate-200/80 rounded-3xl shadow-xl space-y-6">
    <div class="space-y-2">
        <h3 class="text-xl font-black text-slate-900 tracking-tight">Jadwalkan Demo Platform</h3>
        <p class="text-xs text-slate-500 leading-relaxed">Dapatkan panduan simulasi dashboard khusus yang disesuaikan dengan kapasitas kamar kos Anda.</p>
    </div>

    @if($successMessage)
        <div class="p-4 bg-emerald-50 border border-emerald-200/60 text-emerald-800 rounded-2xl text-xs leading-relaxed font-medium shadow-2xs">
            ✨ {{ $successMessage }}
        </div>
    @else
        <form wire:submit.prevent="submitDemoRequest" class="space-y-4 text-left">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-label for="c_name" value="Nama Lengkap" />
                    <x-input id="c_name" type="text" required placeholder="Nama Pemilik / Pengelola" wire:model.defer="name" class="mt-1" />
                    <x-input-error for="name" class="mt-1" />
                </div>

                <div>
                    <x-label for="c_email" value="Email Pekerjaan" />
                    <x-input id="c_email" type="email" required placeholder="pemilik@kosan.com" wire:model.defer="email" class="mt-1" />
                    <x-input-error for="email" class="mt-1" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-label for="c_phone" value="Nomor Telepon (WhatsApp)" />
                    <x-input id="c_phone" type="text" required placeholder="Contoh: 081234567890" wire:model.defer="phone" class="mt-1" />
                    <x-input-error for="phone" class="mt-1" />
                </div>

                <div>
                    <x-label for="c_comp" value="Nama Usaha / Brand Kos" />
                    <x-input id="c_comp" type="text" required placeholder="Contoh: Kos Cihampelas Group" wire:model.defer="company_name" class="mt-1" />
                    <x-input-error for="company_name" class="mt-1" />
                </div>
            </div>

            <div>
                <x-label for="c_size" value="Jumlah Kamar Terkelola" />
                <select id="c_size" wire:model.defer="property_size"
                        class="w-full mt-1 px-3.5 py-2.5 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-2xs">
                    <option value="1-10">1 - 10 Kamar</option>
                    <option value="11-50">11 - 50 Kamar</option>
                    <option value="51-200">51 - 200 Kamar</option>
                    <option value="200+">Lebih dari 200 Kamar</option>
                </select>
                <x-input-error for="property_size" class="mt-1" />
            </div>

            <div>
                <x-label for="c_msg" value="Apa kebutuhan atau pertanyaan Anda?" />
                <textarea id="c_msg" rows="4" required placeholder="Tuliskan pertanyaan integrasi atau fitur tertentu yang ingin Anda lihat saat sesi demo..." wire:model.defer="message"
                          class="w-full mt-1 px-3.5 py-2.5 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-2xs"></textarea>
                <x-input-error for="message" class="mt-1" />
            </div>

            <x-button variant="primary" type="submit" class="w-full py-3" wire:loading.attr="disabled">
                <span wire:loading class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></span>
                Jadwalkan Demo Kustom
            </x-button>
        </form>
    @endif
</div>
