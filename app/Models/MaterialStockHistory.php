<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialStockHistory extends Model
{
    protected $fillable = [
        'material_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'notes',
        'reference_type',
        'reference_id',
        'created_by',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
