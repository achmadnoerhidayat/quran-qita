<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'forum_id', 'content_id', 'parent_comment_id', 'body'];

    protected $hidden = ['user_id', 'forum_id', 'content_id', 'parent_comment_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id', 'id');
    }
}
