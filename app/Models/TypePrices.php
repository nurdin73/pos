<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePrices extends Model
{
    protected $fillable = ['product_id', 'nama_agen', 'harga'];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
