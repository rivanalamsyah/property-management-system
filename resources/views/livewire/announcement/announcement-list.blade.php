<div class="space-y-6">
    
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 reveal">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Pengumuman &amp; <span class="text-gradient-primary">Siaran</span></h1>
            <p class="text-xs text-slate-500 mt-1">Kirim notifikasi massal ke penghuni, jadwalkan pengingat, pantau keterbacaan, dan publikasikan pembaruan informasi.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" wire:click="openCreateModal" data-ripple>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                Buat Pengumuman Baru
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 reveal">
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Siaran Aktif</p>
            <h3 class="text-xl font-black text-slate-800 mt-1" data-counter="{{ $publishedCount }}">{{ $publishedCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Jadwal Antrian</p>
            <h3 class="text-xl font-black text-indigo-650 mt-1" data-counter="{{ $scheduledCount }}">{{ $scheduledCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Draft</p>
            <h3 class="text-xl font-black text-slate-600 mt-1" data-counter="{{ $draftCount }}">{{ $draftCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Rasio Dibaca</p>
            <h3 class="text-xl font-black text-emerald-600 mt-1">{{ $readRate }}<span class="text-sm font-bold text-slate-400">%</span></h3>
        </div>
    </div>

    <!-- Filters Section -->
    <x-card :glass="true" padding="sm">
        <div class="flex flex-wrap items-center justify-between gap-3">
            
            <!-- Left inputs -->
            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Search -->
                <div class="relative w-52">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input wire:model.live.debounce.250ms="search" type="text"
                        class="input-base input-with-icon py-1.5! text-xs!"
                        placeholder="Cari judul atau isi...">
                </div>

                <!-- Category -->
                <select wire:model.live="filterCategory" class="input-base py-1.5! text-xs! w-auto">
                    <option value="">Semua Kategori</option>
                    <option value="general">Umum</option>
                    <option value="maintenance">Pemberitahuan Perbaikan</option>
                    <option value="water_shutdown">Pemadaman Air</option>
                    <option value="cleaning">Jadwal Pembersihan</option>
                    <option value="rent_reminder">Pengingat Sewa</option>
                    <option value="emergency">Darurat</option>
                    <option value="holiday">Hari Libur</option>
                    <option value="promotional">Promosi</option>
                    <option value="other">Lainnya</option>
                </select>

                <!-- Priority -->
                <select wire:model.live="filterPriority" class="input-base py-1.5! text-xs! w-auto">
                    <option value="">Semua Prioritas</option>
                    <option value="low">Rendah</option>
                    <option value="normal">Normal</option>
                    <option value="important">Penting</option>
                    <option value="high">Tinggi</option>
                    <option value="emergency">Darurat</option>
                </select>

                <!-- Status -->
                <select wire:model.live="filterStatus" class="input-base py-1.5! text-xs! w-auto">
                    <option value="">Semua Status</option>
                    <option value="draft">Draft</option>
                    <option value="scheduled">Terjadwal</option>
                    <option value="published">Diterbitkan</option>
                    <option value="expired">Kadaluarsa</option>
                    <option value="archived">Diarsipkan</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>

            <div class="text-[10px] text-slate-400 italic">
                Integrasi WhatsApp, Email, &amp; Push Notification aktif.
            </div>

        </div>
    </x-card>

    <!-- Announcement list table -->
    <div class="reveal">
        <x-table :headers="['ID Siaran', 'Judul Pengumuman', 'Target Sasaran', 'Penulis', 'Jadwal Rilis', 'Prioritas', 'Pin', 'Status', 'Aksi']" :stickyHeader="true">
            @forelse($announcements as $ann)
                <tr class="group transition-colors duration-100">
                    <!-- ID -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="ID Siaran">
                        <span class="text-xs font-mono font-bold text-slate-800 bg-slate-100/70 px-2 py-0.5 rounded-lg">{{ $ann->announcement_number }}</span>
                    </td>

                    <!-- Title -->
                    <td class="px-5 py-3.5" data-label="Judul">
                        <p class="text-xs font-bold text-slate-900">{{ $ann->title }}</p>
                        @if($ann->summary)
                            <p class="text-[10px] text-slate-400 mt-0.5 leading-relaxed">{{ $ann->summary }}</p>
                        @endif
                    </td>

                    <!-- Target type -->
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs text-slate-600 font-semibold capitalize" data-label="Target">
                        {{ str_replace('_', ' ', $ann->target_type) }}
                    </td>

                    <!-- Author -->
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs text-slate-800 font-bold" data-label="Penulis">
                        {{ $ann->author ? $ann->author->name : 'Sistem' }}
                    </td>

                    <!-- Date -->
                    <td class="px-5 py-3.5 whitespace-nowrap text-xs text-slate-500 font-medium" data-label="Jadwal Rilis">
                        {{ $ann->publish_at->format('d M Y, H:i') }}
                    </td>

                    <!-- Priority -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Prioritas">
                        @php
                            $pColor = 'text-slate-500 font-semibold';
                            if ($ann->priority->value === 'important') $pColor = 'text-indigo-600 font-bold';
                            if (in_array($ann->priority->value, ['high', 'emergency'])) $pColor = 'text-rose-600 font-black animate-pulse';
                        @endphp
                        <span class="text-xs {{ $pColor }}">{{ $ann->priority->label() }}</span>
                    </td>

                    <!-- Pinned -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Pin">
                        @if($ann->pinned_at)
                            <x-badge variant="warning" :dot="true">Pinned</x-badge>
                        @else
                            <span class="text-slate-300 text-xs">—</span>
                        @endif
                    </td>

                    <!-- Status -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Status">
                        @php
                            $variant = 'neutral';
                            if ($ann->status->value === 'published') $variant = 'success';
                            if ($ann->status->value === 'scheduled') $variant = 'info';
                            if ($ann->status->value === 'draft') $variant = 'neutral';
                            if (in_array($ann->status->value, ['expired', 'cancelled'])) $variant = 'danger';
                            if ($ann->status->value === 'archived') $variant = 'neutral';
                        @endphp
                        <x-badge :variant="$variant" :dot="$ann->status->value === 'published'">{{ $ann->status->label() }}</x-badge>
                    </td>

                    <!-- Actions -->
                    <td class="px-5 py-3.5 whitespace-nowrap" data-label="Aksi">
                        <a href="{{ route('announcements.show', $ann->id) }}"
                           class="inline-flex items-center justify-center w-7 h-7 rounded-xl border border-slate-200/80 bg-white hover:bg-slate-50 text-slate-500 hover:text-slate-700 transition-all shadow-2xs active:scale-90"
                           title="Lacak Keterbacaan">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="p-0">
                        <x-empty-state
                            icon="inbox"
                            title="Belum ada pengumuman disiarkan"
                            description="Tulis pengumuman baru, jadwalkan notifikasi perbaikan, atau kirim pengingat penting ke penghuni kos.">
                            <x-button variant="primary" size="sm" wire:click="openCreateModal">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Buat Pengumuman Pertama
                            </x-button>
                        </x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-table>

        <!-- Pagination -->
        <div class="mt-4 px-1">
            {{ $announcements->links('components.pagination') }}
        </div>
    </div>

    <!-- CREATE ANNOUNCEMENT MODAL DIALOG -->
    <x-modal wire:model="showCreateModal" title="Tulis Siaran Pengumuman Baru" maxWidth="lg">
        <form wire:submit.prevent="storeAnnouncement" class="space-y-4">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Judul Pengumuman</label>
                    <input wire:model="title" type="text" required class="input-base text-xs" placeholder="Contoh: Pemeliharaan Pipa Air Bersih &amp; Pompa Mandi">
                    @error('title') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Category -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Kategori</label>
                    <select wire:model="category" required class="input-base text-xs">
                        <option value="general">Umum</option>
                        <option value="maintenance">Perbaikan Properti</option>
                        <option value="water_shutdown">Pemadaman Air</option>
                        <option value="cleaning">Jadwal Bersih-bersih</option>
                        <option value="rent_reminder">Pengingat Sewa</option>
                        <option value="emergency">Keadaan Darurat</option>
                        <option value="holiday">Hari Libur</option>
                        <option value="promotional">Promosi / Info</option>
                        <option value="other">Lainnya</option>
                    </select>
                </div>

                <!-- Priority -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Prioritas</label>
                    <select wire:model="priority" required class="input-base text-xs">
                        <option value="low">Rendah</option>
                        <option value="normal">Normal</option>
                        <option value="important">Penting</option>
                        <option value="high">Tinggi</option>
                        <option value="emergency">Darurat (Alert)</option>
                    </select>
                </div>
            </div>

            <!-- Summary -->
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1.5">Ringkasan Singkat (Akan muncul di notifikasi HP)</label>
                <input wire:model="summary" type="text" class="input-base text-xs" placeholder="Contoh: Aliran air bersih dimatikan hari Jumat jam 10:00 - 13:00 untuk perbaikan pompa.">
                @error('summary') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Content -->
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1.5">Konten Pengumuman Lengkap</label>
                <textarea wire:model="content" rows="4" required class="input-base text-xs" placeholder="Tulis isi pengumuman detail di sini..."></textarea>
                @error('content') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Target Audience Selector (Alpine.js driven) -->
            <div x-data="{ targetType: @entangle('targetType') }" class="border-t border-slate-100 pt-3.5 space-y-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Target Penerima</label>
                    <select x-model="targetType" required class="input-base text-xs">
                        <option value="all">Semua Penghuni Aktif (Semua Kos)</option>
                        <option value="boarding_house">Hanya Properti Kos Tertentu</option>
                        <option value="floor">Hanya Lantai Tertentu</option>
                        <option value="room">Hanya Kamar Tertentu</option>
                        <option value="selected_tenants">Daftar Penghuni Pilihan</option>
                    </select>
                </div>

                <!-- Boarding House Targeting -->
                <div x-show="targetType === 'boarding_house' || targetType === 'floor' || targetType === 'room'" class="space-y-2 pt-1">
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Pilih Properti Kos</label>
                    <select wire:model.live="boarding_house_id" class="input-base text-xs">
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Floors Targeting -->
                <div x-show="targetType === 'floor'" class="space-y-2 pt-1">
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Pilih Lantai Target</label>
                    <div class="grid grid-cols-5 gap-2">
                        @foreach([1, 2, 3, 4, 5] as $fl)
                            <label class="flex items-center gap-1.5 p-2 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 text-[11px] font-semibold text-slate-650">
                                <input type="checkbox" wire:model="selectedFloors" value="{{ $fl }}" class="rounded text-indigo-600 focus:ring-indigo-500">
                                Lantai {{ $fl }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Rooms Targeting -->
                <div x-show="targetType === 'room'" class="space-y-2 pt-1">
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Pilih Kamar Target</label>
                    <div class="grid grid-cols-4 gap-2 max-h-32 overflow-y-auto border border-slate-200/80 p-3 rounded-2xl">
                        @foreach($rooms as $rm)
                            <label class="flex items-center gap-1.5 text-[10px] font-medium text-slate-600">
                                <input type="checkbox" wire:model="selectedRooms" value="{{ $rm->id }}" class="rounded text-indigo-600 focus:ring-indigo-500">
                                Kamar {{ $rm->room_number }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Specific Tenants Targeting -->
                <div x-show="targetType === 'selected_tenants'" class="space-y-2 pt-1">
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Pilih Penghuni Target</label>
                    <div class="grid grid-cols-2 gap-2 max-h-32 overflow-y-auto border border-slate-200/80 p-3 rounded-2xl">
                        @foreach($residents as $res)
                            <label class="flex items-center gap-1.5 text-[10px] font-medium text-slate-600">
                                <input type="checkbox" wire:model="selectedResidents" value="{{ $res->id }}" class="rounded text-indigo-600 focus:ring-indigo-500">
                                {{ $res->name }} (Km: {{ $res->room ? $res->room->room_number : '—' }})
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Schedule Options -->
            <div x-data="{ publishOption: @entangle('publishOption') }" class="border-t border-slate-100 pt-3.5 space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Opsi Jadwal Rilis</label>
                        <select x-model="publishOption" required class="input-base text-xs">
                            <option value="now">Kirim Sekarang (Langsung)</option>
                            <option value="later">Jadwalkan Rilis Nanti</option>
                        </select>
                    </div>

                    <div x-show="publishOption === 'later'">
                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Tanggal &amp; Waktu Rilis</label>
                        <input wire:model="publishAtDate" type="datetime-local" class="input-base text-xs">
                        @error('publishAtDate') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Kadaluarsa Otomatis (Opsional)</label>
                        <input wire:model="expiresAtDate" type="datetime-local" class="input-base text-xs">
                        @error('expiresAtDate') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="flex items-center gap-2 cursor-pointer font-bold text-slate-650 text-xs">
                            <input type="checkbox" wire:model="isPinned" class="rounded text-indigo-600 focus:ring-indigo-500">
                            Sematkan (Pin) ke Dashboard Utama
                        </label>
                    </div>
                </div>
            </div>

            <!-- File attachment upload -->
            <div class="border-t border-slate-100 pt-3.5">
                <label class="block text-xs font-bold text-slate-500 mb-1.5">Lampirkan Foto pendukung atau Dokumen PDF (Opsional)</label>
                <input type="file" wire:model="attachmentFile" accept="image/*,application/pdf"
                    class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:border-0 file:rounded-xl file:text-[10px] file:font-bold file:bg-indigo-50 file:text-indigo-650 cursor-pointer transition-all active:scale-95">
                @error('attachmentFile') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2.5 pt-2 border-t border-slate-100/80">
                <x-button variant="outline" size="sm" @click="show = false">Batal</x-button>
                <x-button variant="primary" size="sm" type="submit" :loading="'storeAnnouncement'">Kirim Siaran</x-button>
            </div>
        </form>
    </x-modal>

</div>
