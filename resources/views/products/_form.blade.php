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
@endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><label class="block mb-1">Nama</label><input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800" required></div>
    <div><label class="block mb-1">Slug</label><input type="text" name="slug" value="{{ old('slug', $product->slug ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
    <div><label class="block mb-1">Harga</label><input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800" required></div>
    <div><label class="block mb-1">Harga Diskon</label><input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $product->discount_price ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
    <div><label class="block mb-1">Stok</label><input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
    <div><label class="block mb-1">Status</label><select name="status" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"><option value="draft" @selected(old('status', $product->status ?? 'draft')==='draft')>Draft</option><option value="published" @selected(old('status', $product->status ?? '')==='published')>Published</option><option value="archived" @selected(old('status', $product->status ?? '')==='archived')>Archived</option></select></div>
    <div><label class="block mb-1">Kategori</label><select name="category_id" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"><option value="">-</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((string)old('category_id', $product->category_id ?? '')===(string)$category->id)>{{ $category->name }}</option>@endforeach</select></div>
    <div><label class="block mb-1">SKU</label><input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
    <div class="md:col-span-2"><label class="block mb-1">Deskripsi</label><textarea name="description" class="w-full rounded-xl border-slate-300 dark:bg-slate-800">{{ old('description', $product->description ?? '') }}</textarea></div>
    <div class="md:col-span-2"><label class="block mb-1">Deskripsi Pendek</label><textarea name="short_description" class="w-full rounded-xl border-slate-300 dark:bg-slate-800">{{ old('short_description', $product->short_description ?? '') }}</textarea></div>
    <div><label class="block mb-1">Warna (pisah koma)</label><input type="text" name="colors" value="{{ old('colors', isset($product) ? implode(', ', $product->colors ?? []) : '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
    <div><label class="block mb-1">Ukuran (pisah koma)</label><input type="text" name="sizes" value="{{ old('sizes', isset($product) ? implode(', ', $product->sizes ?? []) : '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
    <div><label class="block mb-1">Bahan metadata (pisah koma)</label><input type="text" name="materials" value="{{ old('materials', isset($product) ? implode(', ', $product->materials ?? []) : '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
    <div><label class="block mb-1">Dimensi metadata (pisah koma)</label><input type="text" name="dimensions" value="{{ old('dimensions', isset($product) ? implode(', ', $product->dimensions ?? []) : '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
    <div><label class="block mb-1">Tag</label><select name="tag_ids[]" multiple class="w-full rounded-xl border-slate-300 dark:bg-slate-800 h-28">@foreach($tags as $tag)<option value="{{ $tag->id }}" @selected(in_array($tag->id, $selectedTags))>{{ $tag->name }}</option>@endforeach</select></div>
    <div><label class="block mb-1">Perajin</label><select name="artisan_ids[]" multiple class="w-full rounded-xl border-slate-300 dark:bg-slate-800 h-28">@foreach($artisans as $artisan)<option value="{{ $artisan->id }}" @selected(in_array($artisan->id, $selectedArtisans))>{{ $artisan->name }}</option>@endforeach</select></div>
    <div class="md:col-span-2"><label class="block mb-1">Material Produksi</label><select name="material_ids[]" multiple class="w-full rounded-xl border-slate-300 dark:bg-slate-800 h-28">@foreach($materials as $material)<option value="{{ $material->id }}" @selected(in_array($material->id, $selectedMaterials))>{{ $material->name }}</option>@endforeach</select></div>
    <div class="md:col-span-2 space-y-2">
        <label class="block">Path Gambar Produk</label>
        @foreach(($imagePaths ?: ['']) as $path)
            <input type="text" name="image_paths[]" value="{{ $path }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800" placeholder="images/produk-1.jpg">
        @endforeach
        <input type="text" name="image_paths[]" class="w-full rounded-xl border-slate-300 dark:bg-slate-800" placeholder="Tambahan path gambar">
    </div>
    <div class="md:col-span-2 space-y-2">
        <label class="block">Varian Produk</label>
        @for($i = 0; $i < max(3, count($variantNames)); $i++)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
                <input type="text" name="variant_names[]" value="{{ $variantNames[$i] ?? '' }}" class="rounded-xl border-slate-300 dark:bg-slate-800" placeholder="Nama varian">
                <input type="text" name="variant_colors[]" value="{{ $variantColors[$i] ?? '' }}" class="rounded-xl border-slate-300 dark:bg-slate-800" placeholder="Warna">
                <input type="text" name="variant_sizes[]" value="{{ $variantSizes[$i] ?? '' }}" class="rounded-xl border-slate-300 dark:bg-slate-800" placeholder="Ukuran">
                <div class="grid grid-cols-2 gap-2">
                    <input type="number" step="0.01" name="variant_prices[]" value="{{ $variantPrices[$i] ?? '' }}" class="rounded-xl border-slate-300 dark:bg-slate-800" placeholder="Harga">
                    <input type="number" name="variant_stocks[]" value="{{ $variantStocks[$i] ?? '' }}" class="rounded-xl border-slate-300 dark:bg-slate-800" placeholder="Stok">
                </div>
            </div>
        @endfor
    </div>
    <div class="flex flex-wrap gap-4 md:col-span-2">
        <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))><span>Featured</span></label>
        <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_best_seller" value="1" @checked(old('is_best_seller', $product->is_best_seller ?? false))><span>Best Seller</span></label>
        <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_new" value="1" @checked(old('is_new', $product->is_new ?? false))><span>Produk Baru</span></label>
    </div>
</div>
