<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'order_id', 'starts_at', 'end_at', 'payment_method', 'payment_url', 'payment_reference', 'payment_type', 'information', 'price', 'va_number', 'qr_string', 'status'];

    protected $hidden = ['user_id', 'plan_id'];

    protected $casts = [
        "starts_at" => "datetime",
        "end_at" => "datetime",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function detailSubscription()
    {
        return $this->hasMany(DetailSubscription::class, 'subscription_id');
    }
}
