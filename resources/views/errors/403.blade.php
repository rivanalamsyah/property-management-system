@extends('errors.layout')

@section('title', 'Akses Ditolak')
@section('code', '403')
@section('message', 'Akses Tidak Diizinkan')
@section('description', 'Anda tidak memiliki izin untuk mengakses halaman atau sumber daya ini. Hubungi administrator jika Anda yakin ini keliru.')

@section('illustration')
<div class="flex justify-center float-anim">
    <svg class="w-32 h-32 text-rose-300" fill="none" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
        <circle cx="100" cy="100" r="80" fill="#fca5a5" opacity="0.08"/>
        <path d="M100 30 L170 150 H30 Z" stroke="currentColor" stroke-width="6" fill="none" stroke-linejoin="round" opacity="0.5"/>
        <line x1="100" y1="80" x2="100" y2="115" stroke="currentColor" stroke-width="7" stroke-linecap="round" opacity="0.8"/>
        <circle cx="100" cy="133" r="5" fill="currentColor" opacity="0.8"/>
    </svg>
</div>
@endsection

@section('extra_action')
<a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200/50 rounded-2xl transition duration-150 cursor-pointer">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    Halaman Sebelumnya
</a>
@endsection
