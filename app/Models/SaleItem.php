<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'item_type',
        'item_id',
        'quantity',
        'price',
        'discount_percentage',
        'discounted_price',
        'total',
        'picture_url',
        'name'
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

    // Accessor for picture URL
    public function getPictureUrlAttribute($value)
    {
        if ($value) {
            return asset('storage/' . $value);
        }

        // Try to get from the related item if it exists
        if ($this->item) {
            return $this->item->picture_url ? asset('storage/' . $this->item->picture_url) : null;
        }

        return null;
    }
}
