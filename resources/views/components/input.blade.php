@props(['disabled' => false, 'icon' => null])

@if($icon)
<div class="relative">
    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-slate-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {!! $icon !!}
        </svg>
    </div>
    <input {{ $disabled ? 'disabled' : '' }}
           {!! $attributes->merge(['class' => 'input-base input-with-icon']) !!}>
</div>
@else
<input {{ $disabled ? 'disabled' : '' }}
       {!! $attributes->merge(['class' => 'input-base']) !!}>
@endif
