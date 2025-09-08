<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailDonation extends Model
{
    protected $fillable = [
        'donation_id',
        'user_id',
        'aksi',
        'keterangan',
    ];

    protected $hidden = [
        'donation_id',
        'user_id',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}
