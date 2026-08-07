<div class="space-y-6">
    
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 reveal">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Laporan Komplain &amp; <span class="text-gradient-primary">Perbaikan</span></h1>
            <p class="text-xs text-slate-500 mt-1">Audit masalah yang dilaporkan penghuni, delegasikan tugas perbaikan, pantau biaya, dan verifikasi status penyelesaian.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="primary" size="sm" wire:click="openCreateModal" data-ripple>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Laporan Baru
            </x-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 reveal">
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Komplain Terbuka</p>
            <h3 class="text-xl font-black text-slate-800 mt-1" data-counter="{{ $openCount }}">{{ $openCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Prioritas Tinggi / Kritis</p>
            <h3 class="text-xl font-black text-rose-600 mt-1" data-counter="{{ $highPriorityCount }}">{{ $highPriorityCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Dalam Perbaikan</p>
            <h3 class="text-xl font-black text-amber-600 mt-1" data-counter="{{ $inProgressCount }}">{{ $inProgressCount }}</h3>
        </div>
        <div class="card-base card-hover p-4 cursor-default">
            <p class="section-label mb-1">Selesai Teratasi</p>
            <h3 class="text-xl font-black text-emerald-600 mt-1" data-counter="{{ $completedCount }}">{{ $completedCount }}</h3>
        </div>
    </div>

    <!-- View Mode Switcher & Filters -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-3 reveal">
        <!-- View Toggle buttons (premium glass pill styled) -->
        <div class="flex items-center gap-1 bg-slate-100/80 border border-slate-200/50 p-1 rounded-2xl w-fit">
            <button wire:click="toggleViewMode('table')" 
                    class="px-4 py-1.5 text-xs font-bold rounded-xl transition-all duration-200 cursor-pointer {{ $viewMode === 'table' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                Tampilan Tabel
            </button>
            <button wire:click="toggleViewMode('kanban')" 
                    class="px-4 py-1.5 text-xs font-bold rounded-xl transition-all duration-200 cursor-pointer {{ $viewMode === 'kanban' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                Papan Kanban
            </button>
        </div>

        <!-- Filters Section -->
        <div class="flex flex-wrap items-center gap-2.5">
            <!-- Search -->
            <div class="relative w-full md:w-52">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input wire:model.live.debounce.250ms="search" type="text"
                    class="input-base input-with-icon py-1.5! text-xs!"
                    placeholder="Cari komplain, kamar...">
            </div>

            <!-- Property Filter -->
            <select wire:model.live="filterBoardingHouse" class="input-base py-1.5! text-xs! w-auto">
                <option value="">Semua Kos</option>
                @foreach($boardingHouses as $house)
                    <option value="{{ $house->id }}">{{ $house->name }}</option>
                @endforeach
            </select>

            <!-- Category -->
            <select wire:model.live="filterCategory" class="input-base py-1.5! text-xs! w-auto">
                <option value="">Semua Kategori</option>
                <option value="electricity">Listrik</option>
                <option value="water">Air</option>
                <option value="bathroom">Kamar Mandi</option>
                <option value="ac">Air Conditioner (AC)</option>
                <option value="internet">Internet / Wi-Fi</option>
                <option value="furniture">Furnitur / Kasur</option>
                <option value="door">Pintu / Kunci</option>
                <option value="roof">Atap Bocor</option>
                <option value="kitchen">Dapur</option>
                <option value="security">Keamanan</option>
                <option value="cleaning">Kebersihan</option>
                <option value="other">Lainnya</option>
            </select>

            <!-- Priority -->
            <select wire:model.live="filterPriority" class="input-base py-1.5! text-xs! w-auto">
                <option value="">Semua Prioritas</option>
                <option value="low">Rendah</option>
                <option value="normal">Normal</option>
                <option value="high">Tinggi</option>
                <option value="critical">Kritis</option>
                <option value="emergency">Darurat</option>
            </select>
        </div>
    </div>

    <!-- MAIN VIEWS PANEL -->
    @if($viewMode === 'table')
        <!-- TABLE VIEW -->
        <div class="reveal">
            <x-table :headers="['No. Komplain', 'Penghuni', 'Kamar/Kos', 'Subjek', 'Kategori', 'Prioritas', 'Tugas Teknisi', 'Status', 'Aksi']" :stickyHeader="true">
                @forelse($complaints as $cmp)
                    <tr class="group transition-colors duration-100">
                        <!-- Number -->
                        <td class="px-5 py-3.5 whitespace-nowrap" data-label="No. Komplain">
                            <span class="text-xs font-mono font-bold text-slate-800 bg-slate-100/70 px-2 py-0.5 rounded-lg">{{ $cmp->complaint_number }}</span>
                        </td>

                        <!-- Resident -->
                        <td class="px-5 py-3.5 font-bold text-slate-900" data-label="Penghuni">
                            {{ $cmp->resident->name }}
                        </td>

                        <!-- Room details -->
                        <td class="px-5 py-3.5" data-label="Kamar/Kos">
                            <p class="text-xs font-semibold text-slate-700">{{ $cmp->boardingHouse->name }}</p>
                            <p class="text-[10px] font-mono text-indigo-500 mt-0.5">Kamar {{ $cmp->room ? $cmp->room->room_number : '—' }}</p>
                        </td>

                        <!-- Subject -->
                        <td class="px-5 py-3.5 max-w-xs truncate" data-label="Subjek">
                            <p class="text-xs font-bold text-slate-900">{{ $cmp->subject }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ \Illuminate\Support\Str::limit($cmp->description, 50) }}</p>
                        </td>

                        <!-- Category -->
                        <td class="px-5 py-3.5 whitespace-nowrap text-xs text-slate-500 font-semibold capitalize" data-label="Kategori">
                            {{ $cmp->category }}
                        </td>

                        <!-- Priority -->
                        <td class="px-5 py-3.5 whitespace-nowrap" data-label="Prioritas">
                            @php
                                $pColor = 'text-slate-500 font-semibold';
                                if ($cmp->priority->value === 'high') $pColor = 'text-amber-600 font-bold';
                                if (in_array($cmp->priority->value, ['critical', 'emergency'])) $pColor = 'text-rose-600 font-black animate-pulse';
                            @endphp
                            <span class="text-xs {{ $pColor }}">{{ $cmp->priority->label() }}</span>
                        </td>

                        <!-- Assigned Maintenance Task -->
                        <td class="px-5 py-3.5 whitespace-nowrap font-mono" data-label="Tugas Teknisi">
                            @if($cmp->maintenanceTask)
                                <p class="text-xs font-bold text-slate-900">{{ $cmp->maintenanceTask->task_number }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $cmp->maintenanceTask->assignedStaff ? $cmp->maintenanceTask->assignedStaff->name : 'Belum Ditugaskan' }}</p>
                            @else
                                <span class="text-slate-400 italic text-[10px]">Belum ada tugas</span>
                            @endif
                        </td>

                        <!-- Status badge -->
                        <td class="px-5 py-3.5 whitespace-nowrap" data-label="Status">
                            @php
                                $variant = 'neutral';
                                if (in_array($cmp->status->value, ['completed', 'verified', 'closed'])) $variant = 'success';
                                if ($cmp->status->value === 'open') $variant = 'neutral';
                                if (in_array($cmp->status->value, ['reviewed', 'assigned'])) $variant = 'info';
                                if (in_array($cmp->status->value, ['in_progress', 'waiting_parts'])) $variant = 'warning';
                                if ($cmp->status->value === 'cancelled') $variant = 'danger';
                            @endphp
                            <x-badge :variant="$variant" :dot="in_array($cmp->status->value, ['in_progress', 'open'])">{{ $cmp->status->label() }}</x-badge>
                        </td>

                        <!-- Actions -->
                        <td class="px-5 py-3.5 whitespace-nowrap" data-label="Aksi">
                            <a href="{{ route('complaints.show', $cmp->id) }}"
                               class="inline-flex items-center justify-center w-7 h-7 rounded-xl border border-slate-200/80 bg-white hover:bg-indigo-50 hover:border-indigo-200 text-slate-500 hover:text-indigo-600 transition-all shadow-2xs active:scale-90"
                               title="Kelola Kasus">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-0">
                            <x-empty-state 
                                icon="inbox"
                                title="Tidak ada laporan komplain" 
                                description="Catat daftar perbaikan properti, kelola kendala pipa/listrik, atau alokasikan tugas ke teknisi.">
                                <x-button variant="primary" size="sm" wire:click="openCreateModal">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Buat Laporan Baru
                                </x-button>
                            </x-empty-state>
                        </td>
                    </tr>
                @endforelse
            </x-table>

            <div class="mt-4 px-1">
                {{ $complaints->links('components.pagination') }}
            </div>
        </div>

    @else
        <!-- KANBAN BOARD VIEW -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-start reveal">
            
            <!-- Column 1: Open / Reviewed -->
            <div class="bg-slate-50/60 border border-slate-200/50 p-4 rounded-2xl space-y-3 min-h-[480px]">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                    <span class="text-xs font-black text-slate-800 tracking-tight">Baru &amp; Direview</span>
                    <span class="text-[10px] bg-slate-200/60 text-slate-600 px-2 py-0.5 rounded-lg font-bold">{{ count($kanbanComplaints['open']) }}</span>
                </div>
                
                <div class="space-y-3 max-h-[600px] overflow-y-auto pr-1">
                    @forelse($kanbanComplaints['open'] as $c)
                        <div class="bg-white p-4 border border-slate-200/60 rounded-2xl shadow-2xs hover:shadow-sm hover:border-indigo-400/80 transition-all duration-200 cursor-pointer space-y-2.5 active:scale-[0.99]" onclick="window.location.href='{{ route('complaints.show', $c->id) }}'">
                            <div class="flex justify-between items-start gap-2">
                                <span class="font-mono text-[9px] font-bold text-slate-400">{{ $c->complaint_number }}</span>
                                <x-badge variant="neutral" class="text-[7px] py-0 px-1">{{ $c->priority->label() }}</x-badge>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900 line-clamp-2 leading-relaxed">{{ $c->subject }}</h4>
                            <p class="text-[10px] text-slate-450 leading-relaxed line-clamp-3">{{ $c->description }}</p>
                            <div class="border-t border-slate-100 pt-2 flex justify-between items-center text-[9px] text-slate-400 font-medium">
                                <span class="truncate max-w-[80px]">{{ $c->boardingHouse->name }}</span>
                                <span class="font-bold text-slate-700 flex-shrink-0">Kamar {{ $c->room ? $c->room->room_number : '—' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-[10px] italic text-slate-400 py-8">Kosong</p>
                    @endforelse
                </div>
            </div>

            <!-- Column 2: Assigned / Waiting Parts -->
            <div class="bg-slate-50/60 border border-slate-200/50 p-4 rounded-2xl space-y-3 min-h-[480px]">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                    <span class="text-xs font-black text-slate-800 tracking-tight">Ditugaskan / Menunggu Part</span>
                    <span class="text-[10px] bg-slate-200/60 text-slate-600 px-2 py-0.5 rounded-lg font-bold">{{ count($kanbanComplaints['assigned']) }}</span>
                </div>

                <div class="space-y-3 max-h-[600px] overflow-y-auto pr-1">
                    @forelse($kanbanComplaints['assigned'] as $c)
                        <div class="bg-white p-4 border border-slate-200/60 rounded-2xl shadow-2xs hover:shadow-sm hover:border-indigo-400/80 transition-all duration-200 cursor-pointer space-y-2.5 active:scale-[0.99]" onclick="window.location.href='{{ route('complaints.show', $c->id) }}'">
                            <div class="flex justify-between items-start gap-2">
                                <span class="font-mono text-[9px] font-bold text-slate-400">{{ $c->complaint_number }}</span>
                                <x-badge variant="info" class="text-[7px] py-0 px-1">{{ $c->priority->label() }}</x-badge>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900 line-clamp-2 leading-relaxed">{{ $c->subject }}</h4>
                            <p class="text-[10px] text-slate-455 leading-relaxed line-clamp-2">{{ $c->description }}</p>
                            
                            @if($c->maintenanceTask)
                                <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200/60 text-[9px] font-semibold text-slate-600">
                                    <p class="font-bold text-slate-800">Tugas: {{ $c->maintenanceTask->task_number }}</p>
                                    <p class="mt-0.5 text-slate-450">Staf: {{ $c->maintenanceTask->assignedStaff ? $c->maintenanceTask->assignedStaff->name : 'Belum Ditugaskan' }}</p>
                                </div>
                            @endif

                            <div class="border-t border-slate-100 pt-2 flex justify-between items-center text-[9px] text-slate-400 font-medium">
                                <span class="truncate max-w-[80px]">{{ $c->boardingHouse->name }}</span>
                                <span class="font-bold text-slate-700 flex-shrink-0">Kamar {{ $c->room ? $c->room->room_number : '—' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-[10px] italic text-slate-400 py-8">Kosong</p>
                    @endforelse
                </div>
            </div>

            <!-- Column 3: In Progress -->
            <div class="bg-slate-50/60 border border-slate-200/50 p-4 rounded-2xl space-y-3 min-h-[480px]">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                    <span class="text-xs font-black text-slate-800 tracking-tight">Sedang Dikerjakan</span>
                    <span class="text-[10px] bg-slate-200/60 text-slate-600 px-2 py-0.5 rounded-lg font-bold">{{ count($kanbanComplaints['in_progress']) }}</span>
                </div>

                <div class="space-y-3 max-h-[600px] overflow-y-auto pr-1">
                    @forelse($kanbanComplaints['in_progress'] as $c)
                        <div class="bg-white p-4 border border-slate-200/60 rounded-2xl shadow-2xs hover:shadow-sm hover:border-indigo-400/80 transition-all duration-200 cursor-pointer space-y-2.5 active:scale-[0.99]" onclick="window.location.href='{{ route('complaints.show', $c->id) }}'">
                            <div class="flex justify-between items-start gap-2">
                                <span class="font-mono text-[9px] font-bold text-slate-400">{{ $c->complaint_number }}</span>
                                <x-badge variant="warning" class="text-[7px] py-0 px-1">{{ $c->priority->label() }}</x-badge>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900 line-clamp-2 leading-relaxed">{{ $c->subject }}</h4>
                            
                            @if($c->maintenanceTask)
                                <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200/60 text-[9px] font-semibold text-slate-600">
                                    <p class="font-bold text-slate-800">Tugas: {{ $c->maintenanceTask->task_number }}</p>
                                    <p class="mt-0.5 text-slate-450">Staf: {{ $c->maintenanceTask->assignedStaff ? $c->maintenanceTask->assignedStaff->name : 'Belum Ditugaskan' }}</p>
                                </div>
                            @endif

                            <div class="border-t border-slate-100 pt-2 flex justify-between items-center text-[9px] text-slate-400 font-medium">
                                <span class="truncate max-w-[80px]">{{ $c->boardingHouse->name }}</span>
                                <span class="font-bold text-slate-700 flex-shrink-0">Kamar {{ $c->room ? $c->room->room_number : '—' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-[10px] italic text-slate-400 py-8">Kosong</p>
                    @endforelse
                </div>
            </div>

            <!-- Column 4: Completed / Resolved / Closed -->
            <div class="bg-slate-50/60 border border-slate-200/50 p-4 rounded-2xl space-y-3 min-h-[480px]">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                    <span class="text-xs font-black text-slate-800 tracking-tight">Selesai &amp; Ditutup</span>
                    <span class="text-[10px] bg-slate-200/60 text-slate-600 px-2 py-0.5 rounded-lg font-bold">{{ count($kanbanComplaints['completed']) }}</span>
                </div>

                <div class="space-y-3 max-h-[600px] overflow-y-auto pr-1">
                    @forelse($kanbanComplaints['completed'] as $c)
                        <div class="bg-white p-4 border border-slate-200/60 rounded-2xl shadow-2xs hover:shadow-sm hover:border-indigo-400/80 transition-all duration-200 cursor-pointer space-y-2.5 active:scale-[0.99]" onclick="window.location.href='{{ route('complaints.show', $c->id) }}'">
                            <div class="flex justify-between items-start gap-2">
                                <span class="font-mono text-[9px] font-bold text-slate-400">{{ $c->complaint_number }}</span>
                                <x-badge variant="success" class="text-[7px] py-0 px-1">{{ $c->priority->label() }}</x-badge>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900 line-clamp-2 leading-relaxed">{{ $c->subject }}</h4>
                            
                            <div class="border-t border-slate-100 pt-2 flex justify-between items-center text-[9px] text-slate-400 font-medium">
                                <span class="truncate max-w-[80px]">{{ $c->boardingHouse->name }}</span>
                                <span class="font-bold text-slate-700 flex-shrink-0">Kamar {{ $c->room ? $c->room->room_number : '—' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-[10px] italic text-slate-400 py-8">Kosong</p>
                    @endforelse
                </div>
            </div>

        </div>
    @endif

    <!-- CREATE COMPLAINT MODAL -->
    <x-modal wire:model="showCreateModal" title="Buat Laporan Komplain Baru" maxWidth="lg">
        <form wire:submit.prevent="storeComplaint" class="space-y-4">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Resident/Tenant Selection -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Penghuni Pelapor</label>
                    <select wire:model.live="resident_id" required class="input-base text-xs">
                        <option value="">Pilih Penghuni...</option>
                        @foreach($residents as $res)
                            <option value="{{ $res->id }}">{{ $res->name }} (Kamar: {{ $res->room ? $res->room->room_number : '—' }})</option>
                        @endforeach
                    </select>
                    @error('resident_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Kategori</label>
                    <select wire:model="category" required class="input-base text-xs">
                        <option value="electricity">Listrik</option>
                        <option value="water">Air</option>
                        <option value="bathroom">Kamar Mandi</option>
                        <option value="ac">Air Conditioner (AC)</option>
                        <option value="internet">Internet / Wi-Fi</option>
                        <option value="furniture">Furnitur / Kasur</option>
                        <option value="door">Pintu / Kunci</option>
                        <option value="roof">Atap Bocor</option>
                        <option value="kitchen">Dapur</option>
                        <option value="security">Keamanan</option>
                        <option value="cleaning">Kebersihan</option>
                        <option value="other">Lainnya</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Boarding house -->
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-1.5">Kos (Otomatis)</label>
                    <select wire:model="boarding_house_id" disabled class="input-base bg-slate-100 text-slate-500 cursor-not-allowed text-xs">
                        @foreach($boardingHouses as $house)
                            <option value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Room -->
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-1.5">Kamar (Otomatis)</label>
                    <select wire:model="room_id" disabled class="input-base bg-slate-100 text-slate-500 cursor-not-allowed text-xs">
                        <option value="">Pilih Kamar...</option>
                        @foreach($availableRooms as $room)
                            <option value="{{ $room->id }}">Kamar {{ $room->room_number }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Priority -->
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1.5">Tingkat Prioritas</label>
                <div class="grid grid-cols-5 gap-2 text-center">
                    @foreach(['low' => 'Rendah', 'normal' => 'Normal', 'high' => 'Tinggi', 'critical' => 'Kritis', 'emergency' => 'Darurat'] as $val => $lbl)
                        <label class="flex flex-col items-center justify-center p-2.5 border rounded-2xl cursor-pointer text-[10px] font-black tracking-tight transition-all active:scale-95 {{ $priority === $val ? 'bg-indigo-50 border-indigo-500 text-indigo-700 shadow-xs' : 'bg-slate-50/50 border-slate-200/80 hover:bg-slate-50 hover:border-slate-300' }}">
                            <input type="radio" wire:model="priority" value="{{ $val }}" class="sr-only">
                            {{ $lbl }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Subject -->
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1.5">Subjek Komplain</label>
                <input wire:model="subject" type="text" required class="input-base text-xs" placeholder="Misal: AC kamar tidak dingin / Kran bocor">
                @error('subject') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1.5">Deskripsi Lengkap Kendala</label>
                <textarea wire:model="description" rows="3" required class="input-base text-xs" placeholder="Berikan deskripsi detail kendala yang terjadi agar dapat diproses oleh teknisi..."></textarea>
                @error('description') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Internal private notes -->
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1.5">Catatan Internal Staf (Tidak terlihat oleh penghuni)</label>
                <input wire:model="internal_notes" type="text" class="input-base text-xs" placeholder="Catatan internal kantor...">
            </div>

            <div class="flex justify-end gap-2.5 pt-2 border-t border-slate-100/80">
                <x-button variant="outline" size="sm" @click="show = false">Batal</x-button>
                <x-button variant="primary" size="sm" type="submit" :loading="'storeComplaint'">Laporkan Masalah</x-button>
            </div>
        </form>
    </x-modal>

</div>
