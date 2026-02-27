<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="dashboardShell()" x-init="init()" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EVDesign Dashboard')</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="bg-slate-100 text-slate-700 dark:bg-slate-950 dark:text-slate-200 antialiased text-sm">
<div class="min-h-screen flex" @keydown.escape.window="sidebarOpen = false">
    <div x-show="sidebarOpen" class="fixed inset-0 bg-black/40 z-30 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed lg:static z-40 inset-y-0 left-0 w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 transform lg:translate-x-0 transition-transform duration-200 flex flex-col">
        <div class="h-20 flex items-center px-6 border-b border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-3 text-slate-900 dark:text-slate-100">
                <iconify-icon icon="solar:tshirt-linear" class="text-2xl text-red-600"></iconify-icon>
                <span class="text-xl tracking-tight font-semibold">EVDESIGN</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
            @php
                $menus = [
                    ['route' => 'dashboard', 'icon' => 'solar:home-2-linear', 'label' => 'Dashboard'],
                    ['route' => 'products.index', 'icon' => 'solar:bag-linear', 'label' => 'Manajemen Produk'],
                    ['route' => 'categories.index', 'icon' => 'solar:sort-linear', 'label' => 'Manajemen Kategori'],
                    ['route' => 'artisans.index', 'icon' => 'solar:users-group-rounded-linear', 'label' => 'Binaan & Perajin'],
                    ['route' => 'materials.index', 'icon' => 'solar:box-linear', 'label' => 'Inventaris Bahan'],
                    ['route' => 'tags.index', 'icon' => 'solar:tag-linear', 'label' => 'Manajemen Tag'],
                    ['route' => 'galleries.index', 'icon' => 'solar:gallery-linear', 'label' => 'Galeri Karya'],
                    ['route' => 'articles.index', 'icon' => 'solar:notes-linear', 'label' => 'Artikel & Berita'],
                    ['route' => 'settings.index', 'icon' => 'solar:settings-linear', 'label' => 'Pengaturan'],
                ];
            @endphp

            @foreach ($menus as $menu)
                @php $isActive = request()->routeIs($menu['route']) || request()->routeIs(str_replace('.index', '.*', $menu['route'])); @endphp
                <a href="{{ route($menu['route']) }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition {{ $isActive ? 'bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                    <iconify-icon icon="{{ $menu['icon'] }}" class="text-lg"></iconify-icon>
                    <span>{{ $menu['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between gap-3 px-2 py-2">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->role ?? 'staff' }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-slate-500 hover:text-red-600" type="submit">
                        <iconify-icon icon="solar:logout-linear" class="text-xl"></iconify-icon>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-1 min-w-0 flex flex-col">
        <header class="h-20 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-4 lg:px-8">
            <div class="flex items-center gap-3">
                <button class="lg:hidden text-slate-600 dark:text-slate-300" @click="sidebarOpen = true">
                    <iconify-icon icon="solar:hamburger-menu-linear" class="text-2xl"></iconify-icon>
                </button>
                <div>
                    <h1 class="text-xl lg:text-2xl text-slate-900 dark:text-slate-100 font-semibold tracking-tight">@yield('title', 'Dashboard')</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">EVDesign Manajemen Produk/Catalog</p>
                </div>
            </div>
            <button class="text-slate-600 dark:text-slate-300" @click="toggleDarkMode">
                <iconify-icon x-show="!darkMode" icon="solar:moon-linear" class="text-xl"></iconify-icon>
                <iconify-icon x-show="darkMode" icon="solar:sun-2-linear" class="text-xl" x-cloak></iconify-icon>
            </button>
        </header>

        <main class="flex-1 overflow-y-auto p-4 lg:p-8">
            @if (session('success'))
                <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 text-red-700 px-4 py-3">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
    function dashboardShell() {
        return {
            sidebarOpen: false,
            darkMode: false,
            init() {
                const saved = localStorage.getItem('evdesign-theme');
                this.darkMode = saved ? saved === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
            },
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                localStorage.setItem('evdesign-theme', this.darkMode ? 'dark' : 'light');
            }
        }
    }
</script>
</body>
</html>
