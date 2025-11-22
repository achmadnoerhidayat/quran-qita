<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title', 'category_id', 'icon', 'deskripsi', 'price', 'duration'];

    protected $hidden = ['category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
