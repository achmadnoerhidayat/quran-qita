<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinTransaction extends Model
{
    protected $fillable = ['user_id', 'purchase_id', 'amount_coin', 'start_balance', 'end_balance'];

    protected $hidden = ['user_id', 'purchase_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchase()
    {
        return $this->belongsTo(CoinPurchase::class, 'purchase_id');
    }
}
