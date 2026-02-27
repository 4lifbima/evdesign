# Database Schema untuk EVDesign - Manajemen Produk/Catalog

## **Schema Database Laravel untuk EVDesign**

Berikut adalah schema database lengkap untuk sistem manajemen produk/catalog EVDesign menggunakan Laravel dengan Laravel Breeze sebagai basis authentication.

---

## **1. Struktur Database Overview**

```sql
-- Database: evdesign
-- Menggunakan Laravel dengan Breeze (authentication scaffold)
```

---

## **2. Tables Schema**

### **2.1 Users Table (dari Laravel Breeze)**

```php
// database/migrations/2014_10_12_000000_create_users_table.php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->enum('role', ['admin', 'manager', 'staff'])->default('staff');
    $table->string('avatar')->nullable();
    $table->string('phone')->nullable();
    $table->boolean('is_active')->default(true);
    $table->rememberToken();
    $table->timestamps();
    $table->softDeletes(); // Untuk keamanan hapus data
});
```

### **2.2 Categories Table**

```php
// database/migrations/2026_02_27_000001_create_categories_table.php
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('icon')->nullable(); // Untuk icon kategori
    $table->string('image')->nullable(); // Gambar representasi kategori
    $table->unsignedBigInteger('parent_id')->nullable(); // Untuk sub-kategori
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    
    $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
});
```

### **2.3 Products Table**

```php
// database/migrations/2026_02_27_000002_create_products_table.php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->text('short_description')->nullable();
    $table->decimal('price', 15, 2);
    $table->decimal('discount_price', 15, 2)->nullable();
    $table->integer('stock')->default(0);
    $table->string('sku')->unique()->nullable(); // Stock Keeping Unit
    $table->string('barcode')->nullable();
    $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
    $table->boolean('is_featured')->default(false);
    $table->boolean('is_best_seller')->default(false);
    $table->boolean('is_new')->default(false);
    
    // Metadata
    $table->json('dimensions')->nullable(); // Panjang, lebar, tinggi, berat
    $table->json('materials')->nullable(); // Bahan-bahan yang digunakan
    $table->json('colors')->nullable(); // Warna yang tersedia
    $table->json('sizes')->nullable(); // Ukuran yang tersedia
    
    // SEO
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->string('meta_keywords')->nullable();
    
    // Foreign Keys
    $table->unsignedBigInteger('category_id')->nullable();
    $table->unsignedBigInteger('created_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();
    
    $table->timestamps();
    $table->softDeletes();
    
    $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
    $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
});
```

### **2.4 Product Images Table**

```php
// database/migrations/2026_02_27_000003_create_product_images_table.php
Schema::create('product_images', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('product_id');
    $table->string('image_path');
    $table->string('thumbnail_path')->nullable();
    $table->string('caption')->nullable();
    $table->integer('sort_order')->default(0);
    $table->boolean('is_primary')->default(false);
    $table->timestamps();
    
    $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    
    // Index untuk performa
    $table->index(['product_id', 'is_primary']);
});
```

### **2.5 Product Variants Table**

```php
// database/migrations/2026_02_27_000004_create_product_variants_table.php
Schema::create('product_variants', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('product_id');
    $table->string('name'); // Contoh: "Kemeja Karawyo - Merah - XL"
    $table->string('sku')->unique()->nullable();
    $table->string('color')->nullable();
    $table->string('size')->nullable();
    $table->decimal('price', 15, 2)->nullable(); // Jika berbeda dari harga produk utama
    $table->integer('stock')->default(0);
    $table->string('image_path')->nullable(); // Foto khusus varian
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    
    $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
});
```

### **2.6 Artisans Table (Perajin/Binaan)**

```php
// database/migrations/2026_02_27_000005_create_artisans_table.php
Schema::create('artisans', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->string('photo')->nullable();
    $table->text('bio')->nullable();
    $table->text('address')->nullable();
    $table->string('village')->nullable(); // Kelurahan/Desa
    $table->string('district')->nullable(); // Kecamatan
    $table->string('city')->nullable(); // Kabupaten/Kota
    $table->string('province')->default('Gorontalo');
    $table->string('phone')->nullable();
    $table->string('email')->nullable();
    $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
    $table->date('joined_date')->nullable(); // Bergabung sejak
    $table->text('skills')->nullable(); // Keahlian khusus
    $table->timestamps();
    $table->softDeletes();
});
```

### **2.7 Product Artisan Pivot Table (Relasi Produk dengan Perajin)**

