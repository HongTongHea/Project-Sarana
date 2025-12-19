<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'price',
        'stock_quantity',
        'category_id',
        'picture_url',
        'barcode',
        'discount_percentage'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function stocks()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }

public function item()
{
    return $this->morphTo();
}
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function onlineOrderItems()
    {
        return $this->morphMany(OnlineOrderItem::class, 'item');
    }

    // Add this method to check stock availability
    public function hasSufficientStock($quantity)
    {
        return $this->stock_quantity >= $quantity;
    }

    // Optionally add an accessor for discounted price
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount_percentage > 0) {
            return $this->price - ($this->price * ($this->discount_percentage / 100));
        }
        return $this->price;
    }
}
