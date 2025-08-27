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
        'initial_quantity',
        'type',
        'change_amount',
        'created_at',
        'updated_at'
    ];

    public function stockable()
    {
        return $this->morphTo();
    }

    /**
     * Update stock quantity for a product or accessory.
     *
     * @param string $stockableType  (Product::class or Accessory::class)
     * @param int    $stockableId    (ID of the product/accessory)
     * @param int    $quantityChange (positive = add, negative = reduce)
     * @param string $type           (initial, purchase, sale, return, adjust)
     */
    public static function updateStock($stockableType, $stockableId, $quantityChange, $type = 'purchase')
    {
        // Get the latest stock record
        $stock = self::where('stockable_id', $stockableId)
            ->where('stockable_type', $stockableType)
            ->latest()
            ->first();

        // For sales, ensure we record a negative change amount
        $changeAmount = $type === 'sale' ? -abs($quantityChange) : abs($quantityChange);

        // If no record exists, create initial record
        if (!$stock) {
            $stockable = $stockableType::find($stockableId);
            $initialQuantity = $stockable->stock_quantity ?? 0;

            $stock = self::create([
                'stockable_id'   => $stockableId,
                'stockable_type' => $stockableType,
                'quantity'       => $initialQuantity + $changeAmount,
                'initial_quantity' => $initialQuantity,
                'type'           => $type,
                'change_amount'  => $changeAmount
            ]);

            // Also update the product/accessory's stock_quantity field
            if ($stockable) {
                $stockable->stock_quantity = $stock->quantity;
                $stockable->save();
            }

            return $stock;
        }

        // Update stock quantity
        $newQuantity = $stock->quantity + $changeAmount;

        // Create a new stock record instead of updating the existing one
        $newStock = self::create([
            'stockable_id'   => $stockableId,
            'stockable_type' => $stockableType,
            'quantity'       => $newQuantity,
            'initial_quantity' => $stock->initial_quantity,
            'type'           => $type,
            'change_amount'  => $changeAmount
        ]);

        // Update the product/accessory's stock_quantity field
        $stockable = $stockableType::find($stockableId);
        if ($stockable) {
            $stockable->stock_quantity = $newQuantity;
            $stockable->save();
        }

        return $newStock;
    }
}
