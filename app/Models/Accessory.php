<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'price',
        'stock_quantity',
        'picture_url',
        'discount_percentage'
    ];

    // Discount price accessor
    public function getDiscountedPriceAttribute()
    {
        return $this->discount_percentage > 0
            ? $this->price - ($this->price * $this->discount_percentage / 100)
            : $this->price;
    }

    public function stocks()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }
}
