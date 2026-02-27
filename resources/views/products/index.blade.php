@extends('layouts.dashboard')
@section('title', 'Manajemen Produk')
@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
    <div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between mb-4">
        <form class="flex gap-2" method="GET">
            <input type="text" name="q" placeholder="Cari produk" value="{{ request('q') }}" class="rounded-xl border-slate-300 dark:bg-slate-800">
            <select name="status" class="rounded-xl border-slate-300 dark:bg-slate-800"><option value="">Semua</option><option value="draft" @selected(request('status')==='draft')>Draft</option><option value="published" @selected(request('status')==='published')>Published</option><option value="archived" @selected(request('status')==='archived')>Archived</option></select>
            <button class="px-3 py-2 bg-slate-800 text-white rounded-xl">Filter</button>
        </form>
        <a href="{{ route('products.create') }}" class="px-4 py-2 bg-red-600 text-white rounded-xl">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left min-w-[700px]">
            <thead><tr class="border-b border-slate-200 dark:border-slate-800"><th class="py-2">Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
            <tbody>@forelse($products as $product)
                <tr class="border-b border-slate-100 dark:border-slate-800"><td class="py-2">{{ $product->name }}</td><td>{{ $product->category?->name ?? '-' }}</td><td class="font-mono">Rp {{ number_format((float)$product->price,0,',','.') }}</td><td>{{ $product->stock }}</td><td>{{ ucfirst($product->status) }}</td><td class="text-right space-x-2"><a href="{{ route('products.show',$product) }}" class="text-blue-600">Detail</a><a href="{{ route('products.edit',$product) }}" class="text-amber-600">Edit</a><form action="{{ route('products.destroy',$product) }}" method="POST" class="inline">@csrf @method('DELETE')<button onclick="return confirm('Hapus data?')" class="text-red-600">Hapus</button></form></td></tr>
            @empty <tr><td colspan="6" class="py-3 text-slate-500">Tidak ada data.</td></tr> @endforelse</tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection
