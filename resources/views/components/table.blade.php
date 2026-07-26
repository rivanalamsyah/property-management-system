@props([
    'headers' => [],
    'stickyHeader' => false,
])

<div class="overflow-x-auto -mx-6 sm:mx-0 rounded-2xl border border-slate-200/80 shadow-2xs bg-white">
    <table class="min-w-full divide-y divide-slate-100">
        @if(!empty($headers))
            <thead class="bg-slate-50/70 backdrop-blur-xs {{ $stickyHeader ? 'sticky top-0 z-10' : '' }}">
                <tr>
                    @foreach($headers as $header)
                        <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-slate-100/80 bg-white">
            {{ $slot }}
        </tbody>
    </table>
</div>
