<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinPackage extends Model
{
    protected $fillable = ['coin_amount', 'price', 'bonus_coin', 'is_active'];
}
