<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'unit',
        'price',
        'stock_quantity',
    ];

    /**
     * Ni Juga
     * HEHE
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}