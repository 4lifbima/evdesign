@extends('layouts.dashboard')
@section('title', 'Detail Tag')
@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 space-y-2"><p><strong>Nama:</strong> {{ $tag->name }}</p><p><strong>Slug:</strong> {{ $tag->slug }}</p><p><strong>Total Produk:</strong> {{ $tag->products->count() }}</p></div>
@endsection
