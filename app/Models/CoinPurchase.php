<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinPurchase extends Model
{
    protected $fillable = ['user_id', 'package_id', 'order_id', 'amount_coin', 'payment_method', 'payment_url', 'payment_reference', 'payment_type', 'information', 'price', 'va_number', 'qr_string', 'status'];

    protected $hidden = ['user_id', 'package_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(CoinPackage::class, 'package_id');
    }
}
