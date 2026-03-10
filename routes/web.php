<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// ─── Landing / Frontend Catalog (Public) ───
Route::prefix('katalog')->name('landing.')->group(function () {
    Route::get('/',                         [LandingController::class, 'home'])           ->name('home');
    Route::get('/produk',                   [LandingController::class, 'products'])       ->name('products.index');
    Route::get('/produk/{product:slug}',    [LandingController::class, 'productDetail'])  ->name('products.show');
    Route::get('/kategori',                 [LandingController::class, 'categories'])     ->name('categories.index');
    Route::get('/kategori/{category:slug}', [LandingController::class, 'categoryDetail'])->name('categories.show');
    Route::get('/tentang',                  [LandingController::class, 'about'])          ->name('about');
    Route::get('/kontak',                   [LandingController::class, 'contact'])        ->name('contact');
});

Route::get('/', fn() => redirect()->route('landing.home'));

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'products' => ProductController::class,
        'categories' => CategoryController::class,
        'settings' => SettingController::class,
    ]);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
