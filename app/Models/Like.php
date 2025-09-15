<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id', 'likable_type', 'likable_id'];

    protected $hidden = ['user_id', 'likable_type', 'likable_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likable()
    {
        return $this->morphTo();
    }
}
