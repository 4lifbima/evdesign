@php
    $inputCls = 'w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent transition';
    $labelCls = 'block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1';
@endphp

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Judul Artikel <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $article->title ?? '') }}" class="{{ $inputCls }}" required placeholder="Batik Gorontalo: Warisan Budaya yang Hidup">
            @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="{{ $labelCls }}">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $article->slug ?? '') }}" class="{{ $inputCls }}" placeholder="batik-gorontalo-warisan-budaya">
        </div>
        <div>
            <label class="{{ $labelCls }}">Kategori</label>
            <select name="category" class="{{ $inputCls }}">
                <option value="berita" @selected(old('category', $article->category ?? 'berita')==='berita')>Berita</option>
                <option value="edukasi" @selected(old('category', $article->category ?? '')==='edukasi')>Edukasi</option>
                <option value="inspirasi" @selected(old('category', $article->category ?? '')==='inspirasi')>Inspirasi</option>
                <option value="press" @selected(old('category', $article->category ?? '')==='press')>Press Release</option>
            </select>
        </div>
        <div>
            <label class="{{ $labelCls }}">Status</label>
            <select name="status" class="{{ $inputCls }}">
                <option value="draft" @selected(old('status', $article->status ?? 'draft')==='draft')>Draft</option>
                <option value="published" @selected(old('status', $article->status ?? '')==='published')>Published</option>
                <option value="archived" @selected(old('status', $article->status ?? '')==='archived')>Archived</option>
            </select>
        </div>
        <div>
            <label class="{{ $labelCls }}">Tanggal Publish</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at', isset($article->published_at) ? $article->published_at->format('Y-m-d\TH:i') : '') }}" class="{{ $inputCls }}">
        </div>
        <div>
            <label class="{{ $labelCls }}">Featured Image Path</label>
            <input type="text" name="featured_image" value="{{ old('featured_image', $article->featured_image ?? '') }}" class="{{ $inputCls }}" placeholder="articles/cover.jpg">
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Excerpt (ringkasan)</label>
            <textarea name="excerpt" rows="2" class="{{ $inputCls }}" placeholder="Ringkasan singkat artikel...">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Tags (pisah koma)</label>
            <input type="text" name="tags" value="{{ old('tags', isset($article) ? implode(', ', $article->tags ?? []) : '') }}" class="{{ $inputCls }}" placeholder="batik, tenun, budaya">
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Konten <span class="text-red-500">*</span></label>
            <textarea name="content" rows="10" class="{{ $inputCls }}" required placeholder="Tulis konten artikel di sini...">{{ old('content', $article->content ?? '') }}</textarea>
            @error('content') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
</div>

<script>
document.querySelector('[name="title"]')?.addEventListener('input', function() {
    const slugInput = document.querySelector('[name="slug"]');
    if (slugInput && !slugInput.value) {
        slugInput.value = this.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').trim();
    }
});
</script>
