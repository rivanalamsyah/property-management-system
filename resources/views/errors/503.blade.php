@extends('errors.layout')

@section('title', 'Layanan Tidak Tersedia')
@section('code', '503')
@section('message', 'Sedang Dalam Pemeliharaan')
@section('description', 'Platform Kosan sedang menjalani pemeliharaan terjadwal untuk meningkatkan layanan. Kami akan kembali online dalam beberapa saat.')

@section('illustration')
<div class="flex justify-center float-anim">
    <svg class="w-36 h-32 text-violet-400" fill="none" viewBox="0 0 240 200" xmlns="http://www.w3.org/2000/svg">
        <!-- Hard hat -->
        <path d="M80 110 Q80 65 120 58 Q160 65 160 110 Z" stroke="currentColor" stroke-width="5" fill="none" opacity="0.5"/>
        <rect x="68" y="108" width="104" height="14" rx="7" stroke="currentColor" stroke-width="5" fill="none" opacity="0.6"/>
        <!-- Wrench -->
        <path d="M110 140 L145 105" stroke="currentColor" stroke-width="6" stroke-linecap="round" opacity="0.6"/>
        <circle cx="108" cy="143" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.55"/>
        <circle cx="147" cy="102" r="9" stroke="currentColor" stroke-width="4" fill="none" opacity="0.55"/>
        <!-- Gear -->
        <circle cx="170" cy="155" r="16" stroke="currentColor" stroke-width="4" fill="none" opacity="0.4"/>
        <circle cx="170" cy="155" r="6" stroke="currentColor" stroke-width="3" fill="none" opacity="0.4"/>
    </svg>
</div>
@endsection

@section('extra_action')
<a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-violet-700 bg-violet-50 hover:bg-violet-100 border border-violet-200/50 rounded-2xl transition duration-150 cursor-pointer">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 3H3a2 2 0 00-2 2v12a2 2 0 002 2h5l3 3 3-3h5a2 2 0 002-2V5a2 2 0 00-2-2z"/></svg>
    Hubungi Dukungan
</a>
@endsection
