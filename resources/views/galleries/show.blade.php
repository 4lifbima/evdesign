@extends('layouts.dashboard')
@section('title', 'Detail Galeri')
@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 space-y-2"><p><strong>Judul:</strong> {{ $gallery->title }}</p><p><strong>Kategori:</strong> {{ $gallery->category }}</p><p><strong>Lokasi:</strong> {{ $gallery->location ?? '-' }}</p><p><strong>Image:</strong> {{ $gallery->image_path }}</p><p><strong>Deskripsi:</strong> {{ $gallery->description ?? '-' }}</p></div>
@endsection
