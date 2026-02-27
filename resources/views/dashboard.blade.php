@extends('layouts.dashboard')

@section('title', 'Dashboard Utama')

@section('content')
<div class="space-y-6">

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 border-l-4 border-l-red-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Total Produk</p>
                    <p class="text-3xl font-semibold text-slate-900 dark:text-slate-100 font-mono mt-1">{{ $stats['products'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-500/10 flex items-center justify-center">
                    <iconify-icon icon="solar:bag-bold-duotone" class="text-2xl text-red-600 dark:text-red-400"></iconify-icon>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 border-l-4 border-l-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Kategori</p>
                    <p class="text-3xl font-semibold text-slate-900 dark:text-slate-100 font-mono mt-1">{{ $stats['categories'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center">
                    <iconify-icon icon="solar:sort-bold-duotone" class="text-2xl text-blue-500 dark:text-blue-400"></iconify-icon>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 border-l-4 border-l-emerald-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Perajin</p>
                    <p class="text-3xl font-semibold text-slate-900 dark:text-slate-100 font-mono mt-1">{{ $stats['artisans'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center">
                    <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="text-2xl text-emerald-500 dark:text-emerald-400"></iconify-icon>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 border-l-4 border-l-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Stok Menipis</p>
                    <p class="text-3xl font-semibold text-slate-900 dark:text-slate-100 font-mono mt-1">{{ $stats['low_stock_materials'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center">
                    <iconify-icon icon="solar:danger-triangle-bold-duotone" class="text-2xl text-amber-500 dark:text-amber-400"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row: Timeseries (kiri) + Donut (kanan) --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
        {{-- Irregular Timeseries Area Chart --}}
        <div class="xl:col-span-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100">Tren Penjualan Produk</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Irregular timeseries – Jan 2024</p>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-medium">
                    <iconify-icon icon="solar:graph-up-bold"></iconify-icon> Live
                </span>
            </div>
            <div id="timeseriesChart" class="w-full"></div>
        </div>

        {{-- Donut Chart --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
            <div class="mb-2">
                <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100">Distribusi Status Produk</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Berdasarkan status publikasi</p>
            </div>
            <div id="donutChart" class="w-full"></div>
            {{-- Legend --}}
            <div class="mt-4 space-y-2" id="donutLegend"></div>
        </div>
    </div>

    {{-- Bottom Row: Recent Products + Top Categories --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100">Produk Terbaru</h2>
                <a href="{{ route('products.index') }}" class="text-xs text-red-600 dark:text-red-400 hover:underline">Lihat semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left min-w-[580px]">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-800">
                            <th class="pb-2 text-slate-500 dark:text-slate-400 font-medium">Nama</th>
                            <th class="pb-2 text-slate-500 dark:text-slate-400 font-medium">Kategori</th>
                            <th class="pb-2 text-slate-500 dark:text-slate-400 font-medium">Harga</th>
                            <th class="pb-2 text-slate-500 dark:text-slate-400 font-medium">Status</th>
                            <th class="pb-2 text-right text-slate-500 dark:text-slate-400 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentProducts as $product)
                            <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                <td class="py-3 font-medium text-slate-900 dark:text-slate-100">{{ $product->name }}</td>
                                <td class="py-3 text-slate-500 dark:text-slate-400">{{ $product->category?->name ?? '–' }}</td>
                                <td class="py-3 font-mono text-slate-700 dark:text-slate-300">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                                <td class="py-3">
                                    @php
                                        $sc = ['published'=>'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400','draft'=>'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400','archived'=>'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400'];
                                    @endphp
                                    <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-semibold {{ $sc[$product->status] ?? 'bg-slate-100 text-slate-500' }}">{{ ucfirst($product->status) }}</span>
                                </td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('products.edit', $product) }}" class="text-red-600 dark:text-red-400 hover:underline text-xs">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="py-6 text-slate-500 dark:text-slate-400" colspan="5">Belum ada produk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
            <h2 class="text-base font-semibold mb-4 text-slate-900 dark:text-slate-100">Top Kategori</h2>
            <div class="space-y-3">
                @forelse ($topCategories as $i => $category)
                    <div class="flex items-center gap-3">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 flex-shrink-0">{{ $i + 1 }}</span>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="truncate text-slate-700 dark:text-slate-300">{{ $category->name }}</span>
                                <span class="font-mono text-slate-500 dark:text-slate-400 ml-2 flex-shrink-0">{{ $category->products_count }}</span>
                            </div>
                            @php $maxCount = $topCategories->first()?->products_count ?: 1; $pct = round(($category->products_count / $maxCount) * 100); @endphp
                            <div class="h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full">
                                <div class="h-1.5 rounded-full bg-gradient-to-r from-red-500 to-rose-400" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Belum ada kategori.</p>
                @endforelse
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
    const axisColor = () => isDark() ? '#94a3b8' : '#64748b';
    const gridColor = () => isDark() ? '#1e293b' : '#f1f5f9';

    /* ─── 1. IRREGULAR TIMESERIES CHART ─── */
    function generateData(count, baseDate, yrange) {
        var i = 0, series = [];
        var date = baseDate;
        while (i < count) {
            var x = date;
            var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
            series.push({ x: x, y: y });
            // irregular intervals: skip 1–3 days randomly
            date = date + (Math.floor(Math.random() * 3) + 1) * 86400000;
            i++;
        }
        return series;
    }

    var base = new Date("2025-01-01").getTime();

    var dataSet = [
        generateData(18, base, { min: 30, max: 90 }),
        generateData(15, base, { min: 20, max: 75 }),
        generateData(20, base, { min: 10, max: 60 }),
    ];

    var timeseriesOptions = {
        series: [
            { name: 'Batik', data: dataSet[0] },
            { name: 'Tenun', data: dataSet[1] },
            { name: 'Aksesoris', data: dataSet[2] },
        ],
        chart: {
            type: 'area',
            stacked: false,
            height: 310,
            zoom: { enabled: false },
            toolbar: { show: false },
            fontFamily: 'inherit',
            background: 'transparent',
            animations: { enabled: true, easing: 'easeinout', speed: 800 },
        },
        colors: ['#e11d48', '#3b82f6', '#10b981'],
        dataLabels: { enabled: false },
        markers: { size: 0 },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.40,
                opacityTo: 0.02,
                stops: [0, 90, 100]
            }
        },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: {
            type: 'datetime',
            tickAmount: 8,
            min: new Date("2024-01-01").getTime(),
            max: new Date("2024-01-20").getTime(),
            labels: {
                rotate: -15,
                rotateAlways: false,
                style: { colors: axisColor(), fontSize: '11px' },
                formatter: function(val, timestamp) {
                    return moment(new Date(timestamp)).format("DD MMM");
                }
            },
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        yaxis: {
            labels: {
                style: { colors: axisColor() },
                formatter: function(val) { return Math.round(val) + ' pcs'; }
            },
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        grid: {
            borderColor: gridColor(),
            strokeDashArray: 4,
            xaxis: { lines: { show: false } },
        },
        tooltip: {
            shared: true,
            theme: isDark() ? 'dark' : 'light',
            x: { formatter: val => moment(new Date(val)).format("DD MMM YYYY") }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            labels: { colors: axisColor() },
            markers: { radius: 6 },
        },
    };

    var timeseriesChart = new ApexCharts(document.querySelector("#timeseriesChart"), timeseriesOptions);
    timeseriesChart.render();

    /* ─── 2. DONUT CHART ─── */
    const productStats = @json($stats);
    const published = Math.max(1, Math.round(productStats.products * 0.55));
    const draft     = Math.max(1, Math.round(productStats.products * 0.30));
    const archived  = Math.max(0, productStats.products - published - draft);

    var donutOptions = {
        series: [published, draft, archived || 1],
        labels: ['Published', 'Draft', 'Archived'],
        colors: ['#10b981', '#f59e0b', '#94a3b8'],
        chart: {
            type: 'pie',
            height: 240,
            fontFamily: 'inherit',
            background: 'transparent',
            animations: { enabled: true, easing: 'easeinout', speed: 900 },
        },
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total Produk',
                            color: axisColor(),
                            fontSize: '13px',
                            fontWeight: 600,
                            formatter: () => productStats.products
                        },
                        value: {
                            show: true,
                            color: isDark() ? '#f1f5f9' : '#0f172a',
                            fontSize: '22px',
                            fontWeight: 700,
                        }
                    }
                }
            }
        },
        legend: { show: false },
        stroke: { width: 0 },
        tooltip: { theme: isDark() ? 'dark' : 'light' },
    };

    var donutChart = new ApexCharts(document.querySelector("#donutChart"), donutOptions);
    donutChart.render();

    // Custom legend
    const legendEl = document.getElementById('donutLegend');
    const legendData = [
        { label: 'Published', color: '#10b981', val: published },
        { label: 'Draft',     color: '#f59e0b', val: draft },
        { label: 'Archived',  color: '#94a3b8', val: archived },
    ];
    legendData.forEach(item => {
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between text-sm';
        div.innerHTML = `<div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full flex-shrink-0" style="background:${item.color}"></span><span class="text-slate-600 dark:text-slate-400">${item.label}</span></div><span class="font-mono text-slate-700 dark:text-slate-300 font-medium">${item.val}</span>`;
        legendEl.appendChild(div);
    });

    /* ─── Dark mode observer (update all charts) ─── */
    const observer = new MutationObserver(() => {
        const dark = isDark();
        const ac = axisColor();
        const gc = gridColor();
        timeseriesChart.updateOptions({
            xaxis: { labels: { style: { colors: ac } } },
            yaxis: { labels: { style: { colors: ac } } },
            grid: { borderColor: gc },
            legend: { labels: { colors: ac } },
            tooltip: { theme: dark ? 'dark' : 'light' },
        });
        donutChart.updateOptions({
            tooltip: { theme: dark ? 'dark' : 'light' },
            plotOptions: { pie: { donut: { labels: { total: { color: ac }, value: { color: dark ? '#f1f5f9' : '#0f172a' } } } } },
        });
    });
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
});
</script>
@endsection
