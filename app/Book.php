<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id', 'title', 'slug', 'description', 'author', 'publisher', 'cover', 'price', 'view', 'stock', 'status', 'created_by'
    ];

    protected $dates = ['deleted_at'];

    public function categories() {
        return $this->belongsToMany(Category::Class);
    }

    public function orders() {
        return $this->belongsToMany(Order::Class);
    }
}
