<x-marketing-layout :meta_title="$meta_title" :meta_description="$meta_description" :canonical="$canonical">

    @push('schema')
    <!-- Dynamic Blog Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BlogPosting",
      "headline": "{{ $article->title }}",
      "image": "{{ $article->featured_image }}",
      "author": {
        "@@type": "Person",
        "name": "{{ $article->author_name ?? 'Tim Kosan' }}"
      },
      "publisher": {
        "@@type": "Organization",
        "name": "Kosan",
        "logo": {
          "@@type": "ImageObject",
          "url": "{{ asset('icons/icon-192x192.png') }}"
        }
      },
      "datePublished": "{{ $article->published_at ? $article->published_at->toIso8601String() : $article->created_at->toIso8601String() }}",
      "description": "{{ $article->excerpt }}"
    }
    </script>
    @endpush

    <!-- Blog Detail Custom Styles for Markdown/HTML parser -->
    <style>
        .blog-detail-mesh {
            background-image: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.05), transparent 60%);
        }
        /* Custom Premium Markdown content styles */
        .blog-content h1 {
            font-size: 1.875rem;
            font-weight: 800;
            color: #0f172a;
            margin-top: 2rem;
            margin-bottom: 1rem;
            line-height: 1.25;
            letter-spacing: -0.025em;
        }
        .blog-content h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            margin-top: 1.75rem;
            margin-bottom: 0.75rem;
            line-height: 1.3;
            letter-spacing: -0.025em;
        }
        .blog-content h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .blog-content p {
            font-size: 0.875rem;
            color: #475569;
            line-height: 1.8;
            margin-bottom: 1.25rem;
            font-weight: 450;
        }
        .blog-content ul {
            list-style-type: disc;
            margin-left: 1.5rem;
            margin-bottom: 1.25rem;
        }
        .blog-content ol {
            list-style-type: decimal;
            margin-left: 1.5rem;
            margin-bottom: 1.25rem;
        }
        .blog-content li {
            font-size: 0.875rem;
            color: #475569;
            margin-bottom: 0.5rem;
            line-height: 1.7;
            font-weight: 450;
        }
        .blog-content blockquote {
            border-left: 4px solid #6366f1;
            padding-left: 1.25rem;
            font-style: italic;
            color: #4f46e5;
            background-color: #f8fafc;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 0 0.75rem 0.75rem 0;
            font-weight: 500;
        }
        .blog-content a {
            color: #4f46e5;
            text-decoration: underline;
            font-weight: 600;
            transition: color 0.15s ease;
        }
        .blog-content a:hover {
            color: #3730a3;
        }
        .blog-content img {
            border-radius: 1rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.05);
            width: 100%;
            height: auto;
        }
    </style>

    <div class="blog-detail-mesh min-h-screen pt-24 pb-20">
        <!-- Breadcrumbs Navigation -->
        <div class="max-w-6xl mx-auto px-6 mb-8">
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-indigo-650 transition">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('blog.index') }}" class="hover:text-indigo-650 transition">Blog</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-slate-600 line-clamp-1">{{ $article->title }}</span>
            </nav>
        </div>

        <!-- Main Blog Layout Container -->
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- LEFT: Article Main Panel -->
            <article class="lg:col-span-8 space-y-6">
                <!-- Meta Badges & Info -->
                <div class="space-y-4 text-left">
                    <div class="flex flex-wrap gap-2">
                        @foreach($article->categories as $cat)
                            <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" 
                               class="text-[9px] font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-0.5 rounded-md hover:bg-indigo-100 transition">
                               {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                        {{ $article->title }}
                    </h1>

                    <!-- Author, Date and Estimated Read Time -->
                    <div class="flex items-center gap-4 text-xs font-bold text-slate-500 pt-1">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-[10px] text-indigo-600 font-extrabold">
                                {{ strtoupper(substr($article->author_name ?? 'K', 0, 2)) }}
                            </div>
                            <span>{{ $article->author_name ?? 'Tim Kosan' }}</span>
                        </div>
                        <span class="text-slate-300 font-medium">&bull;</span>
                        <span>{{ $article->published_at ? $article->published_at->translatedFormat('d M Y') : $article->created_at->format('d M Y') }}</span>
                        <span class="text-slate-300 font-medium">&bull;</span>
                        <span class="font-mono text-[10px] text-indigo-500 bg-indigo-50/50 px-1.5 py-0.5 rounded-md">
                            {{ max(1, (int) ceil(str_word_count(strip_tags($article->content)) / 200)) }} menit baca
                        </span>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="w-full aspect-[16/9] rounded-3xl overflow-hidden border border-slate-100 shadow-sm bg-slate-50 relative">
                    @if($article->featured_image)
                        <img src="{{ $article->featured_image }}" class="w-full h-full object-cover" alt="{{ $article->title }}">
                    @else
                        <div class="w-full h-full bg-gradient-to-tr from-indigo-500/5 to-purple-500/5 flex items-center justify-center">
                            <svg class="w-16 h-16 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <!-- Excerpt Box (Glassmorphic) -->
                @if($article->excerpt)
                    <div class="p-5 bg-slate-50 border border-slate-100 rounded-2xl text-xs text-slate-500 italic leading-relaxed font-medium">
                        {{ $article->excerpt }}
                    </div>
                @endif

                <!-- Article Content parsed to HTML -->
                <div class="blog-content text-left pt-2">
                    {!! Str::markdown($article->content ?? '') !!}
                </div>

                <!-- Tags list -->
                @if($article->tags->isNotEmpty())
                    <div class="border-t border-slate-100 pt-6 flex flex-wrap gap-2 items-center">
                        <span class="text-xs font-bold text-slate-400 mr-1">Tags:</span>
                        @foreach($article->tags as $tag)
                            <span class="text-xs bg-slate-100 text-slate-600 font-bold px-2.5 py-1 rounded-lg">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </article>

            <!-- RIGHT: Sidebar Widget Panel -->
            <aside class="lg:col-span-4 space-y-8 sticky top-28">
                
                <!-- Share Widget -->
                <div class="bg-white border border-slate-200/60 p-6 rounded-3xl shadow-xs space-y-4">
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-widest">Bagikan Artikel</h3>
                    <div class="grid grid-cols-3 gap-2">
                        <!-- Twitter/X -->
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode($canonical) }}&text={{ urlencode($article->title) }}" target="_blank"
                           class="flex flex-col items-center justify-center p-3 border border-slate-150 rounded-xl hover:bg-slate-50 transition hover:border-indigo-200 group text-center">
                            <span class="text-[10px] font-bold text-slate-500 group-hover:text-slate-800">Twitter / X</span>
                        </a>
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($canonical) }}" target="_blank"
                           class="flex flex-col items-center justify-center p-3 border border-slate-150 rounded-xl hover:bg-slate-50 transition hover:border-indigo-200 group text-center">
                            <span class="text-[10px] font-bold text-slate-500 group-hover:text-slate-800">Facebook</span>
                        </a>
                        <!-- WhatsApp -->
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' - ' . $canonical) }}" target="_blank"
                           class="flex flex-col items-center justify-center p-3 border border-slate-150 rounded-xl hover:bg-slate-50 transition hover:border-indigo-200 group text-center">
                            <span class="text-[10px] font-bold text-slate-500 group-hover:text-slate-800">WhatsApp</span>
                        </a>
                    </div>
                </div>

                <!-- Call To Action Widget (Premium card) -->
                <div class="p-6 bg-gradient-to-tr from-indigo-900 to-indigo-950 text-white rounded-3xl shadow-lg relative overflow-hidden space-y-5 text-left">
                    <div class="absolute inset-y-0 right-0 w-40 bg-[radial-gradient(circle_at_right,rgba(99,102,241,0.2),transparent_70%)] pointer-events-none"></div>
                    
                    <span class="inline-flex px-2 py-0.5 rounded text-[8px] font-extrabold bg-indigo-500/20 text-indigo-200 border border-indigo-400/20 uppercase tracking-widest">Aplikasi Pengelolaan Kos</span>
                    <h4 class="text-lg font-black tracking-tight leading-snug">Capek Nagih & Rekap Sewa Bulanan Manual?</h4>
                    <p class="text-xs text-indigo-200 leading-relaxed font-medium">Otomatisasikan bisnis kos Anda dengan **Kosan**. Tagihan otomatis terkirim, bukti transfer terverifikasi instan.</p>
                    <x-button variant="primary" class="!bg-white !text-indigo-950 hover:!bg-indigo-50 font-extrabold w-full text-center py-2.5 cursor-pointer text-xs" onclick="window.location.href='{{ route('register') }}'">
                        Coba Gratis 14 Hari
                    </x-button>
                </div>

                <!-- Sticky Quick Scroll Back -->
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-650 hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Semua Artikel
                </a>
            </aside>
        </div>

        <!-- Section: Related Articles -->
        @if($relatedArticles->isNotEmpty())
            <div class="max-w-6xl mx-auto px-6 border-t border-slate-100 mt-20 pt-16">
                <div class="text-left mb-10 space-y-2">
                    <span class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-widest">Rekomendasi Konten</span>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Artikel Terkait Untuk Anda</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedArticles as $rel)
                        <a href="{{ route('blog.detail', ['slug' => $rel->slug]) }}" class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-xs hover:shadow-md hover:-translate-y-1 transition duration-200 flex flex-col h-full group">
                            <div class="h-36 bg-slate-100 overflow-hidden flex-shrink-0 relative">
                                @if($rel->featured_image)
                                    <img src="{{ $rel->featured_image }}" class="w-full h-full object-cover group-hover:scale-101.5 transition duration-300" alt="{{ $rel->title }}">
                                @else
                                    <div class="w-full h-full bg-gradient-to-tr from-indigo-500/5 to-purple-500/5 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 flex flex-col justify-between flex-1 text-left">
                                <div class="space-y-2">
                                    <span class="text-[9px] font-extrabold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-2 py-0.5 rounded-md">
                                        {{ $rel->categories->first()?->name ?? 'Insight' }}
                                    </span>
                                    <h4 class="text-sm font-bold text-slate-900 tracking-tight group-hover:text-indigo-600 transition-colors leading-snug">{{ $rel->title }}</h4>
                                </div>
                                <p class="text-[9.5px] text-slate-400 font-bold font-mono pt-4">
                                    {{ $rel->published_at ? $rel->published_at->translatedFormat('d M Y') : $rel->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</x-marketing-layout>
