<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'price',
        'size',
        'stock_quantity',
        'category_id',
        'picture_url'
    ];

    // Define a relationship to the Category model
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
