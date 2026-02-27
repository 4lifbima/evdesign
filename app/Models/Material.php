<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'unit',
        'stock',
        'minimum_stock',
        'cost_per_unit',
        'supplier',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'cost_per_unit' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_material')
            ->withPivot('quantity_used', 'unit', 'notes')
            ->withTimestamps();
    }

    public function stockHistories(): HasMany
    {
        return $this->hasMany(MaterialStockHistory::class);
    }
}
