@php
    $selectedTags = old('tag_ids', isset($product) ? $product->tags->pluck('id')->all() : []);
    $selectedArtisans = old('artisan_ids', isset($product) ? $product->artisans->pluck('id')->all() : []);
    $selectedMaterials = old('material_ids', isset($product) ? $product->materialsRelation->pluck('id')->all() : []);
    $imagePaths = old('image_paths', isset($product) ? $product->images->pluck('image_path')->all() : ['']);
    $variantNames = old('variant_names', isset($product) ? $product->variants->pluck('name')->all() : ['']);
    $variantColors = old('variant_colors', isset($product) ? $product->variants->pluck('color')->all() : ['']);
    $variantSizes = old('variant_sizes', isset($product) ? $product->variants->pluck('size')->all() : ['']);
    $variantPrices = old('variant_prices', isset($product) ? $product->variants->pluck('price')->all() : ['']);
    $variantStocks = old('variant_stocks', isset($product) ? $product->variants->pluck('stock')->all() : ['']);

    $inputCls = 'w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent transition';
    $labelCls = 'block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1';
@endphp

{{-- Basic Info --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
    <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-4">Informasi Dasar</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="{{ $labelCls }}">Nama Produk <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="{{ $inputCls }}" required placeholder="Batik Mega Mendung...">
            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="{{ $labelCls }}">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $product->slug ?? '') }}" class="{{ $inputCls }}" placeholder="batik-mega-mendung">
        </div>
        <div>
            <label class="{{ $labelCls }}">Harga (Rp) <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="{{ $inputCls }}" required placeholder="150000">
            @error('price') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="{{ $labelCls }}">Harga Diskon (Rp)</label>
            <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $product->discount_price ?? '') }}" class="{{ $inputCls }}" placeholder="120000">
        </div>
        <div>
            <label class="{{ $labelCls }}">Stok</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" class="{{ $inputCls }}">
        </div>
        <div>
            <label class="{{ $labelCls }}">SKU</label>
            <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="{{ $inputCls }}" placeholder="EVD-001">
        </div>
        <div>
            <label class="{{ $labelCls }}">Kategori</label>
            <select name="category_id" class="{{ $inputCls }}">
                <option value="">– Pilih Kategori –</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((string)old('category_id', $product->category_id ?? '')===(string)$category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="{{ $labelCls }}">Status <span class="text-red-500">*</span></label>
            <select name="status" class="{{ $inputCls }}">
                <option value="draft" @selected(old('status', $product->status ?? 'draft')==='draft')>Draft</option>
                <option value="published" @selected(old('status', $product->status ?? '')==='published')>Published</option>
                <option value="archived" @selected(old('status', $product->status ?? '')==='archived')>Archived</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Deskripsi</label>
            <textarea name="description" rows="4" class="{{ $inputCls }}">{{ old('description', $product->description ?? '') }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Deskripsi Pendek</label>
            <textarea name="short_description" rows="2" class="{{ $inputCls }}">{{ old('short_description', $product->short_description ?? '') }}</textarea>
        </div>
    </div>
</div>

{{-- Attributes --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
    <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-4">Atribut Produk</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="{{ $labelCls }}">Warna (pisah koma)</label>
            <input type="text" name="colors" value="{{ old('colors', isset($product) ? implode(', ', $product->colors ?? []) : '') }}" class="{{ $inputCls }}" placeholder="Merah, Biru, Hitam">
        </div>
        <div>
            <label class="{{ $labelCls }}">Ukuran (pisah koma)</label>
            <input type="text" name="sizes" value="{{ old('sizes', isset($product) ? implode(', ', $product->sizes ?? []) : '') }}" class="{{ $inputCls }}" placeholder="S, M, L, XL">
        </div>
        <div>
            <label class="{{ $labelCls }}">Bahan (pisah koma)</label>
            <input type="text" name="materials" value="{{ old('materials', isset($product) ? implode(', ', $product->materials ?? []) : '') }}" class="{{ $inputCls }}" placeholder="Katun, Batik">
        </div>
        <div>
            <label class="{{ $labelCls }}">Dimensi (pisah koma)</label>
            <input type="text" name="dimensions" value="{{ old('dimensions', isset($product) ? implode(', ', $product->dimensions ?? []) : '') }}" class="{{ $inputCls }}" placeholder="30cm x 40cm">
        </div>
    </div>
    <div class="flex flex-wrap gap-5 mt-4">
        <label class="inline-flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false)) class="rounded border-slate-300 dark:border-slate-600 text-red-600">
            <span class="text-sm text-slate-700 dark:text-slate-300 select-none">Featured</span>
        </label>
        <label class="inline-flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_best_seller" value="1" @checked(old('is_best_seller', $product->is_best_seller ?? false)) class="rounded border-slate-300 dark:border-slate-600 text-red-600">
            <span class="text-sm text-slate-700 dark:text-slate-300 select-none">Best Seller</span>
        </label>
        <label class="inline-flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_new" value="1" @checked(old('is_new', $product->is_new ?? false)) class="rounded border-slate-300 dark:border-slate-600 text-red-600">
            <span class="text-sm text-slate-700 dark:text-slate-300 select-none">Produk Baru</span>
        </label>
    </div>
</div>

{{-- Relations --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
    <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-4">Relasi</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="{{ $labelCls }}">Tag (Ctrl+klik multi)</label>
            <select name="tag_ids[]" multiple class="{{ $inputCls }} h-32">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(in_array($tag->id, $selectedTags))>{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="{{ $labelCls }}">Perajin (Ctrl+klik multi)</label>
            <select name="artisan_ids[]" multiple class="{{ $inputCls }} h-32">
                @foreach($artisans as $artisan)
                    <option value="{{ $artisan->id }}" @selected(in_array($artisan->id, $selectedArtisans))>{{ $artisan->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="{{ $labelCls }}">Material Produksi (Ctrl+klik multi)</label>
            <select name="material_ids[]" multiple class="{{ $inputCls }} h-32">
                @foreach($materials as $material)
                    <option value="{{ $material->id }}" @selected(in_array($material->id, $selectedMaterials))>{{ $material->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{-- Images --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
    <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-4">Gambar Produk</h3>
    <div class="space-y-2" id="imageContainer">
        @foreach(($imagePaths ?: ['']) as $path)
            <div class="flex gap-2">
                <input type="text" name="image_paths[]" value="{{ $path }}" class="{{ $inputCls }}" placeholder="images/produk-1.jpg">
                <button type="button" onclick="this.parentElement.remove()" class="px-2 py-1 text-red-500 hover:text-red-700 text-xs rounded-lg border border-red-200 dark:border-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 transition">✕</button>
            </div>
        @endforeach
    </div>
    <button type="button" onclick="addImageRow()" class="mt-2 inline-flex items-center gap-1 text-sm text-red-600 dark:text-red-400 hover:underline">
        <iconify-icon icon="solar:add-circle-linear"></iconify-icon> Tambah gambar
    </button>
</div>

{{-- Variants --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6">
    <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide mb-4">Varian Produk</h3>
    <div class="space-y-2" id="variantContainer">
        @for($i = 0; $i < max(1, count($variantNames)); $i++)
            <div class="grid grid-cols-2 md:grid-cols-5 gap-2 variant-row">
                <input type="text" name="variant_names[]" value="{{ $variantNames[$i] ?? '' }}" class="{{ $inputCls }}" placeholder="Nama varian">
                <input type="text" name="variant_colors[]" value="{{ $variantColors[$i] ?? '' }}" class="{{ $inputCls }}" placeholder="Warna">
                <input type="text" name="variant_sizes[]" value="{{ $variantSizes[$i] ?? '' }}" class="{{ $inputCls }}" placeholder="Ukuran">
                <input type="number" step="0.01" name="variant_prices[]" value="{{ $variantPrices[$i] ?? '' }}" class="{{ $inputCls }}" placeholder="Harga">
                <div class="flex gap-1">
                    <input type="number" name="variant_stocks[]" value="{{ $variantStocks[$i] ?? '' }}" class="{{ $inputCls }}" placeholder="Stok">
                    <button type="button" onclick="this.closest('.variant-row').remove()" class="px-2 text-red-500 hover:text-red-700 text-xs rounded-lg border border-red-200 dark:border-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 transition">✕</button>
                </div>
            </div>
        @endfor
    </div>
    <button type="button" onclick="addVariantRow()" class="mt-2 inline-flex items-center gap-1 text-sm text-red-600 dark:text-red-400 hover:underline">
        <iconify-icon icon="solar:add-circle-linear"></iconify-icon> Tambah varian
    </button>
</div>

<script>
const inputCls = 'w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent transition';

function addImageRow() {
    const c = document.getElementById('imageContainer');
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = `<input type="text" name="image_paths[]" class="${inputCls}" placeholder="images/produk-X.jpg">
        <button type="button" onclick="this.parentElement.remove()" class="px-2 py-1 text-red-500 hover:text-red-700 text-xs rounded-lg border border-red-200 dark:border-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 transition">✕</button>`;
    c.appendChild(div);
}

function addVariantRow() {
    const c = document.getElementById('variantContainer');
    const div = document.createElement('div');
    div.className = 'grid grid-cols-2 md:grid-cols-5 gap-2 variant-row';
    div.innerHTML = `
        <input type="text" name="variant_names[]" class="${inputCls}" placeholder="Nama varian">
        <input type="text" name="variant_colors[]" class="${inputCls}" placeholder="Warna">
        <input type="text" name="variant_sizes[]" class="${inputCls}" placeholder="Ukuran">
        <input type="number" step="0.01" name="variant_prices[]" class="${inputCls}" placeholder="Harga">
        <div class="flex gap-1">
            <input type="number" name="variant_stocks[]" class="${inputCls}" placeholder="Stok">
            <button type="button" onclick="this.closest('.variant-row').remove()" class="px-2 text-red-500 hover:text-red-700 text-xs rounded-lg border border-red-200 dark:border-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 transition">✕</button>
        </div>`;
    c.appendChild(div);
}

// Auto-generate slug from name
document.querySelector('[name="name"]')?.addEventListener('input', function() {
    const slugInput = document.querySelector('[name="slug"]');
    if (slugInput && !slugInput.value) {
        slugInput.value = this.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').trim();
    }
});
</script>
