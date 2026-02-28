@if ($paginator->hasPages())
    <div class="bg-[#F8F9FA] dark:bg-[#121212] px-4 py-3 border-t border-[#E9ECEF] dark:border-[#334155] flex flex-col sm:flex-row items-center justify-between gap-3">
        {{-- Info text --}}
        <p class="text-sm text-[#6C757D]">
            Menampilkan
            <span class="font-semibold text-[#212529] dark:text-white">{{ $paginator->firstItem() }}</span>
            hingga
            <span class="font-semibold text-[#212529] dark:text-white">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-semibold text-[#212529] dark:text-white">{{ $paginator->total() }}</span>
            data
        </p>

        {{-- Page Buttons --}}
        <div class="flex items-center gap-1">
            {{-- Prev --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 border border-[#E9ECEF] dark:border-[#334155] bg-white dark:bg-[#1E1E1E] rounded text-sm text-[#6C757D] opacity-50 cursor-not-allowed select-none">
                    ← Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 border border-[#E9ECEF] dark:border-[#334155] bg-white dark:bg-[#1E1E1E] rounded text-sm text-[#6C757D] hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    ← Prev
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 py-1.5 text-sm text-[#6C757D]">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1.5 bg-[#fc1919] text-white font-semibold rounded text-sm shadow-sm">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1.5 border border-[#E9ECEF] dark:border-[#334155] bg-white dark:bg-[#1E1E1E] rounded text-sm text-[#212529] dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 border border-[#E9ECEF] dark:border-[#334155] bg-white dark:bg-[#1E1E1E] rounded text-sm text-[#6C757D] hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    Next →
                </a>
            @else
                <span class="px-3 py-1.5 border border-[#E9ECEF] dark:border-[#334155] bg-white dark:bg-[#1E1E1E] rounded text-sm text-[#6C757D] opacity-50 cursor-not-allowed select-none">
                    Next →
                </span>
            @endif
        </div>
    </div>
@endif
