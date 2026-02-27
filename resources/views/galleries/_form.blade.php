@php
    $inputCls = 'w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent transition';
    $labelCls = 'block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1';
@endphp

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="{{ $labelCls }}">Judul Karya <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $gallery->title ?? '') }}" class="{{ $inputCls }}" required placeholder="Pameran Batik 2024">
            @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="{{ $labelCls }}">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $gallery->slug ?? '') }}" class="{{ $inputCls }}" placeholder="pameran-batik-2024">
        </div>
        <div>
            <label class="{{ $labelCls }}">Kategori</label>
            <select name="category" class="{{ $inputCls }}">
                <option value="kegiatan" @selected(old('category', $gallery->category ?? 'kegiatan')==='kegiatan')>Kegiatan</option>
                <option value="produk" @selected(old('category', $gallery->category ?? '')==='produk')>Produk</option>
                <option value="proses" @selected(old('category', $gallery->category ?? '')==='proses')>Proses Membuat</option>
                <option value="lainnya" @selected(old('category', $gallery->category ?? '')==='lainnya')>Lainnya</option>
            </select>
        </div>
        <div>
            <label class="{{ $labelCls }}">Tanggal Event</label>
            <input type="date" name="event_date" value="{{ old('event_date', isset($gallery->event_date) ? $gallery->event_date->format('Y-m-d') : '') }}" class="{{ $inputCls }}">
        </div>
        <div>
            <label class="{{ $labelCls }}">Image Path <span class="text-red-500">*</span></label>
            <input type="text" name="image_path" value="{{ old('image_path', $gallery->image_path ?? '') }}" class="{{ $inputCls }}" required placeholder="gallery/foto-1.jpg">
            @error('image_path') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="{{ $labelCls }}">Thumbnail Path</label>
            <input type="text" name="thumbnail_path" value="{{ old('thumbnail_path', $gallery->thumbnail_path ?? '') }}" class="{{ $inputCls }}" placeholder="gallery/thumb-1.jpg">
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Lokasi</label>
            <input type="text" name="location" value="{{ old('location', $gallery->location ?? '') }}" class="{{ $inputCls }}" placeholder="Kota Gorontalo">
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Deskripsi</label>
            <textarea name="description" rows="3" class="{{ $inputCls }}" placeholder="Ceritakan tentang karya ini...">{{ old('description', $gallery->description ?? '') }}</textarea>
        </div>
    </div>
    <label class="inline-flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $gallery->is_featured ?? false))
               class="rounded border-slate-300 dark:border-slate-600 text-red-600">
        <span class="text-sm text-slate-700 dark:text-slate-300 select-none">Jadikan Featured</span>
    </label>
</div>
