<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'size',
        'stock_quantity',
        'category_id',
        'picture_url',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    // Boot method to automatically handle events
    protected static function boot()
    {
        parent::boot();

        // Add a created event listener
        static::created(function ($product) {
            $product->stocks()->create([
                'product_id' => $product->id,
                'quantity' => $product->stock_quantity,
                'type' => 'initial', // Optional: to denote the type of stock addition
            ]);
        });
    }
}
