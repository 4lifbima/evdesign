@extends('layouts.dashboard')
@section('title', 'Artikel & Berita')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Artikel & Berita</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Kelola konten artikel dan berita EVDesign</p>
    </div>
    <a href="{{ route('articles.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition duration-150 shadow-sm">
        <iconify-icon icon="solar:add-circle-bold" class="text-lg"></iconify-icon>
        Tulis Artikel
    </a>
</div>

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 mb-4">
    <form class="flex flex-col sm:flex-row gap-3" method="GET">
        <div class="relative flex-1">
            <iconify-icon icon="solar:magnifer-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></iconify-icon>
            <input type="text" name="q" placeholder="Cari artikel..." value="{{ request('q') }}"
                   class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
        </div>
        <select name="status" class="rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
            <option value="">Semua Status</option>
            <option value="draft" @selected(request('status')==='draft')>Draft</option>
            <option value="published" @selected(request('status')==='published')>Published</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 dark:hover:bg-slate-600 text-white text-sm font-medium rounded-xl transition">Filter</button>
        @if(request('q') || request('status'))
            <a href="{{ route('articles.index') }}" class="px-4 py-2 text-slate-500 dark:text-slate-400 hover:text-red-600 text-sm rounded-xl border border-slate-200 dark:border-slate-700 transition text-center">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Judul</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Kategori</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Status</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                    <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($article->cover_image)
                                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt=""
                                         class="w-12 h-9 rounded-lg object-cover flex-shrink-0 bg-slate-100 dark:bg-slate-800">
                                @else
                                    <div class="w-12 h-9 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center flex-shrink-0">
                                        <iconify-icon icon="solar:notes-bold-duotone" class="text-xl text-slate-400"></iconify-icon>
                                    </div>
                                @endif
                                <p class="font-medium text-slate-900 dark:text-slate-100">{{ Str::limit($article->title, 50) }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400">{{ $article->category ?? '–' }}</td>
                        <td class="px-4 py-3">
                            @php
                                $statusClasses = [
                                    'published' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400',
                                    'draft'     => 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400',
                                ];
                                $cls = $statusClasses[$article->status] ?? 'bg-slate-100 text-slate-500';
                            @endphp
                            <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-semibold {{ $cls }}">
                                {{ ucfirst($article->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-500 dark:text-slate-400 text-xs">
                            {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('articles.show', $article) }}" class="p-1.5 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition" title="Detail">
                                    <iconify-icon icon="solar:eye-bold" class="text-base"></iconify-icon>
                                </a>
                                <a href="{{ route('articles.edit', $article) }}" class="p-1.5 rounded-lg text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 transition" title="Edit">
                                    <iconify-icon icon="solar:pen-bold" class="text-base"></iconify-icon>
                                </a>
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this.closest('form'))" class="p-1.5 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition" title="Hapus">
                                        <iconify-icon icon="solar:trash-bin-trash-bold" class="text-base"></iconify-icon>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-slate-400 dark:text-slate-600">
                                <iconify-icon icon="solar:notes-bold-duotone" class="text-4xl"></iconify-icon>
                                <p class="text-sm">Belum ada artikel. <a href="{{ route('articles.create') }}" class="text-red-600 dark:text-red-400 hover:underline">Tulis sekarang</a></p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($articles->hasPages())
    <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-800">{{ $articles->withQueryString()->links() }}</div>
    @endif
</div>

<script>
function confirmDelete(form) {
    if (confirm('Yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.')) {
        form.submit();
    }
}
</script>
@endsection
