<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['quiz_id', 'question_text', 'question_url'];

    protected $hidden = ['quiz_id'];

    public function quiz()
    {
        return $this->belongsTo(Quizze::class, 'quiz_id');
    }

    public function answer()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
}
