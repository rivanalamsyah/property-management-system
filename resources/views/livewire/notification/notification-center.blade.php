<div x-data="{ open: false }" class="relative z-40">
    <!-- Bell Button -->
    <button @click="open = !open" class="relative p-2 text-slate-400 hover:text-slate-600 transition focus:outline-none cursor-pointer">
        <span class="sr-only">Notifications</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        
        @if($unreadCount > 0)
            <span class="absolute top-1.5 right-1.5 block h-4 w-4 rounded-full bg-rose-500 text-[9px] font-extrabold text-white text-center leading-4 select-none">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" @click.away="open = false" 
        x-transition:enter="transition ease-out duration-100" 
        x-transition:enter-start="transform opacity-0 scale-95" 
        x-transition:enter-end="transform opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-75" 
        x-transition:leave-start="transform opacity-100 scale-100" 
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 bg-white border border-slate-100 rounded-2xl shadow-xl overflow-hidden text-xs" style="display: none;">
        
        <!-- Header -->
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <span class="font-bold text-slate-800">Notifications center</span>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-[10px] text-indigo-650 font-bold hover:underline cursor-pointer">
                    Mark all read
                </button>
            @endif
        </div>

        <!-- Notification List -->
        <div class="max-h-64 overflow-y-auto divide-y divide-slate-50">
            @forelse($notifications as $notif)
                <div class="p-3.5 flex items-start gap-2.5 transition {{ !$notif->read_at ? 'bg-indigo-50/10' : '' }}">
                    <!-- Status dot -->
                    @if(!$notif->read_at)
                        <span class="mt-1.5 h-2 w-2 rounded-full bg-indigo-500 flex-shrink-0"></span>
                    @else
                        <span class="mt-1.5 h-2 w-2 rounded-full bg-transparent flex-shrink-0"></span>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-slate-800 leading-snug">
                            {{ $notif->data['title'] ?? 'Office update notice' }}
                        </p>
                        @if(isset($notif->data['message']))
                            <p class="text-slate-500 mt-0.5 leading-normal">{{ $notif->data['message'] }}</p>
                        @elseif(isset($notif->data['summary']))
                            <p class="text-slate-500 mt-0.5 leading-normal">{{ $notif->data['summary'] }}</p>
                        @endif
                        
                        <div class="mt-2 flex justify-between items-center text-[10px] text-slate-400">
                            <span>{{ $notif->created_at->diffForHumans() }}</span>
                            @if(!$notif->read_at)
                                <button wire:click="markAsRead('{{ $notif->id }}')" class="text-indigo-650 font-bold hover:underline cursor-pointer">Mark read</button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-slate-400 italic">
                    <p>No notifications logged</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
