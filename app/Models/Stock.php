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
        'type'
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
     * @param string $type           (purchase, sale, return, adjust)
     */
    public static function updateStock($stockableType, $stockableId, $quantityChange, $type = 'purchase')
    {
        // Get the latest stock record
        $stock = self::where('stockable_id', $stockableId)
            ->where('stockable_type', $stockableType)
            ->latest()
            ->first();

        // If no record exists, create one with initial values
        if (!$stock) {
            $stockable = $stockableType::find($stockableId);
            $initialQuantity = $stockable->stock_quantity ?? 0;

            $stock = self::create([
                'stockable_id'   => $stockableId,
                'stockable_type' => $stockableType,
                'quantity'       => $initialQuantity + $quantityChange,
                'type'           => $type
            ]);

            // Also update the product/accessory's stock_quantity field
            if ($stockable) {
                $stockable->stock_quantity = $stock->quantity;
                $stockable->save();
            }

            return $stock;
        }

        // Update stock quantity
        $newQuantity = $stock->quantity + $quantityChange;

        // Create a new stock record instead of updating the existing one
        $newStock = self::create([
            'stockable_id'   => $stockableId,
            'stockable_type' => $stockableType,
            'quantity'       => $newQuantity,
            'type'           => $type
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
