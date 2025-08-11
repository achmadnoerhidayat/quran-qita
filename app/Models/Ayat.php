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
    ];

    protected $hidden = ['surah_id'];

    public function surat()
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }
}
