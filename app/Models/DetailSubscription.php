<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSubscription extends Model
{
    protected $fillable = ['user_id', 'subscription_id', 'aksi', 'keterangan'];

    protected $hidden = ['user_id', 'subscription_id'];
}
