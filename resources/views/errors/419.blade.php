@extends('errors.layout')

@section('title', 'Halaman Kedaluwarsa')
@section('code', '419')
@section('message', 'Sesi Halaman Kedaluwarsa')
@section('description', 'Token keamanan halaman ini sudah tidak berlaku. Ini biasanya terjadi setelah lama tidak aktif. Silakan muat ulang halaman dan coba kembali.')

@section('illustration')
<div class="flex justify-center float-anim">
    <svg class="w-32 h-32 text-amber-400" fill="none" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
        <!-- Clock circle -->
        <circle cx="100" cy="100" r="65" stroke="currentColor" stroke-width="6" fill="none" opacity="0.5"/>
        <!-- Clock hands (expired - past 12) -->
        <line x1="100" y1="100" x2="100" y2="55" stroke="currentColor" stroke-width="6" stroke-linecap="round" opacity="0.8"/>
        <line x1="100" y1="100" x2="128" y2="120" stroke="currentColor" stroke-width="5" stroke-linecap="round" opacity="0.8"/>
        <!-- Center dot -->
        <circle cx="100" cy="100" r="5" fill="currentColor" opacity="0.9"/>
        <!-- Refresh arrow -->
        <path d="M155 70 A65 65 0 0 1 155 130" stroke="currentColor" stroke-width="5" stroke-linecap="round" fill="none" opacity="0.4"/>
        <polygon points="155,125 165,137 143,140" fill="currentColor" opacity="0.5"/>
    </svg>
</div>
@endsection

@section('extra_action')
<button onclick="window.location.reload()" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200/50 rounded-2xl transition duration-150 cursor-pointer">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
    Muat Ulang Halaman
</button>
@endsection
