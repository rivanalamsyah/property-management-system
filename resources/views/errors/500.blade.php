@extends('errors.layout')

@section('title', 'Kesalahan Server Internal')
@section('code', '500')
@section('message', 'Terjadi Kesalahan Server')
@section('description', 'Kami mengalami masalah internal yang tidak terduga. Tim teknis kami sudah diberitahu dan sedang berupaya memperbaikinya secepatnya.')

@section('illustration')
<div class="flex justify-center float-anim">
    <svg class="w-36 h-32 text-rose-400" fill="none" viewBox="0 0 240 200" xmlns="http://www.w3.org/2000/svg">
        <!-- Server cabinet -->
        <rect x="70" y="40" width="100" height="130" rx="10" stroke="currentColor" stroke-width="5" fill="none" opacity="0.45"/>
        <!-- Server rows -->
        <rect x="82" y="60" width="76" height="12" rx="4" stroke="currentColor" stroke-width="3" fill="none" opacity="0.4"/>
        <rect x="82" y="80" width="76" height="12" rx="4" stroke="currentColor" stroke-width="3" fill="none" opacity="0.4"/>
        <rect x="82" y="100" width="76" height="12" rx="4" stroke="currentColor" stroke-width="3" fill="none" opacity="0.4"/>
        <!-- Error indicators -->
        <circle cx="148" cy="66" r="3.5" fill="#f87171" opacity="0.9"/>
        <circle cx="148" cy="86" r="3.5" fill="#f87171" opacity="0.9"/>
        <circle cx="148" cy="106" r="3.5" fill="#fbbf24" opacity="0.9"/>
        <!-- Smoke/warning lines -->
        <path d="M120 35 Q123 28 120 22 Q117 16 120 10" stroke="currentColor" stroke-width="3" stroke-linecap="round" fill="none" opacity="0.35"/>
        <path d="M130 35 Q133 26 130 18" stroke="currentColor" stroke-width="3" stroke-linecap="round" fill="none" opacity="0.3"/>
    </svg>
</div>
@endsection

@section('extra_action')
<button onclick="window.location.reload()" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200/50 rounded-2xl transition duration-150 cursor-pointer">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
    Coba Lagi
</button>
@endsection
