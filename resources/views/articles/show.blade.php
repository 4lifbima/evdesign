@extends('layouts.dashboard')
@section('title', 'Detail Artikel')
@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 space-y-3"><p><strong>Judul:</strong> {{ $article->title }}</p><p><strong>Kategori:</strong> {{ $article->category }}</p><p><strong>Status:</strong> {{ $article->status }}</p><p><strong>Author:</strong> {{ $article->author?->name ?? '-' }}</p><p><strong>Tags:</strong> {{ implode(', ', $article->tags ?? []) ?: '-' }}</p><div class="prose max-w-none dark:prose-invert"><p>{{ $article->content }}</p></div></div>
@endsection
