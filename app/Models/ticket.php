<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ticket extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'match_name',
        'stadium',
        'match_date',
        'zoon_seats',
        'zoon_price',
        'status'
    ];
    
}
