@extends('layouts.landing')

@section('title', $product->name)
@section('page_title', $product->name)
@section('meta_description', $product->meta_description ?? $product->short_description ?? 'Detail produk ' . $product->name . ' dari EVDesign.')

@section('breadcrumb')
<span class="breadcrumb-sep">
    <a href="{{ route('landing.products.index') }}" class="hover:text-[#fc1919] transition-colors">Produk</a>
</span>
<span class="breadcrumb-sep text-[#212529] dark:text-white font-medium truncate max-w-[120px] inline-block">{{ $product->name }}</span>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 lg:px-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mb-12">

        {{-- ═══ IMAGE GALLERY ═══ --}}
        <div x-data="gallery({{ $product->images->pluck('image_path')->map(fn($p) => asset('storage/'.$p))->toJson() }})">
            {{-- Main Image --}}
            <div class="aspect-square rounded-2xl overflow-hidden bg-[#f5f5f5] dark:bg-[#1a1a1a] border border-[#E9ECEF] dark:border-[#222] mb-3">
                <img :src="mainImage"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover transition-all duration-300"
                     onerror="this.src='{{ asset('/img/default.jpeg') }}'">
            </div>
            {{-- Thumbnails --}}
            @if($product->images->count() > 1)
            <div class="flex gap-2 overflow-x-auto pb-1">
                <template x-for="(img, ix) in images" :key="ix">
                    <button @click="mainImage = img"
                            :class="mainImage === img ? 'border-[#fc1919] ring-2 ring-[#fc1919]/30' : 'border-[#E9ECEF] dark:border-[#333]'"
                            class="w-16 h-16 flex-shrink-0 rounded-xl overflow-hidden border-2 transition-all">
                        <img :src="img" alt="" class="w-full h-full object-cover">
                    </button>
                </template>
            </div>
            @endif
        </div>

        {{-- ═══ PRODUCT INFO ═══ --}}
        <div class="flex flex-col gap-4">

            {{-- Badges --}}
            <div class="flex flex-wrap gap-2">
                @if($product->is_new)
                    <span class="badge-new text-xs font-bold px-3 py-1 rounded-full">BARU</span>
                @endif
                @if($product->is_best_seller)
                    <span class="badge-featured text-xs font-bold px-3 py-1 rounded-full">🔥 TERLARIS</span>
                @endif
                @if($product->category)
                    <a href="{{ route('landing.categories.show', $product->category->slug ?? $product->category->id) }}"
                       class="inline-flex items-center gap-1 text-xs font-medium px-3 py-1 rounded-full bg-[#fc1919]/10 text-[#fc1919] hover:bg-[#fc1919] hover:text-white transition-colors">
                        <iconify-icon icon="solar:sort-bold" class="text-sm"></iconify-icon>
                        {{ $product->category->name }}
                    </a>
                @endif
            </div>

            {{-- Name --}}
            <h2 class="text-2xl font-extrabold text-[#212529] dark:text-white leading-tight">{{ $product->name }}</h2>

            {{-- Short desc --}}
            @if($product->short_description)
            <p class="text-sm text-[#6C757D] leading-relaxed">{{ $product->short_description }}</p>
            @endif

            {{-- Price --}}
            <div class="flex items-baseline gap-3 py-3 border-y border-[#E9ECEF] dark:border-[#222]">
                <span class="text-3xl font-extrabold text-[#fc1919]">Rp {{ number_format($product->final_price, 0, ',', '.') }}</span>
                @if($product->discount_price)
                @php $disc = round((1 - $product->discount_price / $product->price) * 100); @endphp
                <span class="text-base price-original text-[#6C757D]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="text-xs bg-[#fc1919] text-white font-bold px-2 py-0.5 rounded-full">Hemat {{ $disc }}%</span>
                @endif
            </div>

            {{-- Stock --}}
            <div class="flex items-center gap-2 text-sm">
                @if($product->stock > 0)
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="text-green-600 dark:text-green-400 font-medium">Tersedia</span>
                <span class="text-[#6C757D]">(Stok: {{ $product->stock }})</span>
                @else
                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                <span class="text-red-500 font-medium">Stok Habis</span>
                @endif
            </div>

            {{-- Colors / Sizes --}}
            @if($product->colors)
            <div>
                <p class="text-xs font-semibold text-[#6C757D] uppercase tracking-wide mb-2">Warna Tersedia</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($product->colors as $color)
                    <span class="text-xs font-medium px-3 py-1 rounded-full border border-[#E9ECEF] dark:border-[#333] text-[#495057] dark:text-gray-300">{{ $color }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            @if($product->sizes)
            <div>
                <p class="text-xs font-semibold text-[#6C757D] uppercase tracking-wide mb-2">Ukuran</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($product->sizes as $size)
                    <span class="text-xs font-medium px-3 py-1 rounded-full border border-[#E9ECEF] dark:border-[#333] text-[#495057] dark:text-gray-300">{{ $size }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Variants --}}
            @if($product->variants->isNotEmpty())
            <div>
                <p class="text-xs font-semibold text-[#6C757D] uppercase tracking-wide mb-2">Varian</p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($product->variants->where('is_active', true) as $variant)
                    <div class="text-xs p-2 rounded-xl border border-[#E9ECEF] dark:border-[#333] flex justify-between items-center">
                        <span class="font-medium text-[#212529] dark:text-white">{{ $variant->name }}</span>
                        @if($variant->price)
                        <span class="text-[#fc1919] font-bold">Rp {{ number_format($variant->price, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- CTA --}}
            <div class="flex gap-3 pt-2">
                <a href="{{ route('landing.contact') }}"
                   class="flex-1 flex items-center justify-center gap-2 py-3 bg-[#fc1919] text-white rounded-xl font-bold text-sm hover:bg-red-600 transition-all shadow-lg shadow-red-500/20 hover:shadow-red-500/40 hover:-translate-y-0.5">
                    <iconify-icon icon="solar:phone-bold" class="text-base"></iconify-icon>
                    Pesan Sekarang
                </a>
                <a href="https://wa.me/?text={{ urlencode('Halo, saya tertarik dengan produk ' . $product->name . ' dari EVDesign.') }}" target="_blank"
                   class="flex items-center justify-center gap-2 px-4 py-3 border-2 border-[#25D366] text-[#25D366] rounded-xl font-bold text-sm hover:bg-[#25D366] hover:text-white transition-all">
                    <iconify-icon icon="ic:baseline-whatsapp" class="text-lg"></iconify-icon>
                    WhatsApp
                </a>
            </div>

        </div>
    </div>

    {{-- ═══ DETAIL TABS ═══ --}}
    <div x-data="{ tab: 'desc' }" class="mb-10">
        <div class="flex gap-1 border-b border-[#E9ECEF] dark:border-[#222] mb-5 overflow-x-auto">
            @foreach([['desc','Deskripsi'],['specs','Spesifikasi']] as [$val,$label])
            <button @click="tab = '{{ $val }}'"
                    :class="tab === '{{ $val }}' ? 'border-b-2 border-[#fc1919] text-[#fc1919] font-semibold' : 'text-[#6C757D] hover:text-[#212529] dark:hover:text-white'"
                    class="px-5 py-3 text-sm whitespace-nowrap transition-colors -mb-px">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- Description --}}
        <div x-show="tab === 'desc'" class="prose prose-sm dark:prose-invert max-w-none text-[#495057] dark:text-gray-300 leading-relaxed">
            @if($product->description)
                {!! nl2br(e($product->description)) !!}
            @else
                <p class="text-[#6C757D]">Belum ada deskripsi lengkap untuk produk ini.</p>
            @endif
        </div>

        {{-- Specs --}}
        <div x-show="tab === 'specs'" class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm" x-cloak>
            @php
                $specs = [
                    'SKU'        => $product->sku,
                    'Barcode'    => $product->barcode,
                    'Dimensi'    => $product->dimensions ? implode(', ', $product->dimensions) : null,
                    'Material'   => $product->materials ? implode(', ', $product->materials) : null,
                    'Warna'      => $product->colors ? implode(', ', $product->colors) : null,
                    'Ukuran'     => $product->sizes ? implode(', ', $product->sizes) : null,
                    'Stok'       => $product->stock,
                    'Status'     => ucfirst($product->status),
                ];
            @endphp
            @foreach($specs as $key => $val)
            @if($val)
            <div class="flex items-start p-3 bg-white dark:bg-[#1a1a1a] rounded-xl border border-[#E9ECEF] dark:border-[#222]">
                <span class="text-xs font-semibold text-[#6C757D] w-24 flex-shrink-0 uppercase tracking-wide">{{ $key }}</span>
                <span class="text-[#212529] dark:text-white font-medium text-sm">{{ $val }}</span>
            </div>
            @endif
            @endforeach
        </div>

    </div>

    {{-- ═══ PRODUK TERKAIT ═══ --}}
    @if($related->isNotEmpty())
    <section>
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-[#212529] dark:text-white">Produk Terkait</h3>
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 rounded-full border border-[#E9ECEF] dark:border-[#333] flex items-center justify-center text-[#6C757D] hover:text-[#fc1919] hover:border-[#fc1919] transition-colors">
                    <iconify-icon icon="solar:arrow-left-linear" class="text-sm"></iconify-icon>
                </button>
                <button class="w-8 h-8 rounded-full border border-[#E9ECEF] dark:border-[#333] flex items-center justify-center text-[#6C757D] hover:text-[#fc1919] hover:border-[#fc1919] transition-colors">
                    <iconify-icon icon="solar:arrow-right-linear" class="text-sm"></iconify-icon>
                </button>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($related as $rel)
                @include('landing.partials.product-card', ['product' => $rel])
            @endforeach
        </div>
    </section>
    @endif
</div>

@push('scripts')
<script>
function gallery(images) {
    return {
        images: images.length ? images : ['https://placehold.co/600x600/fc1919/fff?text=EV'],
        mainImage: images.length ? images[0] : 'https://placehold.co/600x600/fc1919/fff?text=EV',
    }
}
</script>
@endpush
@endsection
