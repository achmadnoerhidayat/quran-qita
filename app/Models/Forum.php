<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = ['user_id', 'comunity_id', 'title', 'content', 'image', 'status'];

    protected $hidden = ['user_id', 'comunity_id'];

    public function comunity()
    {
        return $this->belongsTo(Comunity::class, 'comunity_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
