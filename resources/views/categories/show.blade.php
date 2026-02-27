@extends('layouts.dashboard')
@section('title', 'Detail Kategori')
@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 space-y-3">
    <p><strong>Nama:</strong> {{ $category->name }}</p>
    <p><strong>Slug:</strong> {{ $category->slug }}</p>
    <p><strong>Parent:</strong> {{ $category->parent?->name ?? '-' }}</p>
    <p><strong>Deskripsi:</strong> {{ $category->description ?? '-' }}</p>
    <p><strong>Produk:</strong> {{ $category->products->count() }}</p>
    <a href="{{ route('categories.edit',$category) }}" class="inline-block px-4 py-2 bg-amber-500 text-white rounded-xl">Edit</a>
</div>
@endsection
