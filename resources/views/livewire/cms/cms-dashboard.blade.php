<div class="space-y-6">
    <!-- Header -->
    <div class="pb-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Enterprise CMS Console</h1>
            <p class="text-sm text-slate-500 mt-1 leading-normal">Manage structured website content, publishing schedules, media assets, and search tags.</p>
        </div>
    </div>

    <!-- Global Search -->
    <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-4">
        <div class="relative w-full">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="h-4.5 w-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <x-input type="text" wire:model.live.debounce.350ms="globalSearch" placeholder="Global CMS search (pages, articles)..." class="w-full pl-10" />
        </div>

        @if(!empty($globalSearch))
            <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl text-xs space-y-3">
                <h4 class="font-bold text-slate-700">Search Results</h4>
                
                @if(empty($searchResults['pages']) && empty($searchResults['articles']))
                    <p class="text-slate-450 italic">No matches found.</p>
                @endif

                @if(!empty($searchResults['pages']))
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Predefined Pages</span>
                        @foreach($searchResults['pages'] as $p)
                            <a href="{{ route('cms.pages.edit', $p->id) }}" class="block py-1 text-indigo-650 hover:underline">
                                {{ $p->name }} <span class="text-slate-400 font-mono">({{ $p->slug }})</span>
                            </a>
                        @endforeach
                    </div>
                @endif

                @if(!empty($searchResults['articles']))
                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Blog Articles</span>
                        @foreach($searchResults['articles'] as $a)
                            <a href="{{ route('cms.blog.edit', $a->id) }}" class="block py-1 text-indigo-650 hover:underline">
                                {{ $a->title }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Published Pages</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black text-slate-900">{{ $publishedPages }}</span>
                <span class="text-xs text-slate-500 font-semibold">Active</span>
            </div>
            <p class="text-slate-400 text-[10px] mt-2 font-semibold">{{ $draftPages }} drafts, {{ $scheduledPages }} scheduled</p>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Blog Articles</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black text-slate-900">{{ $articlesCount }}</span>
                <span class="text-xs text-slate-500 font-semibold">Total</span>
            </div>
            <p class="text-slate-400 text-[10px] mt-2 font-semibold">{{ $categoriesCount }} categories, {{ $tagsCount }} tags</p>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Media Assets</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black text-slate-900">{{ $mediaCount }}</span>
                <span class="text-xs text-slate-500 font-semibold">{{ $mediaSizeMb }} MB</span>
            </div>
            <p class="text-slate-400 text-[10px] mt-2 font-semibold">Organized in folder paths</p>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">SEO Health</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black text-amber-600">{{ $pagesMissingMeta }}</span>
                <span class="text-xs text-slate-500 font-semibold">Needs Audit</span>
            </div>
            <p class="text-slate-400 text-[10px] mt-2 font-semibold">{{ $brokenRedirectsCount }} inactive redirects registered</p>
        </div>
    </div>

    <!-- Quick Shortcuts Card Deck -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Structured Page Content</h3>
                <p class="text-xs text-slate-500 mt-1 leading-normal">Edit text sections for Home, Features, Pricing, and About pages with version control.</p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-50">
                <a href="{{ route('cms.pages.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-indigo-650 hover:underline">
                    Manage Page Sections
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Article Publishing & Blogs</h3>
                <p class="text-xs text-slate-500 mt-1 leading-normal">Write rich text guides, classify categories, tag authors, and configure slug redirections.</p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-50">
                <a href="{{ route('cms.blog.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-indigo-650 hover:underline">
                    Manage Blog Postings
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight">System Navigation Menus</h3>
                <p class="text-xs text-slate-500 mt-1 leading-normal">Arrange Header, Footer, Social Icons, and Sitemap links with nesting hierarchy.</p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-50">
                <a href="{{ route('cms.menus.edit') }}" class="inline-flex items-center gap-1 text-xs font-bold text-indigo-650 hover:underline">
                    Manage Menu Links
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </div>
</div>
