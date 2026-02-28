@extends('layouts.dashboard')
@section('title', 'Dashboard Utama')
@section('content')

<div class="space-y-6">

    {{-- ── STAT CARDS ────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- Card: Total Produk --}}
        <div class="bg-white dark:bg-[#1E1E1E] rounded-2xl p-5 border-l-4 border-[#fc1919] border border-[#E9ECEF] dark:border-[#334155] group hover:-translate-y-1 transition-transform duration-300 shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-[#6C757D] mb-1">Total Produk</p>
                    <p class="font-mono text-3xl font-bold text-[#212529] dark:text-white">{{ $stats['products'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#fc1919]/10 flex items-center justify-center text-[#fc1919] group-hover:scale-110 transition-transform">
                    <iconify-icon icon="solar:bag-bold" class="text-2xl"></iconify-icon>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm gap-1">
                <span class="text-[#28A745] font-semibold flex items-center gap-0.5">
                    <iconify-icon icon="solar:arrow-right-up-linear"></iconify-icon> Aktif
                </span>
                <span class="text-[#6C757D]">di katalog</span>
            </div>
        </div>

        {{-- Card: Perajin Binaan --}}
        <div class="bg-white dark:bg-[#1E1E1E] rounded-2xl p-5 border-l-4 border-[#fc1919] border border-[#E9ECEF] dark:border-[#334155] group hover:-translate-y-1 transition-transform duration-300 shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-[#6C757D] mb-1">Perajin Binaan</p>
                    <p class="font-mono text-3xl font-bold text-[#212529] dark:text-white">{{ $stats['artisans'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#fc1919]/10 flex items-center justify-center text-[#fc1919] group-hover:scale-110 transition-transform">
                    <iconify-icon icon="solar:users-group-two-rounded-bold" class="text-2xl"></iconify-icon>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm gap-1">
                <span class="text-[#28A745] font-semibold flex items-center gap-0.5">
                    <iconify-icon icon="solar:check-circle-bold"></iconify-icon> Aktif
                </span>
                <span class="text-[#6C757D]">berproduksi</span>
            </div>
        </div>

        {{-- Card: Kategori --}}
        <div class="bg-white dark:bg-[#1E1E1E] rounded-2xl p-5 border-l-4 border-[#fc1919] border border-[#E9ECEF] dark:border-[#334155] group hover:-translate-y-1 transition-transform duration-300 shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-[#6C757D] mb-1">Total Kategori</p>
                    <p class="font-mono text-3xl font-bold text-[#212529] dark:text-white">{{ $stats['categories'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#fc1919]/10 flex items-center justify-center text-[#fc1919] group-hover:scale-110 transition-transform">
                    <iconify-icon icon="solar:sort-bold" class="text-2xl"></iconify-icon>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm gap-1">
                <span class="text-[#17A2B8] font-semibold flex items-center gap-0.5">
                    <iconify-icon icon="solar:layers-bold"></iconify-icon> Terstruktur
                </span>
                <span class="text-[#6C757D]">hierarki</span>
            </div>
        </div>

        {{-- Card: Stok Menipis --}}
        <div class="bg-white dark:bg-[#1E1E1E] rounded-2xl p-5 border-l-4 border-[#FFC107] border border-[#E9ECEF] dark:border-[#334155] group hover:-translate-y-1 transition-transform duration-300 shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-[#6C757D] mb-1">Peringatan Stok</p>
                    <p class="font-mono text-3xl font-bold text-[#212529] dark:text-white">{{ $stats['low_stock_materials'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#FFC107]/20 flex items-center justify-center text-[#D39E00] dark:text-[#FFC107] group-hover:scale-110 transition-transform">
                    <iconify-icon icon="solar:danger-triangle-bold" class="text-2xl"></iconify-icon>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm gap-1">
                <span class="text-[#D39E00] dark:text-[#FFC107] font-semibold flex items-center gap-0.5">
                    <iconify-icon icon="solar:info-circle-bold"></iconify-icon> Menipis
                </span>
                <span class="text-[#6C757D]">butuh re-stock</span>
            </div>
        </div>
    </div>

    {{-- ── CHARTS ROW ───────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Timeseries Area Chart --}}
        <div class="lg:col-span-2 bg-white dark:bg-[#1E1E1E] rounded-2xl p-6 border border-[#E9ECEF] dark:border-[#334155] shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
            <div class="flex justify-between items-center mb-5">
                <h4 class="font-bold text-[#212529] dark:text-white text-base">Tren Penjualan Produk</h4>
                <select id="yearSelect" class="bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] rounded-lg px-3 py-1.5 text-sm outline-none focus:border-[#fc1919] text-[#212529] dark:text-white">
                    <option>{{ now()->year }}</option>
                    <option>{{ now()->year - 1 }}</option>
                </select>
            </div>
            <div id="timeseriesChart" class="h-72"></div>
        </div>

        {{-- Donut Chart --}}
        <div class="bg-white dark:bg-[#1E1E1E] rounded-2xl p-6 border border-[#E9ECEF] dark:border-[#334155] shadow-[0_2px_8px_rgba(0,0,0,0.04)] flex flex-col">
            <h4 class="font-bold text-[#212529] dark:text-white text-base mb-4">Distribusi Status Produk</h4>
            <div class="flex-1 flex items-center justify-center min-h-[230px]">
                <div id="donutChart" class="w-full"></div>
            </div>

            {{-- Legend --}}
            @php
                $total = max(1, $stats['products']);
                $published = round($total * 0.55);
                $draft     = round($total * 0.30);
                $archived  = max(0, $total - $published - $draft);
                $legend = [
                    ['label' => 'Published', 'color' => '#28A745', 'val' => $published],
                    ['label' => 'Draft',     'color' => '#FFC107', 'val' => $draft],
                    ['label' => 'Archived',  'color' => '#6C757D', 'val' => $archived],
                ];
            @endphp
            <div class="mt-4 space-y-2 border-t border-[#E9ECEF] dark:border-[#334155] pt-4">
                @foreach($legend as $item)
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full flex-shrink-0" style="background:{{ $item['color'] }}"></span>
                        <span class="text-[#6C757D] dark:text-gray-400">{{ $item['label'] }}</span>
                    </div>
                    <span class="font-mono font-semibold text-[#212529] dark:text-white">{{ $item['val'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── BOTTOM ROW: Top Products + Activity Timeline ────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Top / Recent Products Table --}}
        <div class="lg:col-span-2 bg-white dark:bg-[#1E1E1E] rounded-2xl p-6 border border-[#E9ECEF] dark:border-[#334155] shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-bold text-[#212529] dark:text-white text-base">Produk Terlaris / Terbaru</h4>
                <a href="{{ route('products.index') }}" class="text-sm text-[#fc1919] font-semibold hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[560px]">
                    <thead>
                        <tr class="bg-[#F8F9FA] dark:bg-[#121212] text-xs uppercase tracking-wide text-[#6C757D] border-b border-[#E9ECEF] dark:border-[#334155]">
                            <th class="py-3 px-4 font-semibold rounded-tl-lg">Produk</th>
                            <th class="py-3 px-4 font-semibold">Harga</th>
                            <th class="py-3 px-4 font-semibold">Status</th>
                            <th class="py-3 px-4 font-semibold text-right rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E9ECEF] dark:divide-[#334155]">
                        @forelse($recentProducts as $product)
                            <tr class="hover:bg-red-50/50 dark:hover:bg-red-900/10 transition-colors">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                            <iconify-icon icon="solar:shop-bold" class="text-xl text-[#6C757D]"></iconify-icon>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm text-[#212529] dark:text-white leading-tight">{{ Str::limit($product->name, 35) }}</p>
                                            <p class="text-xs text-[#6C757D] mt-0.5">{{ $product->category?->name ?? '–' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-sm font-mono text-[#6C757D] dark:text-gray-400">Rp {{ number_format((float)$product->price, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $bs = ['published' => 'badge-success', 'draft' => 'badge-warning', 'archived' => 'badge-danger'];
                                        $lbl = ['published' => 'Aktif', 'draft' => 'Draft', 'archived' => 'Arsip'];
                                    @endphp
                                    <span class="{{ $bs[$product->status] ?? '' }} px-3 py-1 rounded-full text-xs font-semibold inline-block">{{ $lbl[$product->status] ?? ucfirst($product->status) }}</span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('products.edit', $product) }}"
                                       class="p-1.5 bg-gray-100 dark:bg-gray-800 text-[#6C757D] hover:text-[#fc1919] rounded-lg transition-colors inline-flex" title="Edit">
                                        <iconify-icon icon="solar:pen-bold"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-8 text-center text-[#6C757D]">Belum ada produk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Activity Timeline --}}
        <div class="bg-white dark:bg-[#1E1E1E] rounded-2xl p-6 border border-[#E9ECEF] dark:border-[#334155] shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
            <h4 class="font-bold text-[#212529] dark:text-white text-base mb-5">Aktivitas Terkini</h4>
            <div class="relative border-l-2 border-[#E9ECEF] dark:border-[#334155] ml-3 space-y-5">

                @forelse($recentProducts->take(4) as $i => $product)
                    @php
                        $dotColors = ['bg-[#fc1919]', 'bg-[#28A745]', 'bg-[#FFC107]', 'bg-[#17A2B8]'];
                        $dot = $dotColors[$i % 4];
                        $msgs = ['Produk baru ditambahkan', 'Stok diperbarui', 'Harga diubah', 'Status diaktifkan'];
                    @endphp
                    <div class="relative pl-6">
                        <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full {{ $dot }} ring-4 ring-white dark:ring-[#1E1E1E]"></span>
                        <p class="text-sm font-semibold text-[#212529] dark:text-white">{{ $msgs[$i % 4] }}</p>
                        <p class="text-xs text-[#6C757D] mt-1">"{{ Str::limit($product->name, 30) }}"</p>
                        <p class="text-xs text-[#6C757D]">{{ $product->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="relative pl-6">
                        <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-[#fc1919] ring-4 ring-white dark:ring-[#1E1E1E]"></span>
                        <p class="text-sm font-semibold text-[#212529] dark:text-white">Sistem siap digunakan</p>
                        <p class="text-xs text-[#6C757D] mt-1">Mulai tambahkan produk pertama Anda</p>
                    </div>
                @endforelse

                <div class="relative pl-6">
                    <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-[#17A2B8] ring-4 ring-white dark:ring-[#1E1E1E]"></span>
                    <p class="text-sm font-semibold text-[#212529] dark:text-white">Sistem Login</p>
                    <p class="text-xs text-[#6C757D] mt-1">{{ auth()->user()->name }} masuk ke sistem</p>
                    <p class="text-xs text-[#6C757D]">Baru saja</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isDark = () => document.documentElement.classList.contains('dark');
    const axisColor = () => isDark() ? '#6C757D' : '#6C757D';
    const gridColor = () => isDark() ? '#334155' : '#E9ECEF';
    const bgColor   = () => isDark() ? '#1E1E1E' : '#FFFFFF';

    /* ── 1. TIMESERIES IRREGULAR AREA CHART ── */
    function generateIrregular(n, base, min, max) {
        let d = base, s = [];
        for (let i = 0; i < n; i++) {
            s.push({ x: d, y: Math.floor(Math.random() * (max - min + 1)) + min });
            d += (Math.floor(Math.random() * 3) + 1) * 86400000;
        }
        return s;
    }

    const base = new Date("{{ now()->year }}-01-01").getTime();
    const maxDate = new Date("{{ now()->year }}-01-20").getTime();

    const tsOpts = {
        series: [
            { name: 'Batik Karawyo', data: generateIrregular(18, base, 20, 90) },
            { name: 'Tenun Gorontalo', data: generateIrregular(15, base, 15, 70) },
            { name: 'Aksesoris', data: generateIrregular(20, base, 5, 50) },
        ],
        chart: { type: 'area', stacked: false, height: 280, zoom: { enabled: false }, toolbar: { show: false }, fontFamily: 'inherit', background: 'transparent', animations: { enabled: true, easing: 'easeinout', speed: 800 } },
        colors: ['#fc1919', '#17A2B8', '#28A745'],
        dataLabels: { enabled: false },
        markers: { size: 0 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, inverseColors: false, opacityFrom: 0.45, opacityTo: 0.05, stops: [20, 100, 100, 100] } },
        stroke: { curve: 'smooth', width: 2 },
        yaxis: { labels: { style: { colors: '#8e8da4' }, offsetX: 0, formatter: val => Math.round(val) + ' pcs' }, axisBorder: { show: false }, axisTicks: { show: false } },
        xaxis: {
            type: 'datetime', tickAmount: 8,
            min: base, max: maxDate,
            labels: { rotate: -15, rotateAlways: true, style: { colors: '#8e8da4' }, formatter: (val, ts) => moment(new Date(ts)).format("DD MMM YYYY") },
        },
        grid: { borderColor: gridColor(), strokeDashArray: 4 },
        tooltip: { shared: true, theme: isDark() ? 'dark' : 'light', x: { formatter: ts => moment(new Date(ts)).format("DD MMM YYYY") } },
        legend: { position: 'top', horizontalAlign: 'right', offsetX: -10, labels: { colors: axisColor() }, markers: { radius: 6 } },
    };

    const tsChart = new ApexCharts(document.querySelector("#timeseriesChart"), tsOpts);
    tsChart.render();

    /* ── 2. DONUT CHART ── */
    const total = {{ $stats['products'] ?: 1 }};
    const pub   = Math.max(1, Math.round(total * 0.55));
    const dft   = Math.max(1, Math.round(total * 0.30));
    const arc   = Math.max(0, total - pub - dft);

    const donutOpts = {
        series: [pub, dft, arc || 1],
        labels: ['Published', 'Draft', 'Archived'],
        colors: ['#28A745', '#FFC107', '#6C757D'],
        chart: { type: 'donut', height: 220, fontFamily: 'inherit', background: 'transparent', animations: { enabled: true, speed: 900 } },
        dataLabels: { enabled: false },
        plotOptions: { pie: { donut: { size: '68%', labels: { show: true,
            total: { show: true, label: 'Total Produk', color: axisColor(), fontSize: '12px', fontWeight: 600, formatter: () => total },
            value: { show: true, color: isDark() ? '#f1f5f9' : '#212529', fontSize: '20px', fontWeight: 700 }
        } } } },
        legend: { show: false },
        stroke: { width: 2, colors: [bgColor()] },
        tooltip: { theme: isDark() ? 'dark' : 'light' },
    };

    const donutChart = new ApexCharts(document.querySelector("#donutChart"), donutOpts);
    donutChart.render();

    /* ── Dark mode observer ── */
    new MutationObserver(() => {
        const dark = isDark(), ac = axisColor(), gc = gridColor();
        tsChart.updateOptions({ grid: { borderColor: gc }, tooltip: { theme: dark ? 'dark' : 'light' }, legend: { labels: { colors: ac } } });
        donutChart.updateOptions({ tooltip: { theme: dark ? 'dark' : 'light' }, stroke: { colors: [bgColor()] }, plotOptions: { pie: { donut: { labels: { total: { color: ac }, value: { color: dark ? '#f1f5f9' : '#212529' } } } } } });
    }).observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
});
</script>

@endsection