```php
// database/migrations/2026_02_27_000006_create_artisan_product_table.php
Schema::create('artisan_product', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('artisan_id');
    $table->unsignedBigInteger('product_id');
    $table->integer('quantity_made')->nullable(); // Jumlah yang dibuat
    $table->date('production_date')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();
    
    $table->foreign('artisan_id')->references('id')->on('artisans')->onDelete('cascade');
    $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    
    $table->unique(['artisan_id', 'product_id']);
});
```

### **2.8 Materials Table (Bahan Baku)**

```php
// database/migrations/2026_02_27_000007_create_materials_table.php
Schema::create('materials', function (Blueprint $table) {
    $table->id();
    $string('name');
    $string('slug')->unique();
    $string('category')->nullable(); // Jenis bahan: kain, benang, dll
    $string('unit')->default('pcs'); // Satuan: meter, pcs, kg
    $integer('stock')->default(0);
    $integer('minimum_stock')->default(5); // Alert jika stok di bawah ini
    $decimal('cost_per_unit', 15, 2)->nullable(); // Harga beli per unit
    $string('supplier')->nullable(); // Pemasok
    $text('description')->nullable();
    $string('image')->nullable();
    $boolean('is_active')->default(true);
    $timestamps();
    $softDeletes();
});
```

### **2.9 Product Material Pivot Table**

```php
// database/migrations/2026_02_27_000008_create_product_material_table.php
Schema::create('product_material', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('product_id');
    $table->unsignedBigInteger('material_id');
    $table->decimal('quantity_used', 10, 2)->nullable(); // Jumlah bahan yang digunakan per produk
    $table->string('unit')->nullable(); // Satuan penggunaan
    $table->text('notes')->nullable();
    $table->timestamps();
    
    $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
});
```

### **2.10 Material Stock History Table**

```php
// database/migrations/2026_02_27_000009_create_material_stock_histories_table.php
Schema::create('material_stock_histories', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('material_id');
    $table->enum('type', ['in', 'out', 'adjustment']); // Masuk, Keluar, Penyesuaian
    $table->integer('quantity');
    $table->integer('stock_before');
    $table->integer('stock_after');
    $table->text('notes')->nullable();
    $table->string('reference_type')->nullable(); // Misal: 'production', 'purchase'
    $table->unsignedBigInteger('reference_id')->nullable(); // ID dari tabel terkait
    $table->unsignedBigInteger('created_by')->nullable();
    $table->timestamps();
    
    $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
    
    $table->index(['material_id', 'created_at']);
});
```

### **2.11 Tags Table**

```php
// database/migrations/2026_02_27_000010_create_tags_table.php
Schema::create('tags', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->timestamps();
});
```

### **2.12 Product Tag Pivot Table**

```php
// database/migrations/2026_02_27_000011_create_product_tag_table.php
Schema::create('product_tag', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('product_id');
    $table->unsignedBigInteger('tag_id');
    $table->timestamps();
    
    $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
    
    $table->unique(['product_id', 'tag_id']);
});
```

### **2.13 Galleries Table (untuk Galeri Kegiatan)**

```php
// database/migrations/2026_02_27_000012_create_galleries_table.php
Schema::create('galleries', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('image_path');
    $table->string('thumbnail_path')->nullable();
    $table->string('location')->nullable();
    $table->date('event_date')->nullable();
    $table->enum('category', ['kegiatan', 'produk', 'proses', 'lainnya'])->default('kegiatan');
    $table->boolean('is_featured')->default(false);
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});
```

### **2.14 Articles Table (untuk Berita/Artikel)**

```php
// database/migrations/2026_02_27_000013_create_articles_table.php
Schema::create('articles', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('content');
    $table->string('excerpt')->nullable();
    $table->string('featured_image')->nullable();
    $table->enum('category', ['berita', 'edukasi', 'inspirasi', 'press'])->default('berita');
    $table->json('tags')->nullable();
    $table->integer('views')->default(0);
    $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
    $table->timestamp('published_at')->nullable();
    $table->unsignedBigInteger('author_id')->nullable();
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->timestamps();
    $table->softDeletes();
    
    $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
});
```

### **2.15 Settings Table (untuk Konfigurasi)**

```php
// database/migrations/2026_02_27_000014_create_settings_table.php
Schema::create('settings', function (Blueprint $table) {
    $table->id();
    $table->string('key')->unique();
    $table->text('value')->nullable();
    $table->string('group')->default('general');
    $table->string('type')->default('text'); // text, textarea, image, boolean
    $table->text('description')->nullable();
    $table->timestamps();
});
```

