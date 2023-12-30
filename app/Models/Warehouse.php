<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Warehouse extends Authenticatable
{
    use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    protected  $fillable=['WareHouse_name','password','username'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $table = 'warehouses';
    protected $casts = [
        'password' => 'hashed',
    ];
}
