<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnlineOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'online_order_id',
        'item_type',
        'item_id',
        'item_name',
        'quantity',
        'unit_price',
        'discount_percentage',
        'discounted_price',
        'total_price',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the order that owns the item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(OnlineOrder::class, 'online_order_id');
    }

    /**
     * Get the polymorphic item relation.
     */
    public function item()
    {
        return $this->morphTo();
    }
}
