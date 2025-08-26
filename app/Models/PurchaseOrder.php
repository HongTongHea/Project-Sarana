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
        'status'
    ];

    protected $casts = [
        'order_date'   => 'date',
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
            foreach ($this->items as $item) {
                if ($item->item) {
                    // Update the item's stock quantity
                    $item->item->stock_quantity += $item->quantity;
                    $item->item->save();

                    // Update stock tracking
                    Stock::updateStock(
                        get_class($item->item),
                        $item->item->id,
                        $item->quantity,
                        'purchase'
                    );
                }
            }

            $this->status = 'received';
            $this->save();
        });

        return true;
    }
}