---

## **3. Relationships Diagram**

```
┌─────────────┐         ┌─────────────┐         ┌─────────────┐
│   users     │         │  categories │         │   tags      │
├─────────────┤         ├─────────────┤         ├─────────────┤
│ id          │◄────────│ parent_id   │         │ id          │
│ name        │         │ id          │         │ name        │
│ email       │         │ name        │         │ slug        │
│ role        │         │ slug        │         └──────┬──────┘
│ ...         │         │ ...         │                  │
└─────────────┘         └──────┬──────┘                  │
       │                       │                         │
       │                       │                         │
       ▼                       ▼                         ▼
┌─────────────┐         ┌─────────────┐         ┌─────────────┐
│ articles    │         │  products   │◄────────│ product_tag │
├─────────────┤         ├─────────────┤         └─────────────┘
│ id          │         │ id          │
│ author_id   │◄────────│ category_id │
│ title       │         │ name        │         ┌─────────────┐
│ content     │         │ slug        │         │  artisans   │
│ ...         │         │ price       │         ├─────────────┤
└─────────────┘         │ stock       │         │ id          │
                         │ status      │         │ name        │
                         │ created_by  │◄────────│ phone       │
                         │ updated_by  │◄────────│ email       │
                         └──────┬──────┘         │ ...         │
                                │                 └──────┬──────┘
                                │                        │
                                ▼                        ▼
┌─────────────┐         ┌─────────────┐         ┌─────────────┐
│ materials   │         │product_images│        │artisan_product│
├─────────────┤         ├─────────────┤         ├─────────────┤
│ id          │         │ id          │         │ id          │
│ name        │         │ product_id  │◄────────│ artisan_id  │
│ stock       │         │ image_path  │         │ product_id  │
│ min_stock   │         │ is_primary  │         │ quantity    │
└──────┬──────┘         └─────────────┘         └─────────────┘
       │
       │         ┌─────────────────────┐
       ▼         │  product_material   │
┌─────────────┐  ├─────────────────────┤
│material_stock│ │ id                  │
│_history     │  │ product_id          │
├─────────────┤  │ material_id         │
│ id          │  │ quantity_used       │
│ material_id │◄─┘ └─────────────────────┘
│ type        │
│ quantity    │
│ stock_before│
│ stock_after │
└─────────────┘
```

---

## **4. Laravel Models**

### **4.1 User.php (extend Breeze)**
```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'avatar', 'phone', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class, 'created_by');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }
}
```

