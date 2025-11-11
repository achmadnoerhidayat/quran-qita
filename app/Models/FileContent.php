<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileContent extends Model
{
    protected $fillable = ['content_id', 'url', 'filename'];

    protected $hidden = ['content_id'];
}
