<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeProducts extends Model
{
    use HasFactory;
   
    protected $fillable = ['product_id', 'kode_barang'];
    protected $hidden = ['created_at', 'updated_at'];

    function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
