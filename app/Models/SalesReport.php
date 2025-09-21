<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_type',
        'period_value',
        'start_date',
        'end_date',
        'total_orders',
        'total_subtotal',
        'total_tax_amount',
        'total_discount_amount',
        'total_revenue',
        'average_order_value'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_subtotal' => 'decimal:2',
        'total_tax_amount' => 'decimal:2',
        'total_discount_amount' => 'decimal:2',
        'total_revenue' => 'decimal:2',
        'average_order_value' => 'decimal:2',
    ];
}
