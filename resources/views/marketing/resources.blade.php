<x-marketing-layout :meta_title="$meta_title" :meta_description="$meta_description" :canonical="$canonical">

    @push('schema')
    <!-- Articles Hub Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Blog",
      "name": "Pusat Panduan & Artikel Kosan",
      "description": "Panduan praktis dan artikel dari pakar untuk meningkatkan okupansi kos dan mengotomatisasi penagihan sewa.",
      "publisher": {
        "@@type": "Organization",
        "name": "Kosan"
      }
    }
    </script>
    @endpush

    <!-- Resources Custom Styles -->
    <style>
        .resources-mesh {
            background-image: radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.04), transparent 50%);
        }
    </style>

    <!-- Section 1: Hero Banner -->
    <section class="relative overflow-hidden pt-28 pb-12 text-center space-y-4 bg-slate-50/30 resources-mesh">
        <div class="absolute top-0 left-1/4 w-80 h-80 bg-purple-400/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
        
        <div class="max-w-4xl mx-auto px-6 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white border border-slate-200/60 text-slate-800 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                Pusat Panduan &amp; Blog
            </span>
            <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Insight &amp; Panduan <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600">Bisnis Properti Modern</span>
            </h1>
            <p class="text-slate-500 text-sm max-w-lg mx-auto leading-relaxed font-medium">
                Temukan tips praktis, panduan operasional hunian, dan saran regulasi hukum sewa dari spesialis bisnis properti kami.
            </p>
            
            <!-- Search Input Box -->
            <form action="{{ request()->url() }}" method="GET" class="max-w-md mx-auto pt-4 relative group">
                @if($activeCategory)
                    <input type="hidden" name="category" value="{{ $activeCategory }}">
                @endif
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-300"></div>
                <div class="relative flex gap-2 bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm">
                    <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Cari panduan sewa, tips hunian, dll..." aria-label="Cari artikel atau panduan"
                           class="flex-1 px-4 py-2.5 bg-transparent border-0 text-xs text-slate-900 placeholder-slate-400 focus:ring-0 focus:outline-hidden" />
                    <button type="submit" class="px-5 py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition cursor-pointer shadow-xs">Cari</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Section 2: Category Filter Grid -->
    <section class="py-6 bg-white border-b border-slate-150">
        <div class="max-w-7xl mx-auto px-6 flex flex-wrap justify-center gap-2">
            <a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => null]) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold {{ !$activeCategory ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-50 text-slate-650 hover:bg-slate-100 border border-slate-200/60' }} transition cursor-pointer">
               Semua Artikel
            </a>
            @foreach($categories as $cat)
                @if($cat->articles_count > 0)
                    <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug, 'page' => null]) }}" 
                       class="px-4 py-2 rounded-xl text-xs font-bold {{ $activeCategory === $cat->slug ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-50 text-slate-650 hover:bg-slate-100 border border-slate-200/60' }} transition cursor-pointer">
                       {{ $cat->name }}
                    </a>
                @endif
            @endforeach
        </div>
    </section>

    <!-- Section 3: Featured Article Showcase -->
    @if($featuredArticle)
    <section class="py-12 bg-slate-50/50">
        <div class="max-w-5xl mx-auto px-6">
            <a href="{{ route('blog.detail', ['slug' => $featuredArticle->slug]) }}" class="block p-6 bg-white border border-slate-200/80 rounded-3xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center shadow-sm hover:shadow-md transition-shadow group">
                <!-- Cover frame -->
                <div class="aspect-[4/3] overflow-hidden rounded-2xl shadow-inner border border-slate-100 bg-slate-50 relative">
                    @if($featuredArticle->featured_image)
                        <img src="{{ $featuredArticle->featured_image }}" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500" alt="{{ $featuredArticle->title }}">
                    @else
                        <div class="w-full h-full bg-gradient-to-tr from-indigo-500/5 to-purple-500/5 flex items-center justify-center">
                            <svg class="w-12 h-12 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>
                <div class="space-y-4 text-left">
                    <span class="text-[9px] font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2 py-0.5 rounded-md">
                        {{ $featuredArticle->categories->first()?->name ?? 'Insight' }}
                    </span>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight leading-tight group-hover:text-indigo-600 transition-colors">
                        {{ $featuredArticle->title }}
                    </h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        {{ $featuredArticle->excerpt }}
                    </p>
                    <div class="flex items-center gap-3 pt-2 text-xs font-bold text-slate-700">
                        <span>{{ $featuredArticle->author_name ?? 'Tim Kosan' }}</span>
                        <span class="text-[10px] text-slate-400 font-medium font-mono">&bull; {{ $featuredArticle->published_at ? $featuredArticle->published_at->translatedFormat('d M Y') : $featuredArticle->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
        </div>
    </section>
    @endif

    <!-- Section 4: Articles Grid -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            @if($articles->isEmpty())
                <!-- Empty State -->
                <div class="max-w-md mx-auto text-center py-12 space-y-4">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-400 border border-slate-100">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Artikel Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-450 leading-relaxed font-medium">Maaf, kami tidak menemukan artikel yang cocok dengan pencarian atau kategori ini. Coba ubah kata kunci Anda.</p>
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-xl text-xs font-bold transition">
                        Reset Semua Filter
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($articles as $art)
                        {{-- Skip featured article on page 1 --}}
                        @php if ($featuredArticle && $art->id === $featuredArticle->id && !$searchQuery && !$activeCategory && $articles->currentPage() === 1) continue; @endphp
                        <a href="{{ route('blog.detail', ['slug' => $art->slug]) }}" class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-xs hover:shadow-md hover:-translate-y-1 transition duration-200 flex flex-col h-full group">
                            <div class="h-40 bg-slate-100 overflow-hidden flex-shrink-0 relative">
                                @if($art->featured_image)
                                    <img src="{{ $art->featured_image }}" class="w-full h-full object-cover group-hover:scale-101.5 transition duration-300" alt="{{ $art->title }}">
                                @else
                                    <div class="w-full h-full bg-gradient-to-tr from-indigo-500/5 to-purple-500/5 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 flex flex-col justify-between flex-1 text-left">
                                <div class="space-y-3">
                                    <span class="text-[9px] font-extrabold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-2 py-0.5 rounded-md">
                                        {{ $art->categories->first()?->name ?? 'Insight' }}
                                    </span>
                                    <h4 class="text-base font-bold text-slate-900 tracking-tight group-hover:text-indigo-600 transition-colors leading-snug">{{ $art->title }}</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed font-medium line-clamp-3">{{ $art->excerpt }}</p>
                                </div>
                                <p class="text-[9.5px] text-slate-400 font-bold font-mono pt-4">
                                    {{ $art->published_at ? $art->published_at->translatedFormat('d M Y') : $art->created_at->format('d M Y') }} &bull; {{ $art->author_name ?? 'Tim Kosan' }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Custom styled Pagination Links -->
                @if($articles->hasPages())
                    <div class="mt-16 flex justify-center">
                        {{ $articles->links() }}
                    </div>
                @endif
            @endif
        </div>
    </section>

    <!-- Section 5: Case Study Showcase -->
    <section class="py-20 bg-slate-50/50">
        <div class="max-w-5xl mx-auto px-6">
            <div class="p-8 bg-gradient-to-r from-indigo-900 to-indigo-950 text-white rounded-3xl space-y-6 relative overflow-hidden shadow-xl text-left">
                <!-- Backlight glow -->
                <div class="absolute inset-y-0 right-0 w-80 bg-[radial-gradient(circle_at_right,rgba(99,102,241,0.25),transparent_60%)]"></div>

                <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold bg-indigo-500/20 text-indigo-200 border border-indigo-400/30 uppercase tracking-widest">Studi Kasus Bisnis</span>
                <h3 class="text-3xl font-black tracking-tight leading-tight">Bagaimana Kos Cihampelas Utama Mencapai Pelunasan Sewa 99.2% dalam 3 Bulan</h3>
                <p class="text-xs text-indigo-200/90 max-w-2xl leading-relaxed font-medium">
                    Pelajari strategi pengelolaan 48 unit kamar kos di Bandung yang sukses memangkas penagihan sewa manual hingga 80% dengan menerapkan otomatisasi faktur Kosan.
                </p>
                <x-button variant="primary" class="!bg-white !text-indigo-950 hover:!bg-indigo-50 font-extrabold cursor-pointer" onclick="window.location.href='{{ route('register') }}'">
                    Baca Studi Kasus Lengkap
                </x-button>
            </div>
        </div>
    </section>

    <!-- Section 6: Upcoming Webinar Registration -->
    <section class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-6 text-center space-y-6">
            <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold bg-indigo-50 text-indigo-600 border border-indigo-150/50 uppercase tracking-widest">Webinar Interaktif</span>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Strategi Mengembangkan Bisnis Kos Komersial di Era Digital</h3>
            <p class="text-xs text-slate-500 max-w-lg mx-auto font-medium">Ikuti sesi konsultasi langsung bersama pakar manajemen properti seputar strategi pelunasan sewa tepat waktu.</p>
            
            <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto" onsubmit="event.preventDefault(); alert('Terima kasih! Pendaftaran webinar Anda telah berhasil.');">
                <input type="email" placeholder="Masukkan alamat email Anda..." required aria-label="Alamat Email Webinar"
                       class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-xs text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" />
                <x-button variant="primary" size="sm" type="submit" class="cursor-pointer">Daftar Webinar Gratis</x-button>
            </form>
        </div>
    </section>

</x-marketing-layout>
