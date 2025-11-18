<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'message',
        'read_status' // Add this line
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'read_status' => 'boolean' // Add this cast
    ];

    protected $attributes = [
        'read_status' => false // Add default value
    ];

    // Scope for unread messages
    public function scopeUnread($query)
    {
        return $query->where('read_status', false);
    }
}
