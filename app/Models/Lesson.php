<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['course_id', 'body', 'content_url'];

    protected $hidden = ['course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
