<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quizze extends Model
{
    protected $fillable = ['lesson_id', 'title', 'duration'];

    protected $hidden = ['lesson_id'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    public function question()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }
}
