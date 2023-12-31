<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_medicine extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'amount' => 'integer'
    ];
}
