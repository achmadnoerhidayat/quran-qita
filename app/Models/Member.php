<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['user_id', 'comunity_id', 'role'];

    protected $hidden = ['user_id', 'comunity_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comunity()
    {
        return $this->belongsTo(Comunity::class, 'comunity_id');
    }
}
