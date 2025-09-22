<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'user_id',
        'surah_id',
        'ayat_id',
        'title',
        'description',
        'scheduled_at',
        'recurrence_pattern',
        'is_completed'
    ];

    protected $hidden = [
        'user_id',
        'surah_id',
        'ayat_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }

    public function ayat()
    {
        return $this->belongsTo(Ayat::class, 'ayat_id');
    }
}
