@php
    $inputCls = 'w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent transition';
    $labelCls = 'block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1';
@endphp

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="{{ $labelCls }}">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="{{ $inputCls }}" required placeholder="Batik, Tenun, ...">
            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="{{ $labelCls }}">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" class="{{ $inputCls }}" placeholder="batik">
        </div>
        <div>
            <label class="{{ $labelCls }}">Parent Kategori</label>
            <select name="parent_id" class="{{ $inputCls }}">
                <option value="">– Tidak ada parent –</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}" @selected((string)old('parent_id', $category->parent_id ?? '')===(string)$parent->id)>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="{{ $labelCls }}">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="{{ $inputCls }}" min="0">
        </div>
        <div>
            <label class="{{ $labelCls }}">Icon (Iconify)</label>
            <input type="text" name="icon" value="{{ old('icon', $category->icon ?? '') }}" class="{{ $inputCls }}" placeholder="solar:tag-bold">
        </div>
        <div>
            <label class="{{ $labelCls }}">Image Path</label>
            <input type="text" name="image" value="{{ old('image', $category->image ?? '') }}" class="{{ $inputCls }}" placeholder="categories/batik.jpg">
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Deskripsi</label>
            <textarea name="description" rows="3" class="{{ $inputCls }}">{{ old('description', $category->description ?? '') }}</textarea>
        </div>
    </div>
    <label class="inline-flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))
               class="rounded border-slate-300 dark:border-slate-600 text-red-600">
        <span class="text-sm text-slate-700 dark:text-slate-300 select-none">Aktif</span>
    </label>
</div>

<script>
document.querySelector('[name="name"]')?.addEventListener('input', function() {
    const slugInput = document.querySelector('[name="slug"]');
    if (slugInput && !slugInput.value) {
        slugInput.value = this.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').trim();
    }
});
</script>
