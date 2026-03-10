<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="landingShell()" x-init="init()" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Katalog') | EVDesign</title>
    <meta name="description" content="@yield('meta_description', 'Temukan produk kerajinan tangan berkualitas tinggi dari para perajin terbaik Indonesia di EVDesign.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ─── Scrollbar ─── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E9ECEF; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
        ::-webkit-scrollbar-thumb:hover { background: #fc1919; }

        /* ─── Sidebar nav active ─── */
        .nav-landing-active {
            background: linear-gradient(135deg, rgba(252,25,25,0.12) 0%, rgba(252,25,25,0.06) 100%);
            color: #fc1919 !important;
            border-left: 3px solid #fc1919;
            font-weight: 600;
        }
        .dark .nav-landing-active { background: rgba(252,25,25,0.15); }

        /* ─── Product cards ─── */
        .product-card { transition: transform 0.25s cubic-bezier(.4,0,.2,1), box-shadow 0.25s cubic-bezier(.4,0,.2,1); }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,0.12); }
        .dark .product-card:hover { box-shadow: 0 16px 40px rgba(0,0,0,0.5); }

        /* ─── Badge helpers ─── */
        .badge-new      { background: rgba(252,25,25,.1); color:#fc1919; }
        .badge-sale     { background: rgba(252,25,25,1); color:#fff; }
        .badge-featured { background: rgba(255,193,7,.15); color:#D39E00; }
        .dark .badge-featured { color:#FFC107; }

        /* ─── Smooth sidebar overlay ─── */
        [x-cloak] { display:none !important; }

        /* ─── Sidebar collapsed animation ─── */
        .sidebar-transition { transition: width 0.3s cubic-bezier(.4,0,.2,1), transform 0.3s cubic-bezier(.4,0,.2,1); }

        /* ─── Range slider custom ─── */
        input[type="range"] { accent-color: #fc1919; }
        input[type="checkbox"], input[type="radio"] { accent-color: #fc1919; }

        /* ─── Gradient hero ─── */
        .hero-gradient {
            background: linear-gradient(135deg, #1a0000 0%, #2d0505 40%, #1a0808 100%);
        }
        .dark .hero-gradient {
            background: linear-gradient(135deg, #0d0000 0%, #1a0202 40%, #0d0000 100%);
        }

        /* ─── Category pill hover ─── */
        .cat-pill { transition: all .2s ease; }
        .cat-pill:hover, .cat-pill.active {
            background-color: #fc1919;
            color: #fff;
            border-color: #fc1919;
        }

        /* ─── Search ─── */
        .search-ring:focus-within { border-color: #fc1919; box-shadow: 0 0 0 3px rgba(252,25,25,0.1); }

        /* ─── Breadcrumb separator ─── */
        .breadcrumb-sep::before { content: '/'; margin: 0 6px; opacity: .4; }

        /* ─── Animate fade in ─── */
        @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .fade-up { animation: fadeUp 0.5s ease forwards; }

        /* ─── Price strike ─── */
        .price-original { text-decoration: line-through; opacity: .5; }

        /* ─── Sidebar for mobile ─── */
        /* Filter harga dimatikan dari sidebar */
        .price-filter-sidebar { display: none; }
    </style>

    @stack('styles')
</head>
<body class="bg-[#fcfcfc] dark:bg-[#0a0a0a] text-[#212529] dark:text-gray-100 antialiased flex flex-col min-h-screen">

    <!-- Mobile Overlay -->
    <div x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden" x-cloak></div>

    <!-- ═══════════════════════════════ MOBILE SIDEBAR (OFFCANVAS) ═══════════════════════════════ -->
    <aside
        :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="sidebar-transition fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-[#161616] border-r border-[#E9ECEF] dark:border-[#1e1e1e] flex flex-col lg:hidden">

        <!-- Logo -->
        <div class="h-[70px] flex items-center px-5 border-b border-[#E9ECEF] dark:border-[#1e1e1e] justify-between flex-shrink-0">
            <a href="{{ route('landing.home') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white flex-shrink-0 shadow-lg shadow-red-500/30">
                    <img src="{{ asset('img/icon.jpg') }}" alt="EVDesign" class="w-full h-full rounded-xl border-2 border-red-500 object-cover">
                </div>
                <div>
                    <span class="text-xl font-bold tracking-tight text-[#212529] dark:text-white leading-none">EVDesign<span class="text-[#fc1919]">.</span></span>
                </div>
            </a>
            <button @click="mobileSidebarOpen = false" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-[#6C757D]">
                <iconify-icon icon="ic:round-close" class="text-xl"></iconify-icon>
            </button>
        </div>

        <!-- Mobile Search -->
        <div class="px-4 py-3 border-b border-[#E9ECEF] dark:border-[#1e1e1e] flex-shrink-0">
            <form action="{{ route('landing.products.index') }}" method="GET">
                <div class="flex items-center bg-[#F8F9FA] dark:bg-[#0f0f0f] rounded-xl px-3 py-2 gap-2 search-ring border border-transparent transition-all">
                    <iconify-icon icon="solar:magnifer-linear" class="text-[#6C757D] text-base flex-shrink-0"></iconify-icon>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." class="bg-transparent border-none outline-none w-full text-sm text-[#212529] dark:text-white placeholder-[#6C757D]">
                </div>
            </form>
        </div>

        <!-- Navigation Mobile -->
        <nav class="flex-1 overflow-y-auto py-4 px-3">
            <p class="text-[10px] uppercase tracking-widest text-[#ADB5BD] font-semibold mb-2 px-3">Menu</p>
            <div class="space-y-0.5 mb-5">
                @php
                    $navs = [
                        ['route' => 'landing.home',           'icon' => 'solar:home-2-bold',         'label' => 'Beranda'],
                        ['route' => 'landing.products.index', 'icon' => 'solar:bag-bold',             'label' => 'Katalog'],
                        ['route' => 'landing.categories.index','icon'=> 'solar:sort-bold',            'label' => 'Kategori'],
                        ['route' => 'landing.about',          'icon' => 'solar:info-circle-bold',    'label' => 'Tentang'],
                        ['route' => 'landing.contact',        'icon' => 'solar:phone-bold',          'label' => 'Kontak'],
                    ];
                @endphp
                @foreach($navs as $item)
                    @php $active = request()->routeIs($item['route']); @endphp
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[#495057] dark:text-gray-400 hover:bg-[#F8F9FA] dark:hover:bg-[#1e1e1e] transition-colors text-sm {{ $active ? 'nav-landing-active' : '' }}">
                        <iconify-icon icon="{{ $item['icon'] }}" class="text-lg flex-shrink-0"></iconify-icon>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </nav>

        <!-- Bottom Mobile Menu -->
        <div class="p-4 border-t border-[#E9ECEF] dark:border-[#1e1e1e] flex-shrink-0">
            @auth
            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-[#F8F9FA] dark:bg-[#1e1e1e] hover:bg-[#fc1919]/10 transition-colors text-sm group">
                <div class="w-7 h-7 rounded-full bg-[#fc1919] flex items-center justify-center text-white text-xs flex-shrink-0">
                    <iconify-icon icon="solar:user-bold" class="text-sm"></iconify-icon>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-xs text-[#212529] dark:text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-[#6C757D] truncate">Masuk Dashboard</p>
                </div>
            </a>
            @else
            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full py-2.5 bg-[#fc1919] text-white rounded-xl text-sm font-semibold hover:bg-red-600 transition-colors">
                <iconify-icon icon="solar:login-bold" class="text-base"></iconify-icon>
                Masuk System
            </a>
            @endauth
        </div>
    </aside>

    <!-- ═══════════════════════════════ MAIN CONTENT CONTENT ═══════════════════════════════ -->
    <div class="flex-1 flex flex-col w-full">

        <!-- ─── DESKTOP NAVBAR (TOPBAR) ─── -->
        <header class="sticky top-0 z-30 w-full bg-white/80 dark:bg-[#0a0a0a]/80 backdrop-blur-xl border-b border-[#E9ECEF]/80 dark:border-[#1e1e1e]/80 transition-all shadow-sm">
            <div class="max-w-7xl mx-auto px-4 lg:px-8 h-[76px] flex items-center justify-between gap-6">
                
                <!-- Kiri: Mobile Toggle & Logo -->
                <div class="flex items-center gap-3">
                    <!-- Mobile Button -->
                    <button @click="mobileSidebarOpen = true"
                            class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center bg-gray-50 dark:bg-[#161616] text-[#212529] dark:text-white hover:text-[#fc1919] transition-colors border border-gray-100 dark:border-[#1e1e1e]">
                        <iconify-icon icon="ci:hamburger-md" class="text-xl"></iconify-icon>
                    </button>
                    <!-- Desktop Logo -->
                    <a href="{{ route('landing.home') }}" class="hidden lg:flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl overflow-hidden shadow-lg shadow-red-500/20 group-hover:scale-105 transition-transform duration-300">
                            <img src="{{ asset('img/icon.jpg') }}" alt="EVDesign" class="w-full h-full object-cover">
                        </div>
                        <span class="text-xl font-extrabold tracking-tight text-[#212529] dark:text-white">EVDesign<span class="text-[#fc1919]">.</span></span>
                    </a>
                </div>

                <!-- Tengah: Main Desktop Navigation -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                    @foreach($navs as $item)
                        @php $active = request()->routeIs($item['route']) || (request()->routeIs('landing.categories.show') && $item['route'] == 'landing.categories.index') || (request()->routeIs('landing.products.show') && $item['route'] == 'landing.products.index'); @endphp
                        <a href="{{ route($item['route']) }}" 
                           class="relative px-4 py-2 text-sm font-semibold rounded-full transition-all duration-300 {{ $active ? 'text-[#fc1919] bg-red-50 dark:bg-red-500/10' : 'text-[#6C757D] dark:text-gray-400 hover:text-[#212529] dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <!-- Kanan: Mobile (Dark Mode & Logo) | Desktop (Search, Dark, Auth) -->
                <div class="flex items-center gap-3">
                    
                    <!-- ====== MOBILE RIGHT ====== -->
                    <div class="flex lg:hidden items-center gap-3">
                        <!-- Dark Mode Toggle -->
                        <button @click="toggleDarkMode()"
                                class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-50 dark:bg-[#161616] text-[#6C757D] dark:text-gray-400 hover:text-[#fc1919] border border-gray-100 dark:border-[#222] transition-colors">
                            <iconify-icon x-show="!darkMode" icon="solar:moon-bold-duotone" class="text-xl"></iconify-icon>
                            <iconify-icon x-show="darkMode" icon="solar:sun-bold-duotone" class="text-xl" x-cloak></iconify-icon>
                        </button>
                        <!-- Mobile Logo -->
                        <a href="{{ route('landing.home') }}" class="flex items-center gap-2 group">
                            <span class="text-xl font-extrabold tracking-tight text-[#212529] dark:text-white hidden sm:block">EVDesign<span class="text-[#fc1919]">.</span></span>
                            <div class="w-10 h-10 rounded-xl overflow-hidden shadow-lg shadow-red-500/20 active:scale-95 transition-transform duration-300">
                                <img src="{{ asset('img/icon.jpg') }}" alt="EVDesign" class="w-full h-full object-cover">
                            </div>
                        </a>
                    </div>

                    <!-- ====== DESKTOP RIGHT ====== -->
                    <!-- Desktop Search -->
                    <form action="{{ route('landing.products.index') }}" method="GET" class="hidden lg:flex items-center bg-gray-50 dark:bg-[#161616] rounded-full px-4 py-2 border border-gray-200 dark:border-[#222] focus-within:border-[#fc1919] focus-within:ring-2 focus-within:ring-red-500/20 transition-all w-48 xl:w-64">
                        <iconify-icon icon="solar:magnifer-linear" class="text-[#6C757D] text-lg flex-shrink-0"></iconify-icon>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Temukan produk..." class="bg-transparent border-none outline-none w-full text-sm text-[#212529] dark:text-white placeholder-[#6C757D] px-2">
                    </form>

                    <!-- Dark mode Desktop -->
                    <button @click="toggleDarkMode()"
                            class="hidden lg:flex w-10 h-10 rounded-full items-center justify-center bg-gray-50 dark:bg-[#161616] text-[#6C757D] dark:text-gray-400 hover:text-[#fc1919] hover:bg-red-50 dark:hover:bg-red-500/10 border border-gray-100 dark:border-[#222] transition-colors">
                        <iconify-icon x-show="!darkMode" icon="solar:moon-bold-duotone" class="text-xl"></iconify-icon>
                        <iconify-icon x-show="darkMode" icon="solar:sun-bold-duotone" class="text-xl" x-cloak></iconify-icon>
                    </button>

                    <!-- Auth Button (Desktop) -->
                    <div class="hidden lg:flex items-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 pl-2 pr-4 py-1.5 bg-gray-50 dark:bg-[#161616] border border-gray-200 dark:border-[#222] rounded-full hover:border-[#fc1919] dark:hover:border-[#fc1919] transition-colors group">
                                <div class="w-7 h-7 rounded-full bg-[#fc1919] flex items-center justify-center text-white text-xs shadow-md">
                                    <iconify-icon icon="solar:user-bold"></iconify-icon>
                                </div>
                                <span class="text-sm font-semibold text-[#212529] dark:text-white whitespace-nowrap">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center gap-2 px-5 py-2.5 bg-black dark:bg-white text-white dark:text-black rounded-full text-sm font-semibold hover:bg-gray-800 dark:hover:bg-gray-200 hover:-translate-y-0.5 shadow-lg transition-transform">
                                Masuk
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            
            <!-- Breadcrumb Mobile (Opsional jika ingin dirender khusus, atau dibuang karena nav desktop sudah jelas) -->
            @hasSection('breadcrumb')
            <div class="lg:hidden bg-gray-50/50 dark:bg-[#111] border-b border-gray-100 dark:border-[#1e1e1e] px-4 py-2 flex items-center gap-2 text-[11px] uppercase tracking-wider font-semibold text-[#6C757D]">
                <a href="{{ route('landing.home') }}">Beranda</a>
                <span class="opacity-50">/</span>
                @yield('breadcrumb')
            </div>
            @endif
        </header>

        <!-- ─── Page Content ─── -->
        <main class="flex-1 w-full max-w-7xl mx-auto py-6 px-4 lg:px-8">
            @yield('content')
        </main>

        <!-- ─── Modern Footer ─── -->
        <footer class="bg-black text-white dark:bg-[#050505] dark:border-t dark:border-[#222] pt-16 pb-8 mt-auto">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-12">
                    <div class="md:col-span-1">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-[#fc1919] rounded-xl flex items-center justify-center shadow-lg shadow-red-500/30">
                                <iconify-icon icon="solar:shop-bold" class="text-xl text-white"></iconify-icon>
                            </div>
                            <span class="text-2xl font-extrabold tracking-tight">EVDesign<span class="text-[#fc1919]">.</span></span>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                            Platform katalog eksklusif untuk kerajinan tangan khas Gorontalo dan Nusantara. Memberdayakan perajin lokal untuk pasar global.
                        </p>
                    </div>
                    
                    <div class="flex flex-col gap-3">
                        <h4 class="font-bold text-lg mb-2">Tautan Navigasi</h4>
                        <a href="{{ route('landing.home') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Beranda</a>
                        <a href="{{ route('landing.products.index') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Katalog Produk</a>
                        <a href="{{ route('landing.categories.index') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Semua Kategori</a>
                    </div>
                    
                    <div class="flex flex-col gap-3">
                        <h4 class="font-bold text-lg mb-2">Hubungi Kami</h4>
                        <a href="{{ route('landing.about') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Tentang Kami</a>
                        <a href="{{ route('landing.contact') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Informasi Kontak</a>
                    </div>
                </div>
                
                <div class="border-t border-white/10 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-gray-500">© {{ date('Y') }} EVDesign. Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Alpine.js Data -->
    <script>
        function landingShell() {
            return {
                mobileSidebarOpen: false,
                darkMode: localStorage.getItem('color-theme') === 'dark' ||
                          (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
                init() {
                    if (this.darkMode) document.documentElement.classList.add('dark');
                    else document.documentElement.classList.remove('dark');
                },
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }
                }
            }
        }

        function priceFilter() {
            return {
                minPrice: 0,
                maxPrice: parseInt(new URLSearchParams(location.search).get('max_price')) || 5000000,
                buildUrl() {
                    const p = new URLSearchParams(location.search);
                    p.set('max_price', this.maxPrice);
                    return '{{ route("landing.products.index") }}?' + p.toString();
                }
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
