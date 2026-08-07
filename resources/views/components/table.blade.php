@props([
    'headers'         => [],
    'stickyHeader'    => false,
    'stickyFirstCol'  => false,
    'striped'         => false,
    'glass'           => true,
    'mobileCards'     => false,
])

@php
    $wrapClass = 'overflow-x-auto rounded-2xl border border-slate-200/75 shadow-xs';
    if ($glass) $wrapClass .= ' glass-table';
    if ($mobileCards) $wrapClass .= ' table-mobile-cards';
@endphp

<div class="{{ $wrapClass }}">
    <table class="min-w-full divide-y divide-slate-100/80 table-row-hover {{ $stickyFirstCol ? 'table-sticky-col' : '' }}">

        @if(!empty($headers))
            <thead class="{{ $stickyHeader ? 'table-sticky-header' : '' }} bg-slate-50/80">
                <tr>
                    @foreach($headers as $header)
                        <th scope="col"
                            class="px-5 py-3.5 text-left text-[10.5px] font-extrabold text-slate-400 uppercase tracking-widest whitespace-nowrap select-none">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody class="divide-y divide-slate-100/60 bg-white {{ $striped ? 'even:bg-slate-50/40' : '' }}">
            {{ $slot }}
        </tbody>
    </table>
</div>
