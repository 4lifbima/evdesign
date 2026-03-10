<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::with(['primaryImage', 'category'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        // Jika featured kosong, ambil produk published terbaru
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with(['primaryImage', 'category'])
                ->where('status', 'published')
                ->latest()
                ->take(8)
                ->get();
        }

        $newProducts = Product::with(['primaryImage', 'category'])
            ->where('status', 'published')
            ->where('is_new', true)
            ->latest()
            ->take(4)
            ->get();

        $bestSellers = Product::with(['primaryImage', 'category'])
            ->where('status', 'published')
            ->where('is_best_seller', true)
            ->latest()
            ->take(4)
            ->get();

        $categories = Category::withCount(['products' => fn($q) => $q->where('status', 'published')])
            ->orderBy('name')
            ->take(6)
            ->get();

        $totalProducts = Product::where('status', 'published')->count();

        return view('landing.home', compact('featuredProducts', 'newProducts', 'bestSellers', 'categories', 'totalProducts'));
    }

    public function products(Request $request)
    {
        $query = Product::with(['primaryImage', 'category'])
            ->where('status', 'published');

        // Search
        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Price filter
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort
        match ($request->get('sort', 'latest')) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'popular'    => $query->orderByDesc('is_best_seller'),
            default      => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::withCount(['products' => fn($q) => $q->where('status', 'published')])
            ->orderBy('name')
            ->get();

        return view('landing.products.index', compact('products', 'categories'));
    }

    public function productDetail(Product $product)
    {
        if ($product->status !== 'published') {
            abort(404);
        }

        $product->load(['primaryImage', 'images', 'category', 'variants']);

        $related = Product::with(['primaryImage', 'category'])
            ->where('status', 'published')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('landing.products.show', compact('product', 'related'));
    }

    public function categories()
    {
        $categories = Category::withCount(['products' => fn($q) => $q->where('status', 'published')])
            ->orderBy('name')
            ->get();

        return view('landing.categories.index', compact('categories'));
    }

    public function categoryDetail(Category $category)
    {
        $products = Product::with(['primaryImage', 'category'])
            ->where('status', 'published')
            ->where('category_id', $category->id)
            ->paginate(12)
            ->withQueryString();

        return view('landing.categories.show', compact('category', 'products'));
    }

    public function about()
    {
        return view('landing.about');
    }

    public function contact()
    {
        return view('landing.contact');
    }
}
