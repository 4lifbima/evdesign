@extends('layouts.dashboard')

@section('title', 'Dashboard Utama')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border-l-4 border-red-600">
            <p class="text-xs uppercase text-slate-500">Total Produk</p>
            <p class="text-3xl font-semibold text-slate-900 dark:text-slate-100 font-mono">{{ $stats['products'] }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border-l-4 border-blue-500">
            <p class="text-xs uppercase text-slate-500">Kategori</p>
            <p class="text-3xl font-semibold text-slate-900 dark:text-slate-100 font-mono">{{ $stats['categories'] }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border-l-4 border-emerald-500">
            <p class="text-xs uppercase text-slate-500">Perajin</p>
            <p class="text-3xl font-semibold text-slate-900 dark:text-slate-100 font-mono">{{ $stats['artisans'] }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border-l-4 border-amber-500">
            <p class="text-xs uppercase text-slate-500">Stok Menipis</p>
            <p class="text-3xl font-semibold text-slate-900 dark:text-slate-100 font-mono">{{ $stats['low_stock_materials'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
            <h2 class="text-lg font-semibold mb-4 text-slate-900 dark:text-slate-100">Produk Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[600px]">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-800">
                            <th class="py-2">Nama</th>
                            <th class="py-2">Kategori</th>
                            <th class="py-2">Harga</th>
                            <th class="py-2">Status</th>
                            <th class="py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentProducts as $product)
                            <tr class="border-b border-slate-100 dark:border-slate-800">
                                <td class="py-3">{{ $product->name }}</td>
                                <td class="py-3">{{ $product->category?->name ?? '-' }}</td>
                                <td class="py-3 font-mono">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                                <td class="py-3">{{ ucfirst($product->status) }}</td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('products.edit', $product) }}" class="text-red-600 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="py-4 text-slate-500" colspan="5">Belum ada produk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
            <h2 class="text-lg font-semibold mb-4 text-slate-900 dark:text-slate-100">Top Kategori</h2>
            <div class="space-y-3">
                @forelse ($topCategories as $category)
                    <div class="flex justify-between text-sm">
                        <span>{{ $category->name }}</span>
                        <span class="font-mono">{{ $category->products_count }}</span>
                    </div>
                @empty
                    <p class="text-slate-500">Belum ada kategori.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
