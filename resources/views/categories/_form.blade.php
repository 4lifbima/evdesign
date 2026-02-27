<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block mb-1">Nama</label>
        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800" required>
    </div>
    <div>
        <label class="block mb-1">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800">
    </div>
    <div class="md:col-span-2">
        <label class="block mb-1">Deskripsi</label>
        <textarea name="description" class="w-full rounded-xl border-slate-300 dark:bg-slate-800">{{ old('description', $category->description ?? '') }}</textarea>
    </div>
    <div>
        <label class="block mb-1">Parent Kategori</label>
        <select name="parent_id" class="w-full rounded-xl border-slate-300 dark:bg-slate-800">
            <option value="">-</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}" @selected((string) old('parent_id', $category->parent_id ?? '') === (string) $parent->id)>{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block mb-1">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800">
    </div>
    <div>
        <label class="block mb-1">Icon</label>
        <input type="text" name="icon" value="{{ old('icon', $category->icon ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800">
    </div>
    <div>
        <label class="block mb-1">Image Path</label>
        <input type="text" name="image" value="{{ old('image', $category->image ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800">
    </div>
    <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))>
        <span>Aktif</span>
    </label>
</div>
