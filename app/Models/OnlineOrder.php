<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnlineOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_first_name',
        'customer_last_name',
        'customer_email',
        'customer_phone',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'shipping_amount',
        'total_amount',
        'status',
        'payment_status',
        'shipping_address',
        'billing_address',
        'customer_notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the customer that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OnlineOrderItem::class, 'online_order_id');
    }

    /**
     * Get formatted order number.
     */
    public function getOrderNumberAttribute(): string
    {
        return 'ORD-' . str_pad($this->id, 2, '0', STR_PAD_LEFT);
    }
}
