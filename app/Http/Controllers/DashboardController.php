<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Artisan;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Material;
use App\Models\Product;
use App\Models\Tag;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'artisans' => Artisan::count(),
            'materials' => Material::count(),
            'tags' => Tag::count(),
            'articles' => Article::count(),
            'galleries' => Gallery::count(),
            'low_stock_materials' => Material::whereColumn('stock', '<=', 'minimum_stock')->count(),
        ];

        $recentProducts = Product::with('category')
            ->latest()
            ->take(6)
            ->get();

        $topCategories = Category::withCount('products')
            ->orderByDesc('products_count')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentProducts', 'topCategories'));
    }
}
