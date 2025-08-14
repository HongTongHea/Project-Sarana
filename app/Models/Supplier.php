<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'contact_person'
    ];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
