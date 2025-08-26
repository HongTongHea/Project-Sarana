<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'item_id',
        'item_type',
        'quantity',
        'unit_price',
        'total_price'
    ];

    protected $casts = [
        'quantity'    => 'integer',
        'unit_price'  => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    // Polymorphic relation: Product or Accessory
    public function item()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->total_price = $item->quantity * $item->unit_price;
        });

        static::created(fn($item) => $item->purchaseOrder->updateTotalAmount());
        static::updated(fn($item) => $item->purchaseOrder->updateTotalAmount());
        static::deleted(fn($item) => $item->purchaseOrder->updateTotalAmount());
    }
}
