<div class="space-y-6">
    <!-- Header -->
    <div class="pb-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Structured Predefined Pages</h1>
            <p class="text-sm text-slate-500 mt-1 leading-normal">Edit text contents for fixed layout sections of the public marketing website.</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                <tr>
                    <th class="px-6 py-3">Page Name</th>
                    <th class="px-6 py-3">Route Path / Slug</th>
                    <th class="px-6 py-3">Sections Count</th>
                    <th class="px-6 py-3">SEO Title</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($pages as $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-950 text-sm block">{{ $item->name }}</span>
                        </td>
                        <td class="px-6 py-4 font-mono text-slate-500">
                            /{{ $item->slug === 'home' ? '' : $item->slug }}
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-semibold">
                            {{ $item->sections_count }} sections
                        </td>
                        <td class="px-6 py-4 text-slate-450 truncate max-w-[180px]">
                            {{ $item->seo_title ?? 'Not configured' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold capitalize
                                {{ $item->status === \App\Enums\CmsPublishStatus::PUBLISHED ? 'bg-emerald-50 text-emerald-700' : '' }}
                                {{ $item->status === \App\Enums\CmsPublishStatus::DRAFT ? 'bg-slate-50 text-slate-650' : '' }}
                                {{ $item->status === \App\Enums\CmsPublishStatus::SCHEDULED ? 'bg-indigo-50 text-indigo-700' : '' }}
                            ">
                                {{ $item->status->label() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('cms.pages.edit', $item->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-slate-200 hover:bg-slate-50 rounded-xl text-xs font-semibold text-slate-700 transition cursor-pointer">
                                Edit Sections
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
