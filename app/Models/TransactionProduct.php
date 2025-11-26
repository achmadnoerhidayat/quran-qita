<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionProduct extends Model
{
    protected $fillable = ['user_id', 'product_id', 'starts_at', 'end_at', 'amount_coin', 'exp_refund', 'status'];

    protected $hidden = ['user_id', 'product_id'];

    protected $casts = [
        "starts_at" => "datetime",
        "end_at" => "datetime",
        "exp_refund" => "datetime",
    ];

    public function detail()
    {
        return $this->hasMany(TransactionProductDetail::class, 'transaction_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
