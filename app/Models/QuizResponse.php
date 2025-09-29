<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResponse extends Model
{
    protected $fillable = ['attempt_id', 'question_id', 'answer_id', 'is_correct'];

    protected $hidden = ['attempt_id', 'question_id', 'answer_id'];

    public function attemp()
    {
        return $this->belongsTo(QuizAttempt::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }
}
