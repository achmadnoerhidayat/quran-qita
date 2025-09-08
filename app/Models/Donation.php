<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'user_id',
        'rekening_bank_id',
        'jumlah_donasi',
        'metode_pembayaran',
        'nama_rekening',
        'nomer_rekening',
        'bukti_transfer',
        'status',
        'keterangan_admin',
    ];

    protected $hidden = [
        'user_id',
        'rekening_bank_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rekeningBank()
    {
        return $this->belongsTo(RekeningBank::class, 'rekening_bank_id');
    }

    public function detailDonation()
    {
        return $this->hasMany(DetailDonation::class, 'donation_id');
    }
}
