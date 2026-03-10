@php
    $defaultImg = asset('/img/default.jpeg');

    // Cek apakah image_path ada dan file-nya benar-benar exist di storage
    $rawPath = $product->primaryImage?->image_path;
    if ($rawPath) {
        // Kalau URL eksternal (http/https), pakai langsung
        if (str_starts_with($rawPath, 'http://') || str_starts_with($rawPath, 'https://')) {
            $imgUrl = $rawPath;
        } else {
            // Cek apakah file ada di storage
            $fullPath = storage_path('app/public/' . $rawPath);
            $imgUrl = file_exists($fullPath) ? asset('storage/' . $rawPath) : $defaultImg;
        }
    } else {
        $imgUrl = $defaultImg;
    }

    $compact = $compact ?? false;
    $finalPrice = number_format($product->final_price, 0, ',', '.');
    $originalPrice = $product->discount_price ? number_format($product->price, 0, ',', '.') : null;
@endphp

<a href="{{ route('landing.products.show', $product->slug) }}"
   class="product-card group block relative w-full h-full bg-white dark:bg-[#1a1a1a] rounded-[1.5rem] lg:rounded-[1rem] border border-[#E9ECEF] dark:border-[#222] p-3 lg:p-4 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-[#fc1919]/5 hover:border-[#fc1919]/30 dark:hover:border-[#fc1919]/30 hover:-translate-y-1">

    {{-- Wrapper Gambar --}}
    <div class="relative w-full {{ $compact ? 'aspect-square' : 'aspect-[3/4]' }} rounded-2xl overflow-hidden bg-[#F8F9FA] dark:bg-[#111] mb-5">
        <img src="{{ $imgUrl }}" alt="{{ $product->name }}"
             class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105"
             onerror="this.onerror=null;this.src='{{ $defaultImg }}'">
        
        {{-- Badges di pojok kiri atas gambar --}}
        <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
            @if($product->is_new)
                <span class="badge-new text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">BARU</span>
            @endif
            @if($product->discount_price)
                @php $disc = round((1 - $product->discount_price / $product->price) * 100); @endphp
                <span class="badge-sale text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">-{{ $disc }}%</span>
            @endif
            @if($product->is_best_seller)
                <span class="badge-featured text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">🔥 LARIS</span>
            @endif
        </div>
    </div>

    {{-- Info --}}
    <div class="flex flex-col flex-grow">
        {{-- Kategori & Judul --}}
        <h4 class="font-bold text-[#212529] dark:text-white text-base lg:text-lg leading-tight mb-2 tracking-tight line-clamp-2">{{ $product->name }}</h4>
        
        {{-- List Deskripsi Singkat --}}
        @if(!$compact)
        <ul class="text-[11px] lg:text-xs text-[#6C757D] dark:text-gray-400 space-y-1 mb-5 ml-4 list-disc marker:text-[#fc1919] line-clamp-3">
            <li>Kategori: {{ $product->category->name ?? 'Busana' }}</li>
            @if($product->short_description)
                <li>{{ Str::limit($product->short_description, 50) }}</li>
            @else
                <li>Elegan dan nyaman dipakai.</li>
                <li>Desain eksklusif.</li>
            @endif
        </ul>
        @else
        <div class="mb-5"></div>
        @endif
        
        {{-- Spacer --}}
        <div class="mt-auto"></div>

        {{-- Footer area: Size & Price --}}
        <div class="flex items-center justify-between border-t border-[#E9ECEF] dark:border-[#222] pt-4">
            {{-- Size badges (statik sebagai elemen UI sesuai referensi) --}}
            @if(!$compact)
            <div class="flex items-center gap-1 sm:gap-1.5 flex-wrap">
                @foreach(['S', 'M', 'L', 'XL'] as $size)
                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-[#F8F9FA] dark:bg-[#111] border border-[#E9ECEF] dark:border-[#333] flex items-center justify-center text-[#6C757D] dark:text-gray-400 text-[10px] sm:text-xs font-semibold shadow-sm transition-all duration-300 group-hover:border-transparent group-hover:bg-[#fc1919] group-hover:text-white">
                    {{ $size }}
                </div>
                @endforeach
            </div>
            @endif

            {{-- Price --}}
            <div class="text-right flex-shrink-0 {{ $compact ? 'w-full' : 'ml-2' }}">
                @if($originalPrice)
                    <div class="text-[10px] sm:text-xs text-[#6C757D] line-through font-medium leading-none mb-1">Rp {{ $originalPrice }}</div>
                @endif
                <div class="text-sm sm:text-base font-extrabold text-[#fc1919] tracking-tight">
                    {{ $compact ? '' : 'Rp' }} {{ $compact && $originalPrice ? 'Rp' : '' }}{{ $finalPrice }}
                </div>
            </div>
        </div>
    </div>
</a>
