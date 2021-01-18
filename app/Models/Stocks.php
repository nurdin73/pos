<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    protected $fillable = ['product_id', 'stok', 'harga_dasar', 'tgl_update'];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
