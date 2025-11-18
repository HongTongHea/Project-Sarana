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

    /**
     * Get formatted report period
     */
    public function getPeriodAttribute()
    {
        return $this->start_date->format('M j, Y') . ' - ' . $this->end_date->format('M j, Y');
    }

    /**
     * Get report type in readable format
     */
    public function getReportTypeFormattedAttribute()
    {
        return ucfirst($this->report_type);
    }

    /**
     * Scope queries by report type
     */
    public function scopeType($query, $type)
    {
        return $query->where('report_type', $type);
    }

    /**
     * Scope queries by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->where('start_date', '>=', $startDate)
            ->where('end_date', '<=', $endDate);
    }
}
