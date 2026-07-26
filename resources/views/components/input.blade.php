@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full rounded-xl border border-slate-200/90 bg-white py-2.5 px-3.5 text-xs sm:text-sm text-slate-900 placeholder-slate-400 shadow-2xs focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150 disabled:bg-slate-50 disabled:text-slate-400 disabled:cursor-not-allowed']) !!}>
