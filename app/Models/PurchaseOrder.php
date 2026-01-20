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
    if ($this->status !== 'pending') {
        return false;
    }

    DB::transaction(function () {

        // Update order status
        $this->status = 'received';
        $this->received_at = now();
        $this->save();

        // Make sure items are loaded
        $this->load('items.item');

        foreach ($this->items as $item) {

            if (!$item->item) continue;

            // 1. Update main stock quantity
            $item->item->increment('stock_quantity', $item->quantity);

            // 2. Get latest quantity after update
            $newQty = $item->item->fresh()->stock_quantity;

            // 3. Insert into stocks table (VERY IMPORTANT)
            Stock::create([
                'stockable_id'   => $item->item->id,
                'stockable_type' => get_class($item->item),
                'type'           => 'purchase',
                'change_amount'  => $item->quantity,
                'quantity'       => $newQty,
            ]);
        }

    });

    return true;
    }
}
