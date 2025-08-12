<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = ['user_id', 'title', 'content'];

    protected $hidden = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
