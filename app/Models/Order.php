<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'customer_id', 'status', 'total_price', 'payment_status'
    ];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
     public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
