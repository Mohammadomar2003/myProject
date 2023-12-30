<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function medicines()
    {
        return $this->hasMany(Favourite::class,'medicine_id');
    }
    protected $casts = [
        'quantity_available' => 'integer'
    ];
}