### **4.2 Product.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'short_description', 
        'price', 'discount_price', 'stock', 'sku', 'barcode',
        'status', 'is_featured', 'is_best_seller', 'is_new',
        'dimensions', 'materials', 'colors', 'sizes',
        'meta_title', 'meta_description', 'meta_keywords',
        'category_id', 'created_by', 'updated_by'
    ];

    protected $casts = [
        'dimensions' => 'array',
        'materials' => 'array',
        'colors' => 'array',
        'sizes' => 'array',
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_new' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function artisans()
    {
        return $this->belongsToMany(Artisan::class, 'artisan_product')
                    ->withPivot('quantity_made', 'production_date', 'notes')
                    ->withTimestamps();
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'product_material')
                    ->withPivot('quantity_used', 'unit', 'notes')
                    ->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Accessors
    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    public function getIsDiscountedAttribute()
    {
        return !is_null($this->discount_price) && $this->discount_price < $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->is_discounted) return 0;
        return round((($this->price - $this->discount_price) / $this->price) * 100);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
```

### **4.3 Category.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'image', 'parent_id', 'sort_order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Accessors
    public function getProductCountAttribute()
    {
        return $this->products()->published()->count();
    }
}
```

### **4.4 Artisan.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artisan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'photo', 'bio', 'address', 
        'village', 'district', 'city', 'province',
        'phone', 'email', 'status', 'joined_date', 'skills'
    ];

    protected $casts = [
        'joined_date' => 'date',
        'skills' => 'array',
    ];

    // Relationships
    public function products()
    {
        return $this->belongsToMany(Product::class, 'artisan_product')
                    ->withPivot('quantity_made', 'production_date', 'notes')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
```

### **4.5 Material.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'category', 'unit', 'stock', 
        'minimum_stock', 'cost_per_unit', 'supplier', 
        'description', 'image', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'cost_per_unit' => 'decimal:2',
    ];

    // Relationships
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_material')
                    ->withPivot('quantity_used', 'unit', 'notes')
                    ->withTimestamps();
    }

    public function stockHistories()
    {
        return $this->hasMany(MaterialStockHistory::class);
    }

    // Accessors
    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) return 'habis';
        if ($this->stock <= $this->minimum_stock) return 'menipis';
        return 'aman';
    }

    public function getStockStatusColorAttribute()
    {
        return match($this->stock_status) {
            'habis' => 'danger',
            'menipis' => 'warning',
            default => 'success',
        };
    }
}
```

### **4.6 ProductImage.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id', 'image_path', 'thumbnail_path', 
        'caption', 'sort_order', 'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
```

### **4.7 ProductVariant.php**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'name', 'sku', 'color', 'size',
        'price', 'stock', 'image_path', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
```

---

## **5. Seeders untuk Data Awal**

### **5.1 DatabaseSeeder.php**
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            ArtisanSeeder::class,
            MaterialSeeder::class,
            ProductSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
```

### **5.2 CategorySeeder.php**
```php
<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Ready to Wear',
                'slug' => 'ready-to-wear',
                'description' => 'Koleksi pakaian siap pakai dengan sentuhan sulaman Karawyo',
                'icon' => 'solar:tshirt-linear',
                'is_active' => true,
            ],
            [
                'name' => 'Kemeja',
                'slug' => 'kemeja',
                'description' => 'Kemeja modern dengan motif Karawyo',
                'parent_id' => 1, // ID dari Ready to Wear
                'is_active' => true,
            ],
            [
                'name' => 'Celana Boim',
                'slug' => 'celana-boim',
                'description' => 'Celana casual dengan sentuhan sulaman',
                'parent_id' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Jacket',
                'slug' => 'jacket',
                'description' => 'Jaket modern dengan aplikasi sulaman Karawyo',
                'parent_id' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Outer',
                'slug' => 'outer',
                'description' => 'Outer elegan untuk berbagai kesempatan',
                'parent_id' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Jas',
                'slug' => 'jas',
                'description' => 'Jas formal dengan detail sulaman khas',
                'parent_id' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Gaun Malam',
                'slug' => 'gaun-malam',
                'description' => 'Gaun malam eksklusif dengan sulaman Karawyo',
                'parent_id' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Bahan Sulaman',
                'slug' => 'bahan-sulaman',
                'description' => 'Bahan kain dengan sulaman Karawyo siap pakai',
                'icon' => 'solar:box-linear',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
```

### **5.3 ArtisanSeeder.php**
```php
<?php

namespace Database\Seeders;

use App\Models\Artisan;
use Illuminate\Database\Seeder;

class ArtisanSeeder extends Seeder
{
    public function run()
    {
        // Membuat 40 data dummy perajin
        Artisan::factory()->count(40)->create([
            'province' => 'Gorontalo',
            'city' => 'Kabupaten Gorontalo',
            'district' => 'Limboto',
            'village' => 'Kayubulan',
        ]);
    }
}
```

### **5.4 SettingSeeder.php**
```php
<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            [
                'key' => 'company_name',
                'value' => 'EVDesign',
                'group' => 'company',
                'type' => 'text',
                'description' => 'Nama perusahaan',
            ],
            [
                'key' => 'company_address',
                'value' => 'Griya Kayubulan Permai, RT 009/ RW 003, Kelurahan Kayubulan, Kecamatan Limboto, Kabupaten Gorontalo, Provinsi Gorontalo',
                'group' => 'company',
                'type' => 'textarea',
                'description' => 'Alamat lengkap perusahaan',
            ],
            [
                'key' => 'company_phone',
                'value' => '+6285798132505',
                'group' => 'company',
                'type' => 'text',
                'description' => 'Nomor telepon',
            ],
            [
                'key' => 'company_email',
                'value' => 'help@evdesign.id',
                'group' => 'company',
                'type' => 'text',
                'description' => 'Email perusahaan',
            ],
            [
                'key' => 'nib_number',
                'value' => '91202412345678',
                'group' => 'legal',
                'type' => 'text',
                'description' => 'Nomor Induk Berusaha',
            ],
            [
                'key' => 'nib_date',
                'value' => '27 Januari 2024',
                'group' => 'legal',
                'type' => 'text',
                'description' => 'Tanggal penerbitan NIB',
            ],
            [
                'key' => 'nib_city',
                'value' => 'Jakarta',
                'group' => 'legal',
                'type' => 'text',
                'description' => 'Kota penerbitan NIB',
            ],
            [
                'key' => 'primary_color',
                'value' => '#fc1919',
                'group' => 'appearance',
                'type' => 'text',
                'description' => 'Warna primary website',
            ],
            [
                'key' => 'total_artisans',
                'value' => '40',
                'group' => 'stats',
                'type' => 'number',
                'description' => 'Jumlah perajin binaan',
            ],
            [
                'key' => 'founded_year',
                'value' => '2021',
                'group' => 'company',
                'type' => 'number',
                'description' => 'Tahun berdiri',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
```

---

## **6. Migration Commands**

```bash
# Buat semua migration
php artisan make:migration create_categories_table
php artisan make:migration create_products_table
php artisan make:migration create_product_images_table
php artisan make:migration create_product_variants_table
php artisan make:migration create_artisans_table
php artisan make:migration create_artisan_product_table
php artisan make:migration create_materials_table
php artisan make:migration create_product_material_table
php artisan make:migration create_material_stock_histories_table
php artisan make:migration create_tags_table
php artisan make:migration create_product_tag_table
php artisan make:migration create_galleries_table
php artisan make:migration create_articles_table
php artisan make:migration create_settings_table

# Tambahkan kolom ke tabel users (setelah install Breeze)
php artisan make:migration add_fields_to_users_table

# Jalankan migration
php artisan migrate

# Buat factory
php artisan make:factory ArtisanFactory --model=Artisan
php artisan make:factory ProductFactory --model=Product

# Buat seeder
php artisan make:seeder CategorySeeder
php artisan make:seeder ArtisanSeeder
php artisan make:seeder SettingSeeder

# Jalankan seeder
php artisan db:seed
```

---

## **7. Factory untuk Data Dummy**

### **7.1 ArtisanFactory.php**
```php
<?php

namespace Database\Factories;

use App\Models\Artisan;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtisanFactory extends Factory
{
    protected $model = Artisan::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->unique()->slug(),
            'photo' => 'artisans/placeholder-' . fake()->numberBetween(1, 10) . '.jpg',
            'bio' => fake()->paragraph(),
            'address' => fake()->address(),
            'village' => fake()->streetName(),
            'district' => fake()->citySuffix(),
            'city' => fake()->city(),
            'province' => 'Gorontalo',
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'status' => fake()->randomElement(['active', 'active', 'active', 'inactive']),
            'joined_date' => fake()->dateTimeBetween('-3 years', 'now'),
            'skills' => json_encode(['sulaman', 'menjahit', 'desain']),
        ];
    }
}
```

---

## **8. Repository Pattern (Opsional)**

Untuk memisahkan logika bisnis, bisa menggunakan repository pattern:

```php
<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getAllWithFilters($filters = [])
    {
        $query = $this->product->with(['category', 'primaryImage', 'artisans']);

        if (isset($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function createWithRelations(array $data, array $images = [], array $artisans = [])
    {
        return DB::transaction(function () use ($data, $images, $artisans) {
            $product = $this->product->create($data);

            // Upload images
            foreach ($images as $index => $image) {
                $product->images()->create([
                    'image_path' => $image['path'],
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }

            // Attach artisans
            if (!empty($artisans)) {
                $product->artisans()->attach($artisans);
            }

            return $product;
        });
    }

    public function updateStock($productId, $quantity)
    {
        $product = $this->product->find($productId);
        $product->stock += $quantity;
        $product->save();

        return $product;
    }
}
```

---

## **9. API Resources (untuk API)**

```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'final_price' => $this->final_price,
            'is_discounted' => $this->is_discounted,
            'discount_percentage' => $this->discount_percentage,
            'stock' => $this->stock,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'is_best_seller' => $this->is_best_seller,
            'is_new' => $this->is_new,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'primary_image' => $this->primaryImage?->image_path,
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
            'artisans' => ArtisanResource::collection($this->whenLoaded('artisans')),
            'created_at' => $this->created_at->format('d M Y'),
            'updated_at' => $this->updated_at->format('d M Y'),
        ];
    }
}
```

---

Schema database di atas sudah mencakup semua kebutuhan untuk manajemen produk/catalog EVDesign dengan fitur:

1. **Manajemen Produk** - dengan kategori, varian, gambar
2. **Manajemen Perajin (Binaan)** - relasi dengan produk
3. **Manajemen Bahan Baku** - stok dan history
4. **Manajemen Galeri & Artikel** - untuk konten website
5. **Settings** - konfigurasi dinamis
6. **User Management** - dari Laravel Breeze dengan tambahan role

Semua relasi sudah dibuat dengan foreign key constraints dan index untuk performa optimal.