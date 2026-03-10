@extends('layouts.landing')

@section('title', 'Semua Kategori')
@section('page_title', 'Semua Kategori')
@section('meta_description', 'Jelajahi semua kategori produk kerajinan tangan di EVDesign.')

@section('breadcrumb')
<span class="breadcrumb-sep">Kategori</span>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 lg:px-8">

    <div class="mb-6">
        <h2 class="text-xl font-extrabold text-[#212529] dark:text-white mb-1">Kategori Produk</h2>
        <p class="text-sm text-[#6C757D]">{{ $categories->count() }} kategori tersedia</p>
    </div>

    @if($categories->isNotEmpty())
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @foreach($categories as $cat)
        <a href="{{ route('landing.categories.show', $cat->slug ?? $cat->id) }}"
           class="product-card group block bg-white dark:bg-[#1a1a1a] rounded-2xl border border-[#E9ECEF] dark:border-[#222] overflow-hidden hover:border-[#fc1919]/30 dark:hover:border-[#fc1919]/30 p-5">
            <div class="w-14 h-14 rounded-2xl bg-[#fc1919]/10 group-hover:bg-[#fc1919] flex items-center justify-center mb-3 transition-colors">
                <iconify-icon icon="solar:box-bold" class="text-3xl text-[#fc1919] group-hover:text-white transition-colors"></iconify-icon>
            </div>
            <h3 class="font-bold text-[#212529] dark:text-white text-sm mb-1">{{ $cat->name }}</h3>
            <p class="text-xs text-[#6C757D] mb-3">{{ $cat->products_count }} produk tersedia</p>
            <div class="flex items-center gap-1 text-xs text-[#fc1919] font-semibold group-hover:gap-2 transition-all">
                Lihat produk <iconify-icon icon="solar:arrow-right-linear" class="text-sm"></iconify-icon>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="flex flex-col items-center justify-center py-24 text-center">
        <div class="w-20 h-20 rounded-full bg-[#fc1919]/10 flex items-center justify-center mb-4">
            <iconify-icon icon="solar:sort-bold" class="text-4xl text-[#fc1919]"></iconify-icon>
        </div>
        <h3 class="text-lg font-bold text-[#212529] dark:text-white mb-2">Belum Ada Kategori</h3>
        <p class="text-sm text-[#6C757D]">Kategori produk akan segera tersedia.</p>
    </div>
    @endif
</div>
@endsection
