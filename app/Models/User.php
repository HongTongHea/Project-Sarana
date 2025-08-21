<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role', 'picture_url', 'google_id', 'email_verified_at'];

    protected $hidden = ['password', 'remember_token'];

    // public function isAdmin()
    // {
    //     return $this->role === 'admin';
    // }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isCashier()
    {
        return $this->role === 'cashier';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }
}
