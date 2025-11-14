<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinRate extends Model
{
    protected $fillable = ['type', 'coin_unit', 'unit_value', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];
}
