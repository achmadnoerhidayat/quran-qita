<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunity extends Model
{
    protected $fillable = ['name', 'logo', 'description'];

    public function member()
    {
        return $this->hasMany(Member::class, 'comunity_id');
    }

    public function post()
    {
        return $this->hasMany(Forum::class, 'comunity_id');
    }
}
