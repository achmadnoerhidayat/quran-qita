<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionProductDetail extends Model
{
    protected $fillable = ['user_id', 'transaction_id', 'aksi', 'keterangan'];

    protected $hidden = ['user_id', 'transaction_id'];
}
