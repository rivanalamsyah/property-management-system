@props(['paginator'])

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3 py-3">

        <!-- Results Summary -->
        <p class="text-xs text-slate-500 order-2 sm:order-1">
            Menampilkan
            <span class="font-bold text-slate-800">{{ $paginator->firstItem() }}</span>
            hingga
            <span class="font-bold text-slate-800">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-bold text-slate-800">{{ $paginator->total() }}</span>
            hasil
        </p>

        <!-- Page Controls -->
        <div class="flex items-center gap-1.5 order-1 sm:order-2">

            <!-- Previous -->
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center w-8 h-8 text-slate-300 bg-white border border-slate-200/60 rounded-xl cursor-not-allowed select-none shadow-2xs text-xs" aria-disabled="true">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </span>
            @else
                <button wire:click="previousPage" rel="prev"
                        class="inline-flex items-center justify-center w-8 h-8 text-slate-600 bg-white border border-slate-200/60 hover:bg-slate-50 hover:border-indigo-200/60 hover:text-indigo-600 rounded-xl cursor-pointer transition-all duration-150 shadow-2xs hover:shadow-xs active:scale-95 text-xs"
                        aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </button>
            @endif

            <!-- Page Numbers -->
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex items-center justify-center w-8 h-8 text-slate-400 text-xs select-none">…</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"
                                  class="inline-flex items-center justify-center w-8 h-8 bg-indigo-600 text-white text-xs font-bold rounded-xl shadow-sm shadow-indigo-500/30 select-none">
                                {{ $page }}
                            </span>
                        @else
                            <button wire:click="gotoPage({{ $page }})"
                                    class="inline-flex items-center justify-center w-8 h-8 text-slate-600 bg-white border border-slate-200/60 hover:bg-indigo-50 hover:border-indigo-200/60 hover:text-indigo-700 rounded-xl cursor-pointer transition-all duration-150 text-xs font-semibold shadow-2xs active:scale-95"
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <!-- Next -->
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" rel="next"
                        class="inline-flex items-center justify-center w-8 h-8 text-slate-600 bg-white border border-slate-200/60 hover:bg-slate-50 hover:border-indigo-200/60 hover:text-indigo-600 rounded-xl cursor-pointer transition-all duration-150 shadow-2xs hover:shadow-xs active:scale-95 text-xs"
                        aria-label="{{ __('pagination.next') }}">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </button>
            @else
                <span class="inline-flex items-center justify-center w-8 h-8 text-slate-300 bg-white border border-slate-200/60 rounded-xl cursor-not-allowed select-none shadow-2xs text-xs" aria-disabled="true">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
