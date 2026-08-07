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
<div class="flex flex-col items-center gap-4 w-full">
    <div class="flex flex-wrap justify-center gap-3">
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200/50 rounded-2xl transition duration-150 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Halaman Sebelumnya
        </a>

        @auth
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200/50 rounded-2xl transition duration-150 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar Akun
                </button>
            </form>
        @endauth
    </div>

    @auth
        @php
            $otherTenants = auth()->user()->tenants()
                ->where('is_active', true)
                ->where('status', \App\Enums\WorkspaceStatus::ACTIVE)
                ->get();
        @endphp

        @if($otherTenants->count() > 0)
            <div class="w-full max-w-sm mt-4 p-5 bg-white border border-slate-200/80 rounded-3xl text-left space-y-3">
                <p class="text-xs font-bold text-slate-450 uppercase tracking-widest text-center">Beralih ke Properti Lain</p>
                <div class="space-y-1.5">
                    @foreach($otherTenants as $t)
                        <a href="{{ route('tenant.switch', $t->id) }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl border border-slate-100 hover:border-indigo-100 hover:bg-indigo-50/40 text-xs font-bold text-slate-700 hover:text-indigo-700 transition">
                            <div class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-[9px] font-black uppercase">
                                {{ substr($t->name, 0, 2) }}
                            </div>
                            <span class="truncate">{{ $t->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    @endauth
</div>
@endsection
