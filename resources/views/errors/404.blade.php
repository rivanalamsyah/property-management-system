@extends('errors.layout')

@section('title', 'Halaman Tidak Ditemukan')
@section('code', '404')
@section('message', 'Halaman Tidak Ditemukan')
@section('description', 'Halaman yang Anda cari tidak tersedia atau telah dipindahkan. Pastikan URL yang Anda masukkan sudah benar.')

@section('illustration')
<div class="flex justify-center float-anim">
    <svg class="w-36 h-36 text-indigo-300" fill="none" viewBox="0 0 240 200" xmlns="http://www.w3.org/2000/svg">
        <!-- Telescope body -->
        <rect x="80" y="90" width="100" height="20" rx="10" stroke="currentColor" stroke-width="5" fill="none" opacity="0.6" transform="rotate(-30 130 100)"/>
        <!-- Lens -->
        <circle cx="160" cy="70" r="18" stroke="currentColor" stroke-width="5" fill="none" opacity="0.6"/>
        <!-- Stand -->
        <line x1="100" y1="130" x2="80" y2="165" stroke="currentColor" stroke-width="5" stroke-linecap="round" opacity="0.5"/>
        <line x1="100" y1="130" x2="120" y2="165" stroke="currentColor" stroke-width="5" stroke-linecap="round" opacity="0.5"/>
        <!-- Stars -->
        <circle cx="40" cy="40" r="3" fill="currentColor" opacity="0.4"/>
        <circle cx="200" cy="30" r="2.5" fill="currentColor" opacity="0.4"/>
        <circle cx="220" cy="100" r="2" fill="currentColor" opacity="0.3"/>
        <circle cx="20" cy="110" r="2.5" fill="currentColor" opacity="0.3"/>
        <!-- X in lens -->
        <line x1="152" y1="62" x2="168" y2="78" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity="0.7"/>
        <line x1="168" y1="62" x2="152" y2="78" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity="0.7"/>
    </svg>
</div>
@endsection

@section('extra_action')
<a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200/50 rounded-2xl transition duration-150 cursor-pointer">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    Halaman Sebelumnya
</a>
@endsection
