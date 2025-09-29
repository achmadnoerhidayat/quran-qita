<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserScore extends Model
{
    protected $fillable = ['attempt_id', 'score', 'percentage'];

    protected $hidden = ['attempt_id'];

    public function attemp()
    {
        return $this->belongsTo(QuizAttempt::class, 'attempt_id');
    }
}
