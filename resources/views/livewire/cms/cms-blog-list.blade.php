<div class="space-y-6">
    <!-- Header -->
    <div class="pb-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Blog Articles Management</h1>
            <p class="text-sm text-slate-500 mt-1 leading-normal">Write, schedule, and structure blogs, categories, and tags for your marketing hub.</p>
        </div>
        <a href="{{ route('cms.blog.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Write Article
        </a>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm flex flex-col md:flex-row items-center gap-4">
        <!-- Search Input -->
        <div class="relative w-full md:flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="h-4.5 w-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <x-input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by title or author..." class="w-full pl-10" />
        </div>

        <!-- Status Filter -->
        <div class="w-full md:w-48">
            <select wire:model.live="status" class="block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Statuses</option>
                @foreach(\App\Enums\CmsPublishStatus::cases() as $state)
                    <option value="{{ $state->value }}">{{ $state->label() }}</option>
                @endforeach
            </select>
        </div>

        <!-- Category Filter -->
        <div class="w-full md:w-48">
            <select wire:model.live="category" class="block w-full rounded-xl border-slate-200 bg-white py-2 px-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                <tr>
                    <th class="px-6 py-3">Article Title</th>
                    <th class="px-6 py-3">Author</th>
                    <th class="px-6 py-3">Categories / Tags</th>
                    <th class="px-6 py-3">Publish Date</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($articles as $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 text-sm block">{{ $item->title }}</span>
                            <span class="text-slate-400 font-mono mt-0.5 text-[11px] block truncate max-w-[200px]">/blog/{{ $item->slug }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-medium">
                            {{ $item->author_name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 space-y-1">
                            <div>
                                @foreach($item->categories as $c)
                                    <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 font-semibold text-[9px] mr-1">{{ $c->name }}</span>
                                @endforeach
                            </div>
                            <div>
                                @foreach($item->tags as $t)
                                    <span class="text-slate-400 font-mono text-[9px] mr-1">#{{ $t->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">
                            {{ $item->published_at ? $item->published_at->format('d M Y H:i') : 'Immediate' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold capitalize
                                {{ $item->status === \App\Enums\CmsPublishStatus::PUBLISHED ? 'bg-emerald-50 text-emerald-700' : '' }}
                                {{ $item->status === \App\Enums\CmsPublishStatus::DRAFT ? 'bg-slate-50 text-slate-650' : '' }}
                                {{ $item->status === \App\Enums\CmsPublishStatus::SCHEDULED ? 'bg-indigo-50 text-indigo-700' : '' }}
                                {{ $item->status === \App\Enums\CmsPublishStatus::ARCHIVED ? 'bg-rose-50 text-rose-700' : '' }}
                            ">
                                {{ $item->status->label() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-1.5">
                            <a href="{{ route('cms.blog.edit', $item->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-slate-200 hover:bg-slate-50 rounded-xl text-xs font-semibold text-slate-700 transition cursor-pointer">
                                Edit
                            </a>
                            <button type="button" wire:click="deleteArticle('{{ $item->id }}')" wire:confirm="Are you sure you want to delete this article?" class="inline-flex items-center justify-center px-3 py-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-100 rounded-xl text-xs font-semibold text-rose-700 transition cursor-pointer">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">No articles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($articles->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-50">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
