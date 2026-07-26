@props(['value'])

<label {!! $attributes->merge(['class' => 'block text-xs font-bold text-slate-700 tracking-tight mb-1 cursor-pointer select-none']) !!}>
    {{ $value ?? $slot }}
</label>
