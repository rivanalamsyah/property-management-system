@extends('errors.layout')

@section('title', 'Tidak Terautentikasi')
@section('code', '401')
@section('message', 'Autentikasi Diperlukan')
@section('description', 'Anda harus masuk terlebih dahulu untuk mengakses halaman ini. Silakan login dengan akun yang valid.')

@section('illustration')
<div class="flex justify-center float-anim">
    <svg class="w-32 h-32 text-indigo-300" fill="none" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
        <circle cx="100" cy="100" r="80" fill="url(#err401-grad)" opacity="0.08"/>
        <circle cx="100" cy="76" r="24" stroke="currentColor" stroke-width="6" fill="none" opacity="0.5"/>
        <rect x="60" y="108" width="80" height="52" rx="10" stroke="currentColor" stroke-width="6" fill="none" opacity="0.5"/>
        <line x1="80" y1="134" x2="80" y2="140" stroke="currentColor" stroke-width="6" stroke-linecap="round" opacity="0.7"/>
        <line x1="100" y1="134" x2="100" y2="140" stroke="currentColor" stroke-width="6" stroke-linecap="round" opacity="0.7"/>
        <line x1="120" y1="134" x2="120" y2="140" stroke="currentColor" stroke-width="6" stroke-linecap="round" opacity="0.7"/>
        <defs><radialGradient id="err401-grad" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#6366f1"/><stop offset="100%" stop-color="#7c3aed"/></radialGradient></defs>
    </svg>
</div>
@endsection

@section('extra_action')
<a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200/50 rounded-2xl transition duration-150 cursor-pointer">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
    Masuk ke Akun
</a>
@endsection
