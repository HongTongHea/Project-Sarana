<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'created_by',
        'order_date',
        'total_amount',
        'status',
        'received_at',
    ];

    protected $casts = [
        'order_date'   => 'datetime',
        'received_at'  => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function updateTotalAmount()
    {
        $this->total_amount = $this->items()->sum('total_price');
        $this->save();
    }

    /**
     * Mark purchase order as received and update stock
     */
     public function markAsReceived()
    {
        // Check if order is pending
        if ($this->status === 'pending') {
            // Update status and set received timestamp
            $this->status = 'received';
            $this->received_at = now();
            
            // Update stock for all items in the order
            foreach ($this->items as $item) {
                if ($item->item) {
                    if ($item->item_type === Product::class) {
                        // For products
                        $item->item->increment('stock_quantity', $item->quantity);
                    } elseif ($item->item_type === Accessory::class) {
                        // For accessories - if they have stock_quantity field
                        if (isset($item->item->stock_quantity)) {
                            $item->item->increment('stock_quantity', $item->quantity);
                        }
                    }
                }
            }
            
            return $this->save();
        }
        
        return false;
    }
}
