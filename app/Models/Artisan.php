<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artisan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'photo',
        'bio',
        'address',
        'village',
        'district',
        'city',
        'province',
        'phone',
        'email',
        'status',
        'joined_date',
        'skills',
    ];

    protected $casts = [
        'joined_date' => 'date',
        'skills' => 'array',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'artisan_product')
            ->withPivot('quantity_made', 'production_date', 'notes')
            ->withTimestamps();
    }
}
