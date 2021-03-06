<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileProducts extends Model
{
    protected $fillable = ['product_id', 'image'];

    function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
