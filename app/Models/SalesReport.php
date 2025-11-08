<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_type',
        'start_date',
        'end_date',
        'total_orders',
        'total_sales',
        'total_tax',
        'average_order_value',
        'report_data'
    ];

    protected $casts = [
        'report_data' => 'array',
        'total_sales' => 'decimal:2',
        'total_tax' => 'decimal:2',
        'average_order_value' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
