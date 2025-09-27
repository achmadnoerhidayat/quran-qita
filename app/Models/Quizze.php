<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quizze extends Model
{
    protected $fillable = ['course_id', 'title', 'duration'];

    protected $hidden = ['course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function question()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }
}
