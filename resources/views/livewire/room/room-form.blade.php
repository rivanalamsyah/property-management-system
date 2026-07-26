<div class="space-y-6" x-data="{ activeTab: @entangle('activeTab') }">
    
    <!-- Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ $roomId ? 'Configure Room ' . $room_number : 'Create Room' }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">Configure room sizes, block assignments, facilities list, image catalogs, and download local check-in QR codes.</p>
        </div>
        <div class="flex-shrink-0">
            <x-button variant="outline" size="sm" onclick="window.location.href='{{ route('rooms') }}'">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Rooms
                </span>
            </x-button>
        </div>
    </div>

    <!-- Wizard Navigation Tabs -->
    @if($roomId)
        <div class="border-b border-slate-100 flex flex-wrap gap-2 mb-6">
            <button @click="activeTab = 'profile'" :class="{"border-indigo-600 text-indigo-600   activeTab === 'profile', 'border-transparent text-slate-500 hover:text-slate-700  activeTab !== 'profile'}"
                class="px-4 py-2.5 text-sm font-semibold border-b-2 transition cursor-pointer">Profile Info</button>
            <button @click="activeTab = 'facilities'" :class="{"border-indigo-600 text-indigo-600   activeTab === 'facilities', 'border-transparent text-slate-500 hover:text-slate-700  activeTab !== 'facilities'}"
                class="px-4 py-2.5 text-sm font-semibold border-b-2 transition cursor-pointer">Room Facilities</button>
            <button @click="activeTab = 'gallery'" :class="{"border-indigo-600 text-indigo-600   activeTab === 'gallery', 'border-transparent text-slate-500 hover:text-slate-700  activeTab !== 'gallery'}"
                class="px-4 py-2.5 text-sm font-semibold border-b-2 transition cursor-pointer">Image Gallery</button>
            <button @click="activeTab = 'qr'" :class="{"border-indigo-600 text-indigo-600   activeTab === 'qr', 'border-transparent text-slate-500 hover:text-slate-700  activeTab !== 'qr'}"
                class="px-4 py-2.5 text-sm font-semibold border-b-2 transition cursor-pointer">Local QR Code</button>
        </div>
    @endif

    <!-- Content Sections -->

    <!-- Tab 1: Profile -->
    <div x-show="activeTab === 'profile'" class="space-y-6">
        <x-card title="Room Specifications & Pricing" description="Select property destination, room identity codes, rents, deposits, and status parameters.">
            <form wire:submit="saveProfile" class="space-y-5">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Boarding House select -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Property Boarding House</label>
                        <select wire:model="boarding_house_id" {{ $roomId ? 'disabled' : '' }} required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm disabled:opacity-60">
                            <option value="">Select Property...</option>
                            @foreach($boardingHouses as $house)
                                <option value="{{ $house->id }}">{{ $house->name }}</option>
                            @endforeach
                        </select>
                        @error('boarding_house_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Room number -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Room Number</label>
                        <input wire:model="room_number" type="text" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                            placeholder="e.g. 101, A-03">
                        @error('room_number') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Room name -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Room Label/Name (Optional)</label>
                        <input wire:model="room_name" type="text"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                            placeholder="e.g. Deluxe Room, Single VIP">
                        @error('room_name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <!-- Floor -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Floor Level</label>
                        <input wire:model="floor" type="number" required min="1"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        @error('floor') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Block -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Building Block</label>
                        <input wire:model="building_block" type="text"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                            placeholder="e.g. A, Block Timur">
                        @error('building_block') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Room Type</label>
                        <select wire:model="room_type"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                            <option value="Standard">Standard</option>
                            <option value="Deluxe">Deluxe</option>
                            <option value="Suite">Suite</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>

                    <!-- Room size -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Room Size (meters)</label>
                        <input wire:model="room_size" type="text"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm"
                            placeholder="e.g. 3x4, 4x5">
                        @error('room_size') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Pricing & Occupancy limits -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5 pt-4 border-t border-slate-50">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Monthly Rent (IDR)</label>
                        <input wire:model="monthly_rent" type="number" required min="0" step="1000"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        @error('monthly_rent') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Security Deposit (IDR)</label>
                        <input wire:model="security_deposit" type="number" required min="0" step="1000"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        @error('security_deposit') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Max Occupants</label>
                        <input wire:model="max_occupants" type="number" required min="1"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                        @error('max_occupants') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Gender Restriction</label>
                        <select wire:model="gender_restriction"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                            <option value="any">Any / Mixed</option>
                            <option value="male">Male Only</option>
                            <option value="female">Female Only</option>
                        </select>
                    </div>
                </div>

                <!-- Status & Publish flags -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-4 border-t border-slate-50">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Availability Status</label>
                        <select wire:model="status"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                            <option value="reserved">Reserved</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="cleaning">Cleaning</option>
                            <option value="unavailable">Unavailable</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <label class="flex items-center text-sm font-medium text-slate-700 cursor-pointer select-none">
                            <input type="checkbox" wire:model="is_published" class="h-4 w-4 rounded border-slate-350 text-indigo-600 focus:ring-indigo-500 mr-2">
                            Publish on public search site
                        </label>
                    </div>
                </div>

                <!-- Occupied Override Checkbox (Shown only when status is occupied) -->
                @if($status === 'occupied' && $roomId)
                    <div class="p-4 bg-amber-50 rounded-xl border border-amber-250/55 flex items-start gap-3">
                        <input type="checkbox" wire:model="overrideActiveCheck" id="override_chk" class="mt-1 h-4 w-4 rounded border-amber-400 text-amber-600 focus:ring-amber-500 cursor-pointer">
                        <div>
                            <label for="override_chk" class="text-sm font-semibold text-amber-800 cursor-pointer select-none">Authorize modification on occupied room</label>
                            <p class="text-xs text-amber-600 mt-0.5">Rent updates or room number changes on occupied rooms may desynchronize active contract billings. Check this to authorize edit bypass.</p>
                        </div>
                    </div>
                @endif

                <!-- Description & Internal notes -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-4 border-t border-slate-50">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Description (Publicly visible)</label>
                        <textarea wire:model="description" rows="3" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="Public description about windows, balcony view, bed type..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Internal Notes (Staff only)</label>
                        <textarea wire:model="internal_notes" rows="3" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="Add staff only notes (e.g. wall paint code, broken sockets, key location)..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-50">
                    <x-button type="submit" variant="primary" size="sm" loading="saveProfile">
                        {{ $roomId ? 'Save Room Spec Changes' : 'Create Room Specification & Proceed' }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>

    <!-- Tab 2: Facilities -->
    <div x-show="activeTab === 'facilities'" class="space-y-6">
        <x-card title="Room Facilities Assignment" description="Check facilities matching this room. Dynamic options are pulled from your active property catalog.">
            <form wire:submit="saveFacilities" class="space-y-5">
                
                <!-- Facility Search Inside Tab -->
                <div class="relative w-full max-w-sm mb-4">
                    <input wire:model.live.debounce.250ms="facilitySearch" type="text"
                        class="w-full pl-9 pr-4 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none text-xs"
                        placeholder="Search workspace facilities catalog...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                @php
                    $groupedFacilities = $allFacilities->groupBy('category');
                @endphp

                @forelse($groupedFacilities as $categoryName => $facilitiesList)
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold text-slate-700 border-b border-slate-50 pb-1.5">{{ $categoryName }} Facilities</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($facilitiesList as $facilityItem)
                                <label class="flex items-center gap-3 p-3 border border-slate-100 rounded-xl bg-slate-50/30 cursor-pointer select-none">
                                    <input type="checkbox" wire:model="selectedFacilities" value="{{ $facilityItem->id }}"
                                        class="h-4.5 w-4.5 rounded border-slate-350 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-xs text-slate-700 font-semibold">
                                        {{ $facilityItem->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <x-empty-state title="No facilities found" description="Create facilities in the Catalog tab first before mapping them to rooms."></x-empty-state>
                @endforelse

                <div class="flex justify-end pt-4 border-t border-slate-50">
                    <x-button type="submit" variant="primary" size="sm" loading="saveFacilities">Save Selected Facilities</x-button>
                </div>
            </form>
        </x-card>
    </div>

    <!-- Tab 3: Gallery -->
    <div x-show="activeTab === 'gallery'" class="space-y-6">
        <x-card title="Room Media Galleries" description="Upload horizontal high-resolution rooms pictures. Cover designates the image shown in listing grids.">
            
            <!-- Uploader Form -->
            <form wire:submit="uploadGalleryImage" class="space-y-4 pb-6 border-b border-slate-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-end">
                    <!-- File input -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Choose Photo</label>
                        <input type="file" wire:model="galleryUpload" accept="image/*"
                            class="w-full px-4 py-2 bg-slate-50/50 border border-slate-250 border-dashed rounded-xl text-slate-500 text-sm focus:outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-650 file:cursor-pointer">
                        @error('galleryUpload') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Label -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Photo Caption</label>
                        <div class="flex items-center gap-2">
                            <input wire:model="galleryLabel" type="text" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Bed View, Bathroom Area">
                            <x-button variant="primary" size="sm" type="submit" loading="uploadGalleryImage">Upload</x-button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Grid Previews -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 mt-6">
                @forelse($galleryList as $galleryItem)
                    <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm flex flex-col group relative">
                        <div class="h-32 bg-slate-50 relative">
                            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $galleryItem->file_path) }}" alt="{{ $galleryItem->label }}">
                            
                            @if($galleryItem->is_cover)
                                <div class="absolute top-2 left-2">
                                    <x-badge variant="success" class="text-[8px] uppercase font-bold py-0.5 px-2">Cover</x-badge>
                                </div>
                            @endif

                            <!-- Sort buttons -->
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
                                {{ $galleryItem->label ?: 'No caption' }}
                            </p>
                            
                            <div class="flex items-center gap-1.5">
                                @if(!$galleryItem->is_cover)
                                    <x-button variant="outline" size="sm" class="w-full py-1! text-[10px]" wire:click="setAsCover({{ $galleryItem->id }})">Set Cover</x-button>
                                @endif
                                <x-button variant="outline" size="sm" class="py-1! px-2! text-[10px] text-rose-600 hover:bg-rose-50 border-slate-200 hover:border-rose-100 cursor-pointer" wire:click="deleteGalleryImage({{ $galleryItem->id }})">
                                    Delete
                                </x-button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <x-empty-state title="No gallery images uploaded" description="Upload pictures to showcase your room details (bed types, bathroom setup, window view) for prospective tenants."></x-empty-state>
                    </div>
                @endforelse
            </div>

        </x-card>
    </div>

    <!-- Tab 4: QR Code -->
    <div x-show="activeTab === 'qr'" class="space-y-6">
        <x-card title="Local QR Check-in Code" description="Generated automatically for every room. Can be scanned by mobile devices for quick contract check-ins or logging complaints.">
            
            <div class="flex flex-col md:flex-row items-center gap-8 py-4">
                @if($room && $room->qr_code_path)
                    <div class="bg-white p-4 border border-slate-100 rounded-2xl shadow-sm">
                        <img class="w-48 h-48" src="{{ asset('storage/' . $room->qr_code_path) }}" alt="Room QR Code">
                    </div>
                    
                    <div class="space-y-4 max-w-lg">
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">Active Room Code</h4>
                            <p class="text-sm text-indigo-600 font-mono mt-0.5">{{ $room->room_code }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-bold text-slate-800">Scanning Destination URI</h4>
                            <p class="text-xs text-slate-400 font-mono mt-0.5">http://kosan.test/rooms/check-in/{{ $room->room_code }}</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <x-button variant="primary" size="sm" onclick="const a = document.createElement('a'); a.href='{{ asset('storage/' . $room->qr_code_path) }}'; a.download='{{ $room->room_code }}_qrcode.png'; a.click();">
                                Download PNG
                            </x-button>
                            
                            <x-button variant="outline" size="sm" wire:click="regenerateQrCode" loading="regenerateQrCode">
                                Regenerate QR Code
                            </x-button>
                        </div>
                    </div>
                @else
                    <x-empty-state title="No QR Code Generated" description="QR codes are generated automatically when saving room details. Check back once you save."></x-empty-state>
                @endif
            </div>

        </x-card>
    </div>

</div>
