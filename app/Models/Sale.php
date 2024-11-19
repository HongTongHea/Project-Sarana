<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'customer_id', 'quantity', 'price', 'total_price', 'sale_date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
