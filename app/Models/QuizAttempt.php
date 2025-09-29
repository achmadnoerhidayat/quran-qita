<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = ['user_id', 'quiz_id', 'start_time', 'end_time', 'status'];

    protected $hidden = ['user_id', 'quiz_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quizze::class, 'quiz_id');
    }

    public function quizResponse()
    {
        return $this->hasMany(QuizResponse::class, 'attempt_id');
    }

    public function userScore()
    {
        return $this->hasOne(UserScore::class, 'attempt_id');
    }
}
