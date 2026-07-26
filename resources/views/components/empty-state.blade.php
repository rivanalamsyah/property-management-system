@props([
    'title' => 'Belum Ada Data Terkait',
    'description' => 'Mulai tambahkan data atau sesuaikan filter pencarian Anda.',
    'icon' => 'folder-open',
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center text-center p-8 sm:p-12 bg-white border border-dashed border-slate-200 rounded-2xl']) }}>
    <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 mb-4">
        @if($icon === 'folder-open')
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path>
            </svg>
        @else
            {{ $icon }}
        @endif
    </div>
    
    <h3 class="text-sm font-semibold text-slate-900">{{ $title }}</h3>
    <p class="text-xs text-slate-500 mt-1 max-w-sm">{{ $description }}</p>

    @if($slot->isNotEmpty())
        <div class="mt-5">
            {{ $slot }}
        </div>
    @endif
</div>
