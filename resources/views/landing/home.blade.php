@extends('layouts.landing')

@section('title', 'Beranda')
@section('page_title', 'Beranda')
@section('meta_description', 'Temukan produk kerajinan tangan berkualitas tinggi dari para perajin terbaik Indonesia.')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 lg:px-8">

    {{-- ═══ HERO BANNER ═══ --}}
    <div class="relative overflow-hidden rounded-2xl mb-8 hero-gradient text-white">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 right-0 w-80 h-80 bg-[#fc1919] rounded-full blur-3xl translate-x-1/3 -translate-y-1/3"></div>
            <div class="absolute bottom-0 left-0 w-60 h-60 bg-[#fc1919] rounded-full blur-3xl -translate-x-1/3 translate-y-1/3"></div>
        </div>
        <div class="relative px-6 py-10 sm:px-10 sm:py-14 lg:py-16 z-10">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-3 py-1 text-xs font-medium mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-[#fc1919] animate-pulse"></span>
                Kerajinan Tangan Premium
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold leading-tight mb-3 max-w-lg">
                Karya Perajin <br><span class="text-[#fc1919]">Terbaik Indonesia</span>
            </h2>
            <p class="text-white/70 text-sm sm:text-base max-w-md mb-6">
                Temukan kerajinan tangan autentik berkualitas tinggi, langsung dari tangan para perajin berbakat Nusantara.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('landing.products.index') }}"
                   class="inline-flex items-center gap-2 bg-[#fc1919] text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-red-600 transition-all shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-0.5">
                    <iconify-icon icon="solar:bag-bold" class="text-base"></iconify-icon>
                    Jelajahi Katalog
                </a>
                <a href="{{ route('landing.categories.index') }}"
                   class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-white/20 transition-all">
                    <iconify-icon icon="solar:sort-bold" class="text-base"></iconify-icon>
                    Lihat Kategori
                </a>
            </div>

            <!-- Stats -->
            <div class="flex flex-wrap gap-6 mt-8 pt-6 border-t border-white/10">
                <div>
                    <p class="text-2xl font-extrabold text-[#fc1919]">{{ number_format($totalProducts) }}+</p>
                    <p class="text-xs text-white/60">Produk Aktif</p>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-white">{{ $categories->count() }}+</p>
                    <p class="text-xs text-white/60">Kategori</p>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-white">100%</p>
                    <p class="text-xs text-white/60">Buatan Lokal</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ KATEGORI HIGHLIGHT ═══ --}}
    @if($categories->isNotEmpty())
    <section class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-[#212529] dark:text-white">Kategori Produk</h3>
                <p class="text-xs text-[#6C757D]">Pilih berdasarkan kategori</p>
            </div>
            <a href="{{ route('landing.categories.index') }}" class="text-sm text-[#fc1919] font-semibold hover:underline flex items-center gap-1">
                Semua <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            @foreach($categories as $cat)
            <a href="{{ route('landing.categories.show', $cat->slug ?? $cat->id) }}"
               class="group flex flex-col items-center gap-2 p-4 bg-white dark:bg-[#1a1a1a] rounded-2xl border border-[#E9ECEF] dark:border-[#222] hover:border-[#fc1919] dark:hover:border-[#fc1919] hover:shadow-lg hover:shadow-red-500/10 transition-all">
                <div class="w-11 h-11 rounded-xl bg-[#fc1919]/10 group-hover:bg-[#fc1919] flex items-center justify-center transition-colors">
                    <iconify-icon icon="solar:box-bold" class="text-2xl text-[#fc1919] group-hover:text-white transition-colors"></iconify-icon>
                </div>
                <p class="text-xs font-semibold text-center text-[#212529] dark:text-white leading-tight">{{ $cat->name }}</p>
                <span class="text-[10px] text-[#6C757D]">{{ $cat->products_count }} produk</span>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ═══ PRODUK UNGGULAN ═══ --}}
    @if($featuredProducts->isNotEmpty())
    <section class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-[#212529] dark:text-white">Produk Unggulan</h3>
                <p class="text-xs text-[#6C757D]">Pilihan terbaik dari koleksi kami</p>
            </div>
            <a href="{{ route('landing.products.index') }}" class="text-sm text-[#fc1919] font-semibold hover:underline flex items-center gap-1">
                Semua <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($featuredProducts as $product)
                @include('landing.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    @endif

    {{-- ═══ PRODUK BARU & TERLARIS (2 col) ═══ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">

        {{-- Produk Baru --}}
        @if($newProducts->isNotEmpty())
        <section>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-[#212529] dark:text-white">Produk Terbaru</h3>
                    <p class="text-xs text-[#6C757D]">Koleksi paling baru</p>
                </div>
                <a href="{{ route('landing.products.index', ['sort'=>'latest']) }}" class="text-xs text-[#fc1919] font-semibold hover:underline">Lihat semua</a>
            </div>
            <div class="grid grid-cols-2 gap-3">
                @foreach($newProducts as $product)
                    @include('landing.partials.product-card', ['product' => $product, 'compact' => true])
                @endforeach
            </div>
        </section>
        @endif

        {{-- Terlaris --}}
        @if($bestSellers->isNotEmpty())
        <section>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-[#212529] dark:text-white">Terlaris</h3>
                    <p class="text-xs text-[#6C757D]">Favorit pelanggan kami</p>
                </div>
                <a href="{{ route('landing.products.index', ['sort'=>'popular']) }}" class="text-xs text-[#fc1919] font-semibold hover:underline">Lihat semua</a>
            </div>
            <div class="grid grid-cols-2 gap-3">
                @foreach($bestSellers as $product)
                    @include('landing.partials.product-card', ['product' => $product, 'compact' => true])
                @endforeach
            </div>
        </section>
        @endif
    </div>

    {{-- ═══ CTA BANNER ═══ --}}
    <div class="rounded-2xl bg-gradient-to-r from-[#fc1919] to-[#c0392b] p-6 sm:p-8 text-white text-center">
        <iconify-icon icon="solar:bag-bold" class="text-4xl text-white/80 mb-3"></iconify-icon>
        <h3 class="text-xl font-extrabold mb-2">Butuh Produk Khusus?</h3>
        <p class="text-white/80 text-sm mb-5">Kami siap membantu Anda menemukan kerajinan yang sempurna untuk kebutuhan Anda.</p>
        <a href="{{ route('landing.contact') }}"
           class="inline-flex items-center gap-2 bg-white text-[#fc1919] px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-red-50 transition-colors">
            <iconify-icon icon="solar:phone-bold" class="text-base"></iconify-icon>
            Hubungi Kami
        </a>
    </div>

</div>
@endsection
