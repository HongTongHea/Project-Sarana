<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'stockable_id',
        'stockable_type',
        'quantity',
        'type',
        'initial_quantity'
    ];

    public function stockable()
    {
        return $this->morphTo();
    }

    // Method to update stock
    public static function updateStock($stockableType, $stockableId, $quantityChange)
    {
        $stock = self::firstOrCreate(
            [
                'stockable_id' => $stockableId,
                'stockable_type' => $stockableType
            ],
            [
                'quantity' => 0,
                'initial_quantity' => 0,
                'type' => class_basename($stockableType)
            ]
        );

        if ($stock->wasRecentlyCreated) {
            $stockable = $stockableType::find($stockableId);
            $stock->initial_quantity = $stockable->stock_quantity ?? 0;
            $stock->quantity = $stockable->stock_quantity ?? 0;
            $stock->save();
        }

        $stock->decrement('quantity', $quantityChange);

        return $stock;
    }
}
