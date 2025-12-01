<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = ['name', 'icon', 'animation_url', 'coin_cost', 'is_active', 'deskripsi'];

    protected $casts = [
        "is_active" => "boolean",
    ];
}
