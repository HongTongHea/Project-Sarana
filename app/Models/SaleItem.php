<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'item_type', // For polymorphic relationship (Product or Accessory)
        'item_id',   // For polymorphic relationship (product_id or accessory_id)
        'quantity',
        'price',
        'discount_percentage',
        'discounted_price',
        'total'
    ];

    // Polymorphic relationship
    public function item()
    {
        return $this->morphTo();
    }

    // For backward compatibility or easy access
    public function product()
    {
        return $this->morphTo('item', Product::class, 'item_type', 'item_id');
    }

    public function accessory()
    {
        return $this->morphTo('item', Accessory::class, 'item_type', 'item_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
