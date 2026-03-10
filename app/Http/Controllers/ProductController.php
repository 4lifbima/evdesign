<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category'])
            ->when(request('q'), fn ($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->when(request('status'), fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        DB::transaction(function () use ($request): void {
            $data = $this->payload($request->validated(), $request->user()?->id, true);
            $product = Product::create($data);
            $this->syncRelations($product, $request->validated());
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'variants']);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load(['images', 'variants']);

        return view('products.edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product): void {
            $data = $this->payload($request->validated(), $request->user()?->id, false, $product);
            $product->update($data);
            $this->syncRelations($product, $request->validated(), true);
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function payload(array $validated, ?int $userId, bool $isCreate, ?Product $product = null): array
    {
        return [
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?: Str::slug($validated['name']).'-'.($isCreate ? Str::lower(Str::random(4)) : $product?->id),
            'description' => $validated['description'] ?? null,
            'short_description' => $validated['short_description'] ?? null,
            'price' => $validated['price'],
            'discount_price' => $validated['discount_price'] ?? null,
            'stock' => $validated['stock'] ?? 0,
            'sku' => $validated['sku'] ?? null,
            'barcode' => $validated['barcode'] ?? null,
            'status' => $validated['status'],
            'is_featured' => request()->boolean('is_featured'),
            'is_best_seller' => request()->boolean('is_best_seller'),
            'is_new' => request()->boolean('is_new'),
            'colors' => $this->csvToArray($validated['colors'] ?? null),
            'sizes' => $this->csvToArray($validated['sizes'] ?? null),
            'materials' => $this->csvToArray($validated['materials'] ?? null),
            'dimensions' => $this->csvToArray($validated['dimensions'] ?? null),
            'category_id' => $validated['category_id'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'created_by' => $isCreate ? $userId : $product?->created_by,
            'updated_by' => $userId,
        ];
    }

    private function syncRelations(Product $product, array $validated, bool $replace = false): void
    {

        if ($replace) {
            $product->images()->delete();
            $product->variants()->delete();
        }

        foreach (($validated['image_paths'] ?? []) as $index => $path) {
            if (! filled($path)) {
                continue;
            }

            $product->images()->create([
                'image_path' => $path,
                'is_primary' => $index === 0,
                'sort_order' => $index,
            ]);
        }

        $names = $validated['variant_names'] ?? [];
        foreach ($names as $index => $name) {
            if (! filled($name)) {
                continue;
            }

            $product->variants()->create([
                'name' => $name,
                'sku' => null,
                'color' => $validated['variant_colors'][$index] ?? null,
                'size' => $validated['variant_sizes'][$index] ?? null,
                'price' => $validated['variant_prices'][$index] ?? null,
                'stock' => $validated['variant_stocks'][$index] ?? 0,
                'is_active' => true,
            ]);
        }
    }

    private function csvToArray(?string $value): ?array
    {
        if (! $value) {
            return null;
        }

        return collect(explode(',', $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
