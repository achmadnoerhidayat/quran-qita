<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayat extends Model
{
    protected $fillable = [
        'surah_id',
        'nomor_ayat',
        'teks_arab',
        'teks_latin',
        'teks_indo',
        'audio',
    ];

    protected $hidden = ['surah_id'];

    protected $casts = [
        'audio' => 'array',
    ];

    public function surat()
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }
}
