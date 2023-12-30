<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden = [
        'medicines','updated_at','created_at'
    ];
    public function getMedicine()
    {
        return $this->hasMany(Medicine::class);
    }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
