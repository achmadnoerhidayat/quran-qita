<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'starts_at', 'end_at', 'payment_status', 'status', 'bukti_transfer', 'keterangan_admin'];

    protected $hidden = ['user_id', 'plan_id'];

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
