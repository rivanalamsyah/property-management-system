@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-xs text-rose-500 font-semibold mt-1 flex items-center gap-1 animate-fade-in']) }}>
        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>{{ $message }}</span>
    </p>
@enderror
