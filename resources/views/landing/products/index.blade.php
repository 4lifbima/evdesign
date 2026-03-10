@extends('layouts.landing')

@section('title', 'Semua Produk')
@section('page_title', 'Katalog Produk')
@section('meta_description', 'Jelajahi semua produk kerajinan tangan berkualitas dari EVDesign.')

@section('breadcrumb')
<span class="breadcrumb-sep">Produk</span>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 lg:px-8">

    {{-- ─── Toolbar & Filters ─── --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-6">
        <div>
            <p class="text-sm text-[#6C757D]">
                Menampilkan <strong class="text-[#212529] dark:text-white">{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong>
                dari <strong class="text-[#fc1919]">{{ $products->total() }}</strong> produk
                @if(request('q')) untuk "<em>{{ request('q') }}</em>" @endif
            </p>
            </p>
        </div>

        <div class="flex flex-col sm:flex-row items-end sm:items-center gap-4 flex-wrap w-full md:w-auto">
            
            {{-- Filter Harga (Desktop/Inline) --}}
            <div class="hidden md:flex items-center gap-3 bg-white dark:bg-[#1a1a1a] border border-[#E9ECEF] dark:border-[#333] px-4 py-2 rounded-full" x-data="priceFilter()">
                <span class="text-xs text-[#6C757D] font-medium whitespace-nowrap">Max Harga:</span>
                <input type="range" x-model="maxPrice" min="0" max="5000000" step="50000" class="w-32 h-1.5 rounded-full accent-[#fc1919]">
                <span class="text-xs font-bold text-[#fc1919] w-20">Rp <span x-text="maxPrice.toLocaleString('id-ID')"></span></span>
                <a :href="buildUrl()" class="ml-1 w-6 h-6 rounded-full bg-gray-100 dark:bg-gray-800 hover:bg-[#fc1919] hover:text-white flex items-center justify-center transition-colors text-[#495057] dark:text-gray-300">
                    <iconify-icon icon="solar:filter-bold" class="text-xs"></iconify-icon>
                </a>
            </div>

            {{-- Category pills --}}
            <a href="{{ route('landing.products.index', array_filter(request()->except('category'))) }}"
               class="cat-pill text-xs font-medium px-3 py-1.5 rounded-full border border-[#E9ECEF] dark:border-[#333] bg-white dark:bg-[#1a1a1a] text-[#495057] dark:text-gray-300 {{ !request('category') ? 'active' : '' }}">
                Semua
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('landing.products.index', array_merge(request()->except('category', 'page'), ['category' => $cat->slug ?? $cat->id])) }}"
               class="cat-pill text-xs font-medium px-3 py-1.5 rounded-full border border-[#E9ECEF] dark:border-[#333] bg-white dark:bg-[#1a1a1a] text-[#495057] dark:text-gray-300 {{ request('category') == ($cat->slug ?? $cat->id) ? 'active' : '' }}">
                {{ $cat->name }}
                <span class="opacity-60">({{ $cat->products_count }})</span>
            </a>
            @endforeach

            {{-- Sort --}}
            <div class="relative ml-2" x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-full border border-[#E9ECEF] dark:border-[#333] bg-white dark:bg-[#1a1a1a] text-[#495057] dark:text-gray-300 hover:border-[#fc1919] transition-colors">
                    <iconify-icon icon="solar:sort-bold" class="text-sm"></iconify-icon>
                    Urutkan
                    <iconify-icon icon="solar:alt-arrow-down-linear" class="text-xs" :class="open ? 'rotate-180' : ''" style="transition: transform .2s"></iconify-icon>
                </button>
                <div x-show="open" @click.outside="open = false" x-cloak
                     class="absolute right-0 top-full mt-1 w-40 bg-white dark:bg-[#1e1e1e] rounded-xl border border-[#E9ECEF] dark:border-[#333] shadow-xl py-1 z-10">
                    @foreach([
                        ['latest','Terbaru'],
                        ['price_asc','Harga ↑'],
                        ['price_desc','Harga ↓'],
                        ['popular','Terpopuler'],
                    ] as [$val,$label])
                    <a href="{{ route('landing.products.index', array_merge(request()->except('sort','page'), ['sort'=>$val])) }}"
                       class="block px-3 py-2 text-xs text-[#495057] dark:text-gray-300 hover:bg-[#fc1919]/10 hover:text-[#fc1919] transition-colors {{ request('sort',$val==='latest'?'latest':null) === $val ? 'text-[#fc1919] font-semibold' : '' }}">
                        {{ $label }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ─── Grid Products ─── --}}
    @if($products->isNotEmpty())
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4 xl:gap-8 mb-8">
        @foreach($products as $product)
            @include('landing.partials.product-card', ['product' => $product])
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
    <div class="flex items-center justify-center gap-2 flex-wrap">
        {{-- Previous --}}
        @if($products->onFirstPage())
            <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-[#E9ECEF] dark:border-[#333] text-[#ADB5BD] cursor-not-allowed">
                <iconify-icon icon="solar:arrow-left-linear" class="text-sm"></iconify-icon>
            </span>
        @else
            <a href="{{ $products->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-[#E9ECEF] dark:border-[#333] text-[#495057] dark:text-gray-300 hover:border-[#fc1919] hover:text-[#fc1919] transition-colors">
                <iconify-icon icon="solar:arrow-left-linear" class="text-sm"></iconify-icon>
            </a>
        @endif

        @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
        @if($page == $products->currentPage())
            <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#fc1919] text-white text-sm font-bold">{{ $page }}</span>
        @elseif(abs($page - $products->currentPage()) <= 2)
            <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-[#E9ECEF] dark:border-[#333] text-[#495057] dark:text-gray-300 hover:border-[#fc1919] hover:text-[#fc1919] transition-colors text-sm">{{ $page }}</a>
        @endif
        @endforeach

        {{-- Next --}}
        @if($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-[#E9ECEF] dark:border-[#333] text-[#495057] dark:text-gray-300 hover:border-[#fc1919] hover:text-[#fc1919] transition-colors">
                <iconify-icon icon="solar:arrow-right-linear" class="text-sm"></iconify-icon>
            </a>
        @else
            <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-[#E9ECEF] dark:border-[#333] text-[#ADB5BD] cursor-not-allowed">
                <iconify-icon icon="solar:arrow-right-linear" class="text-sm"></iconify-icon>
            </span>
        @endif
    </div>
    @endif

    @else
    {{-- Empty state --}}
    <div class="flex flex-col items-center justify-center py-24 text-center">
        <div class="w-20 h-20 rounded-full bg-[#fc1919]/10 flex items-center justify-center mb-4">
            <iconify-icon icon="solar:bag-bold" class="text-4xl text-[#fc1919]"></iconify-icon>
        </div>
        <h3 class="text-lg font-bold text-[#212529] dark:text-white mb-2">Produk Tidak Ditemukan</h3>
        <p class="text-sm text-[#6C757D] mb-6">Coba kata kunci atau filter yang berbeda.</p>
        <a href="{{ route('landing.products.index') }}" class="inline-flex items-center gap-2 bg-[#fc1919] text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-red-600 transition-colors">
            <iconify-icon icon="solar:refresh-bold" class="text-base"></iconify-icon>
            Reset Filter
        </a>
    </div>
    @endif

</div>
@endsection
