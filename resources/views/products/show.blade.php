@extends('layouts.dashboard')
@section('title', 'Detail Produk')
@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 space-y-4">
    <p><strong>Nama:</strong> {{ $product->name }}</p>
    <p><strong>Kategori:</strong> {{ $product->category?->name ?? '-' }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format((float)$product->price,0,',','.') }}</p>
    <p><strong>Stok:</strong> {{ $product->stock }}</p>
    <p><strong>Status:</strong> {{ ucfirst($product->status) }}</p>
    <p><strong>Tag:</strong> {{ $product->tags->pluck('name')->implode(', ') ?: '-' }}</p>
    <p><strong>Perajin:</strong> {{ $product->artisans->pluck('name')->implode(', ') ?: '-' }}</p>
    <p><strong>Material:</strong> {{ $product->materialsRelation->pluck('name')->implode(', ') ?: '-' }}</p>
    <a href="{{ route('products.edit',$product) }}" class="inline-block px-4 py-2 bg-amber-500 text-white rounded-xl">Edit</a>
</div>
@endsection
