@extends('errors.layout')

@section('title', 'Terlalu Banyak Permintaan')
@section('code', '429')
@section('message', 'Terlalu Banyak Permintaan')
@section('description', 'Anda telah melakukan terlalu banyak percobaan dalam waktu singkat. Tunggu beberapa saat sebelum mencoba kembali.')

@section('illustration')
<div class="flex justify-center float-anim">
    <svg class="w-32 h-32 text-orange-400" fill="none" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
        <!-- Server/stack blocks -->
        <rect x="50" y="60" width="100" height="22" rx="6" stroke="currentColor" stroke-width="5" fill="none" opacity="0.5"/>
        <rect x="50" y="89" width="100" height="22" rx="6" stroke="currentColor" stroke-width="5" fill="none" opacity="0.55"/>
        <rect x="50" y="118" width="100" height="22" rx="6" stroke="currentColor" stroke-width="5" fill="none" opacity="0.6"/>
        <!-- Indicator dots -->
        <circle cx="70" cy="71" r="4" fill="currentColor" opacity="0.8"/>
        <circle cx="70" cy="100" r="4" fill="currentColor" opacity="0.8"/>
        <circle cx="70" cy="129" r="4" fill="currentColor" opacity="0.8"/>
        <!-- Overload bolt -->
        <path d="M108 48 L95 75 H110 L97 102" stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" opacity="0.7"/>
    </svg>
</div>
@endsection

@section('extra_action')
<button onclick="window.history.back()" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200/50 rounded-2xl transition duration-150 cursor-pointer">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    Kembali
</button>
@endsection
