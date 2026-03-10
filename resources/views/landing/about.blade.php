@extends('layouts.landing')

@section('title', 'Tentang Kami')
@section('page_title', 'Tentang EVDesign')

@section('breadcrumb')
<span class="breadcrumb-sep">Tentang Kami</span>
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8 lg:px-8">

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-2xl hero-gradient text-white p-8 sm:p-12 mb-8 text-center">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 right-0 w-60 h-60 bg-[#fc1919] rounded-full blur-3xl translate-x-1/4 -translate-y-1/4"></div>
        </div>
        <div class="relative">
            <div class="w-16 h-16 rounded-2xl bg-[#fc1919] flex items-center justify-center mx-auto mb-4 shadow-lg shadow-red-500/30">
                <iconify-icon icon="solar:shop-bold" class="text-3xl text-white"></iconify-icon>
            </div>
            <h2 class="text-3xl font-extrabold mb-3">EVDesign<span class="text-[#fc1919]">.</span></h2>
            <p class="text-white/80 text-base max-w-lg mx-auto leading-relaxed">
                Platform digital untuk kerajinan tangan berkualitas tinggi dari para perajin terbaik Nusantara.
            </p>
        </div>
    </div>

    {{-- Content --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white dark:bg-[#1a1a1a] rounded-2xl border border-[#E9ECEF] dark:border-[#222] p-6">
            <div class="w-11 h-11 rounded-xl bg-[#fc1919]/10 flex items-center justify-center mb-3">
                <iconify-icon icon="solar:target-bold" class="text-2xl text-[#fc1919]"></iconify-icon>
            </div>
            <h3 class="text-base font-bold text-[#212529] dark:text-white mb-2">Misi Kami</h3>
            <p class="text-sm text-[#6C757D] leading-relaxed">
                Menghubungkan para perajin berbakat Indonesia dengan pecinta kerajinan tangan di seluruh dunia,
                memastikan setiap produk membawa nilai budaya dan kualitas terbaik.
            </p>
        </div>
        <div class="bg-white dark:bg-[#1a1a1a] rounded-2xl border border-[#E9ECEF] dark:border-[#222] p-6">
            <div class="w-11 h-11 rounded-xl bg-[#fc1919]/10 flex items-center justify-center mb-3">
                <iconify-icon icon="solar:eye-bold" class="text-2xl text-[#fc1919]"></iconify-icon>
            </div>
            <h3 class="text-base font-bold text-[#212529] dark:text-white mb-2">Visi Kami</h3>
            <p class="text-sm text-[#6C757D] leading-relaxed">
                Menjadi platform kerajinan tangan terdepan di Indonesia yang memberdayakan perajin lokal
                dan melestarikan budaya kerajinan Nusantara.
            </p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        @foreach([['100+','Produk Berkualitas'],['50+','Perajin Terverifikasi'],['10+','Kategori Produk']] as [$num,$label])
        <div class="text-center p-5 bg-white dark:bg-[#1a1a1a] rounded-2xl border border-[#E9ECEF] dark:border-[#222]">
            <p class="text-3xl font-extrabold text-[#fc1919] mb-1">{{ $num }}</p>
            <p class="text-xs text-[#6C757D]">{{ $label }}</p>
        </div>
        @endforeach
    </div>

    {{-- CTA --}}
    <div class="text-center">
        <a href="{{ route('landing.products.index') }}" class="inline-flex items-center gap-2 bg-[#fc1919] text-white px-8 py-3 rounded-xl font-bold text-sm hover:bg-red-600 transition-all shadow-lg shadow-red-500/20">
            <iconify-icon icon="solar:bag-bold" class="text-base"></iconify-icon>
            Jelajahi Produk Kami
        </a>
    </div>
</div>
@endsection
