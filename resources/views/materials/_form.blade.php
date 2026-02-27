@php
    $inputCls = 'w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent transition';
    $labelCls = 'block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1';
@endphp

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="{{ $labelCls }}">Nama Bahan <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $material->name ?? '') }}" class="{{ $inputCls }}" required placeholder="Kain Batik Tulis">
            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="{{ $labelCls }}">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $material->slug ?? '') }}" class="{{ $inputCls }}" placeholder="kain-batik-tulis">
        </div>
        <div>
            <label class="{{ $labelCls }}">Kategori Bahan</label>
            <input type="text" name="category" value="{{ old('category', $material->category ?? '') }}" class="{{ $inputCls }}" placeholder="Kain, Benang, Pewarna, ...">
        </div>
        <div>
            <label class="{{ $labelCls }}">Satuan <span class="text-red-500">*</span></label>
            <input type="text" name="unit" value="{{ old('unit', $material->unit ?? 'pcs') }}" class="{{ $inputCls }}" placeholder="meter, kg, pcs" required>
        </div>
        <div>
            <label class="{{ $labelCls }}">Stok Saat Ini</label>
            <input type="number" name="stock" value="{{ old('stock', $material->stock ?? 0) }}" class="{{ $inputCls }}" min="0">
        </div>
        <div>
            <label class="{{ $labelCls }}">Minimum Stok (alert)</label>
            <input type="number" name="minimum_stock" value="{{ old('minimum_stock', $material->minimum_stock ?? 5) }}" class="{{ $inputCls }}" min="0">
        </div>
        <div>
            <label class="{{ $labelCls }}">Biaya per Unit (Rp)</label>
            <input type="number" step="0.01" name="cost_per_unit" value="{{ old('cost_per_unit', $material->cost_per_unit ?? '') }}" class="{{ $inputCls }}" placeholder="0">
        </div>
        <div>
            <label class="{{ $labelCls }}">Supplier</label>
            <input type="text" name="supplier" value="{{ old('supplier', $material->supplier ?? '') }}" class="{{ $inputCls }}" placeholder="Nama toko / supplier">
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Deskripsi</label>
            <textarea name="description" rows="3" class="{{ $inputCls }}" placeholder="Keterangan tambahan tentang bahan...">{{ old('description', $material->description ?? '') }}</textarea>
        </div>
    </div>
    <label class="inline-flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $material->is_active ?? true))
               class="rounded border-slate-300 dark:border-slate-600 text-red-600">
        <span class="text-sm text-slate-700 dark:text-slate-300 select-none">Aktif</span>
    </label>
</div>
