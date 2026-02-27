@extends('layouts.dashboard')
@section('title', 'Tambah Produk')
@section('content')
<form action="{{ route('products.store') }}" method="POST" class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 space-y-4">@csrf
@include('products._form')
<div class="flex gap-2"><button class="px-4 py-2 bg-red-600 text-white rounded-xl">Simpan</button><a href="{{ route('products.index') }}" class="px-4 py-2 border rounded-xl">Batal</a></div>
</form>
@endsection
