<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewContent extends Model
{
    protected $fillable = ['user_id', 'content_id'];

    protected $hidden = ['user_id', 'content_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}
