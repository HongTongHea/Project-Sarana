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
        'order_date' => 'date',
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

    // When marking as received, update product stock
    public function markAsReceived()
    {
        if ($this->status !== 'pending') {
            return false;
        }

        DB::transaction(function () {
            foreach ($this->items as $item) {
                if ($item->product) {   // ✅ check if product exists
                    $item->product->stock_quantity += $item->quantity;
                    $item->product->save();

                    // Optionally log stock change
                    Stock::updateStock(Product::class, $item->product->id, $item->quantity);
                }
            }

            $this->status = 'received';
            $this->save();
        });

        return true;
    }
}
