<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['name', 'alias'];

    function product()
    {
        return $this->hasMany(Products::class);
    }
}
