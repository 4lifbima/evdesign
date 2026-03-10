<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
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
