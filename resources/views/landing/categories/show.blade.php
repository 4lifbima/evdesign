@extends('layouts.landing')

@section('title', $category->name)
@section('page_title', $category->name)
@section('meta_description', 'Produk kategori ' . $category->name . ' di EVDesign.')

@section('breadcrumb')
<span class="breadcrumb-sep"><a href="{{ route('landing.categories.index') }}" class="hover:text-[#fc1919] transition-colors">Kategori</a></span>
<span class="breadcrumb-sep text-[#212529] dark:text-white font-medium">{{ $category->name }}</span>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 lg:px-8">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6 p-5 bg-white dark:bg-[#1a1a1a] rounded-2xl border border-[#E9ECEF] dark:border-[#222]">
        <div class="w-14 h-14 rounded-2xl bg-[#fc1919]/10 flex items-center justify-center flex-shrink-0">
            <iconify-icon icon="solar:box-bold" class="text-3xl text-[#fc1919]"></iconify-icon>
        </div>
        <div>
            <h2 class="text-xl font-extrabold text-[#212529] dark:text-white">{{ $category->name }}</h2>
            <p class="text-sm text-[#6C757D] mt-0.5">{{ $products->total() }} produk tersedia</p>
        </div>
    </div>

    {{-- Products Grid --}}
    @if($products->isNotEmpty())
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
        @foreach($products as $product)
            @include('landing.partials.product-card', ['product' => $product])
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
    <div class="flex items-center justify-center gap-2 flex-wrap">
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
    <div class="flex flex-col items-center justify-center py-24 text-center">
        <div class="w-20 h-20 rounded-full bg-[#fc1919]/10 flex items-center justify-center mb-4">
            <iconify-icon icon="solar:bag-bold" class="text-4xl text-[#fc1919]"></iconify-icon>
        </div>
        <h3 class="text-lg font-bold text-[#212529] dark:text-white mb-2">Belum Ada Produk</h3>
        <p class="text-sm text-[#6C757D] mb-6">Kategori ini belum memiliki produk aktif.</p>
        <a href="{{ route('landing.products.index') }}" class="inline-flex items-center gap-2 bg-[#fc1919] text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-red-600 transition-colors">
            <iconify-icon icon="solar:bag-bold" class="text-base"></iconify-icon>
            Lihat Semua Produk
        </a>
    </div>
    @endif
</div>
@endsection
