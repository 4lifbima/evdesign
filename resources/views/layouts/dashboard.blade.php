<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="dashboardShell()" x-init="init()" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EVDesign') | EVDesign Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E9ECEF; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
        ::-webkit-scrollbar-thumb:hover { background: #fc1919; }

        /* Nav active state */
        .nav-item-active {
            background-color: rgba(252, 25, 25, 0.10);
            color: #fc1919 !important;
            border-right: 3px solid #fc1919;
            font-weight: 600;
        }
        .dark .nav-item-active { background-color: rgba(252, 25, 25, 0.15); }

        /* Badge helpers */
        .badge-success { background-color: rgba(40,167,69,.10); color: #28A745; }
        .badge-danger  { background-color: rgba(220,53,69,.10);  color: #DC3545; }
        .badge-warning { background-color: rgba(255,193,7,.15);  color: #D39E00; }
        .dark .badge-warning { color: #FFC107; }
        .badge-info    { background-color: rgba(23,162,184,.10); color: #17A2B8; }

        /* Form inputs dark */
        .dark input, .dark select, .dark textarea {
            background-color: #1E1E1E;
            color: #f1f5f9;
            border-color: #334155;
        }
        input[type="checkbox"], input[type="radio"] { accent-color: #fc1919; }
    </style>
</head>
<body class="bg-[#f0f7fc] dark:bg-[#121212] text-[#212529] dark:text-gray-100 antialiased overflow-hidden flex h-screen text-sm">

    <!-- Sidebar Overlay (mobile) -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-30 md:hidden" x-cloak></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed md:relative z-40 inset-y-0 left-0 w-72 h-full bg-white dark:bg-[#1E1E1E] border-r border-[#E9ECEF] dark:border-[#334155] transform md:translate-x-0 transition-transform duration-300 flex flex-col flex-shrink-0">

        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-[#E9ECEF] dark:border-[#334155] justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-[#fc1919] rounded-lg flex items-center justify-center text-white flex-shrink-0">
                    <iconify-icon icon="solar:shop-bold" class="text-xl"></iconify-icon>
                </div>
                <span class="text-xl font-bold tracking-tight text-[#212529] dark:text-white">EVDesign<span class="text-[#fc1919]">.</span></span>
            </div>
            <button @click="sidebarOpen = false" class="md:hidden text-[#6C757D] hover:text-[#fc1919]">
                <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-6 px-4">
            <p class="text-[11px] uppercase tracking-widest text-[#6C757D] font-semibold mb-3 px-3">Menu Utama</p>
            <div class="space-y-0.5">
                @php
                    $menus = [
                        ['route' => 'dashboard',       'icon' => 'solar:home-2-bold',                    'label' => 'Dashboard'],
                        ['route' => 'products.index',  'icon' => 'solar:bag-bold',                       'label' => 'Manajemen Produk'],
                        ['route' => 'categories.index','icon' => 'solar:sort-bold',                      'label' => 'Kategori'],
                        ['route' => 'artisans.index',  'icon' => 'solar:users-group-rounded-bold',       'label' => 'Data Perajin'],
                    ];
                    $menus2 = [
                        ['route' => 'materials.index', 'icon' => 'solar:box-bold',                       'label' => 'Inventaris Bahan'],
                        ['route' => 'galleries.index', 'icon' => 'solar:gallery-bold',                   'label' => 'Galeri Karya'],
                        ['route' => 'articles.index',  'icon' => 'solar:notes-bold',                     'label' => 'Artikel & Berita'],
                        ['route' => 'tags.index',      'icon' => 'solar:tag-bold',                       'label' => 'Manajemen Tag'],
                    ];
                @endphp

                @foreach ($menus as $menu)
                    @php $isActive = request()->routeIs($menu['route']) || request()->routeIs(str_replace('.index', '.*', $menu['route'])); @endphp
                    <a href="{{ route($menu['route']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#495057] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors {{ $isActive ? 'nav-item-active' : '' }}">
                        <iconify-icon icon="{{ $menu['icon'] }}" class="text-xl flex-shrink-0"></iconify-icon>
                        <span>{{ $menu['label'] }}</span>
                    </a>
                @endforeach
            </div>

            <p class="text-[11px] uppercase tracking-widest text-[#6C757D] font-semibold mt-6 mb-3 px-3">Operasional</p>
            <div class="space-y-0.5">
                @foreach ($menus2 as $menu)
                    @php $isActive = request()->routeIs($menu['route']) || request()->routeIs(str_replace('.index', '.*', $menu['route'])); @endphp
                    <a href="{{ route($menu['route']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#495057] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors {{ $isActive ? 'nav-item-active' : '' }}">
                        <iconify-icon icon="{{ $menu['icon'] }}" class="text-xl flex-shrink-0"></iconify-icon>
                        <span>{{ $menu['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </nav>

        <!-- Bottom: Settings + Logout -->
        <div class="p-4 border-t border-[#E9ECEF] dark:border-[#334155] space-y-0.5">
            <a href="{{ route('settings.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#495057] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors {{ request()->routeIs('settings.*') ? 'nav-item-active' : '' }}">
                <iconify-icon icon="solar:settings-bold" class="text-xl"></iconify-icon>
                <span>Pengaturan</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#DC3545] hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors font-medium">
                    <iconify-icon icon="solar:logout-2-bold" class="text-xl"></iconify-icon>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">

        <!-- Header -->
        <header class="h-20 flex-shrink-0 bg-white dark:bg-[#1E1E1E] border-b border-[#E9ECEF] dark:border-[#334155] flex items-center justify-between px-4 lg:px-6 z-10">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="md:hidden px-2 py-1 border border-[#E9ECEF] dark:border-[#334155] bg-gray-100 dark:bg-gray-800 rounded-lg text-[#212529] dark:text-white">
                    <iconify-icon icon="solar:hamburger-menu-outline" class="text-xl pt-1"></iconify-icon>
                </button>
                <div class="hidden sm:block">
                    <h1 class="text-lg font-bold text-[#212529] dark:text-white">@yield('title', 'Dashboard')</h1>
                    <p class="text-xs text-[#6C757D]" id="currentDate"></p>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Search -->
                <div class="hidden lg:flex items-center bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] rounded-2xl px-3 py-1 w-56 focus-within:border-[#fc1919] focus-within:ring-2 ring-[#fc1919]/20 transition-all">
                    <iconify-icon icon="solar:magnifer-linear" class="text-[#6C757D] text-lg mr-1"></iconify-icon>
                    <input type="text" placeholder="Cari data..." class="bg-transparent border-none outline-none w-full text-sm text-[#212529] dark:text-white placeholder-[#6C757D]">
                </div>

                <!-- Dark Mode Toggle -->
                <button @click="toggleDarkMode()" class="w-9 h-9 rounded-full flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-[#495057] dark:text-gray-300 hover:text-[#fc1919] transition-colors">
                    <iconify-icon x-show="!darkMode" icon="solar:moon-bold" class="text-lg"></iconify-icon>
                    <iconify-icon x-show="darkMode"  icon="solar:sun-bold"  class="text-lg" x-cloak></iconify-icon>
                </button>

                <!-- Notifications -->
                <button class="relative w-9 h-9 rounded-full flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-[#495057] dark:text-gray-300 hover:text-[#fc1919] transition-colors">
                    <iconify-icon icon="solar:bell-bing-bold" class="text-lg"></iconify-icon>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#fc1919] rounded-full border-2 border-white dark:border-[#1E1E1E]"></span>
                </button>

                <div class="w-px h-7 bg-[#E9ECEF] dark:bg-[#334155] hidden sm:block"></div>

                <!-- User -->
                <div class="flex items-center gap-3 cursor-pointer">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-[#212529] dark:text-white leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#6C757D]">{{ auth()->user()->role ?? 'Admin' }}</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=fc1919&color=fff&bold=true&size=80"
                         alt="Avatar" class="w-9 h-9 rounded-full object-cover border-2 border-[#fc1919]/20">
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            @yield('content')
        </div>
    </main>

    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        // Realtime date
        const dateEl = document.getElementById('currentDate');
        if (dateEl) {
            dateEl.innerText = new Date().toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
        }

        function dashboardShell() {
            return {
                sidebarOpen: false,
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

        // Toast notifications from session flash
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', () => {
                Toastify({ text: "{{ session('success') }}", duration: 3500, gravity: "top", position: "right",
                    style: { background: "linear-gradient(to right, #28A745, #20c554)", borderRadius: "10px" }, stopOnFocus: true }).showToast();
            });
        @endif
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', () => {
                Toastify({ text: "{{ session('error') }}", duration: 4000, gravity: "top", position: "right",
                    style: { background: "linear-gradient(to right, #DC3545, #c82333)", borderRadius: "10px" }, stopOnFocus: true }).showToast();
            });
        @endif
        @if(session('info'))
            document.addEventListener('DOMContentLoaded', () => {
                Toastify({ text: "{{ session('info') }}", duration: 3500, gravity: "top", position: "right",
                    style: { background: "linear-gradient(to right, #17A2B8, #138496)", borderRadius: "10px" }, stopOnFocus: true }).showToast();
            });
        @endif
    </script>
</body>
</html>
