@extends('layouts.dashboard')
@section('title', 'Detail Perajin')
@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 space-y-2"><p><strong>Nama:</strong> {{ $artisan->name }}</p><p><strong>Email:</strong> {{ $artisan->email ?? '-' }}</p><p><strong>Phone:</strong> {{ $artisan->phone ?? '-' }}</p><p><strong>Status:</strong> {{ $artisan->status }}</p><p><strong>Produk:</strong> {{ $artisan->products->count() }}</p><a href="{{ route('artisans.edit',$artisan) }}" class="inline-block px-4 py-2 bg-amber-500 text-white rounded-xl">Edit</a></div>
@endsection
