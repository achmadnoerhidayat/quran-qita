<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    protected $fillable = [
        'nomor',
        'nama',
        'nama_latin',
        'jumlah_ayat',
        'tempat_turun',
        'arti',
        'arti_english',
        'deskripsi',
        'audio_full',
    ];

    protected $casts = [
        'audio_full' => 'array',
    ];

    public function ayat()
    {
        return $this->hasMany(Ayat::class, 'surah_id');
    }
}
