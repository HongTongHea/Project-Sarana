<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'position',
        'picture_url',
        'status'
    ];

    protected $casts = [
        'status' => 'integer'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Scope for sales employees
    public function scopeSales($query)
    {
        return $query->where('position', 'like', '%sales%')->where('status', 1);
    }

    // Scope for cashiers
    public function scopeCashiers($query)
    {
        return $query->where('position', 'like', '%cashier%')->where('status', 1);
    }

    // Check if employee is sales staff
    public function isSales()
    {
        return stripos($this->position, 'sales') !== false;
    }

    // Check if employee is cashier
    public function isCashier()
    {
        return stripos($this->position, 'cashier') !== false;
    }
}
