<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'reminder_type',
        'scheduled_at',
        'recurrence_pattern',
        'is_active'
    ];

    protected $hidden = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
