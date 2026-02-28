<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EVDesign') }}</title>

    <!-- Fonts — same as dashboard -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Iconify — same as dashboard -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        /* Input focus ring overrides */
        input:focus { outline: none; border-color: #fc1919 !important; box-shadow: 0 0 0 3px rgba(252,25,25,0.12); }
        input[type="checkbox"] { accent-color: #fc1919; }

        /* Subtle red diagonal stripe pattern on left panel */
        .auth-pattern {
            background-color: #fc1919;
            background-image: repeating-linear-gradient(
                -45deg,
                rgba(255,255,255,0.04) 0px,
                rgba(255,255,255,0.04) 2px,
                transparent 2px,
                transparent 12px
            );
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeup { animation: fadeUp 0.45s ease both; }
    </style>
</head>
<body class="bg-[#F8F9FA] text-[#212529] antialiased min-h-screen flex">

    {{-- Left panel (decorative, hidden on mobile) --}}
    <div class="hidden lg:flex lg:w-2/5 xl:w-1/2 auth-pattern flex-col justify-between p-12 relative overflow-hidden">
        <!-- Brand -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <iconify-icon icon="solar:shop-bold" class="text-2xl text-white"></iconify-icon>
            </div>
            <span class="text-2xl font-bold text-white tracking-tight">EVDesign<span class="opacity-60">.</span></span>
        </div>

        <!-- Tagline -->
        <div class="text-white">
            <h2 class="text-4xl font-bold leading-tight mb-4">
                Pelestarian<br>Wastra Gorontalo
            </h2>
            <p class="text-white/70 text-base leading-relaxed">
                Platform digital untuk mengelola produk, perajin, dan kisah di balik keindahan kain tradisional Gorontalo.
            </p>
        </div>

        <!-- Decorative circle -->
        <div class="absolute -bottom-24 -right-24 w-64 h-64 rounded-full bg-white/10"></div>
        <div class="absolute top-1/2 -right-12 w-32 h-32 rounded-full bg-white/5"></div>
    </div>

    {{-- Right panel (form) --}}
    <div class="flex-1 flex flex-col justify-center items-center p-6 lg:p-12 bg-white dark:bg-[#121212]">
        <!-- Mobile logo -->
        <div class="lg:hidden flex items-center gap-2 mb-8">
            <div class="w-8 h-8 bg-[#fc1919] rounded-lg flex items-center justify-center">
                <iconify-icon icon="solar:shop-bold" class="text-white text-lg"></iconify-icon>
            </div>
            <span class="text-xl font-bold text-[#212529] dark:text-white">EVDesign<span class="text-[#fc1919]">.</span></span>
        </div>

        <div class="w-full max-w-md animate-fadeup">
            {{ $slot }}
        </div>

        <p class="mt-10 text-xs text-[#6C757D] text-center">
            &copy; {{ date('Y') }} EVDesign - Pelestarian Wastra Gorontalo
        </p>
    </div>

</body>
</html>
