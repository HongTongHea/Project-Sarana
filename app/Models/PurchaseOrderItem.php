<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            // Calculate total price automatically
            $item->total_price = $item->quantity * $item->unit_price;
        });

        static::created(function ($item) {
            // Update purchase order total when items are added
            $item->purchaseOrder->updateTotalAmount();
        });

        static::updated(function ($item) {
            // Update purchase order total when items are modified
            $item->purchaseOrder->updateTotalAmount();
        });

        static::deleted(function ($item) {
            // Update purchase order total when items are removed
            $item->purchaseOrder->updateTotalAmount();
        });
    }
}
