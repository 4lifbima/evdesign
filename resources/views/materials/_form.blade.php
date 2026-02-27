<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<div><label class="block mb-1">Nama</label><input type="text" name="name" value="{{ old('name', $material->name ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800" required></div>
<div><label class="block mb-1">Slug</label><input type="text" name="slug" value="{{ old('slug', $material->slug ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
<div><label class="block mb-1">Kategori</label><input type="text" name="category" value="{{ old('category', $material->category ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
<div><label class="block mb-1">Satuan</label><input type="text" name="unit" value="{{ old('unit', $material->unit ?? 'pcs') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800" required></div>
<div><label class="block mb-1">Stok</label><input type="number" name="stock" value="{{ old('stock', $material->stock ?? 0) }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
<div><label class="block mb-1">Minimum Stok</label><input type="number" name="minimum_stock" value="{{ old('minimum_stock', $material->minimum_stock ?? 5) }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
<div><label class="block mb-1">Cost Per Unit</label><input type="number" step="0.01" name="cost_per_unit" value="{{ old('cost_per_unit', $material->cost_per_unit ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
<div><label class="block mb-1">Supplier</label><input type="text" name="supplier" value="{{ old('supplier', $material->supplier ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
<div class="md:col-span-2"><label class="block mb-1">Deskripsi</label><textarea name="description" class="w-full rounded-xl border-slate-300 dark:bg-slate-800">{{ old('description', $material->description ?? '') }}</textarea></div>
<label class="inline-flex items-center gap-2"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $material->is_active ?? true))><span>Aktif</span></label>
</div>
