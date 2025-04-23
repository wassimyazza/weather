<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'tableau_ids',
        'total_price',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_note',
        'status',
        'confirmation_token',
    ];

    protected $casts = [
        'tableau_ids' => 'array'
    ];
}