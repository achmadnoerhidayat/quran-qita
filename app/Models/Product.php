<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title', 'category_id', 'icon', 'deskripsi', 'price', 'duration', 'is_premium'];

    protected $hidden = ['category_id'];

    protected $casts = [
        "is_premium" => "boolean",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
