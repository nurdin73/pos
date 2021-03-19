<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $fillable = ['no_invoice', 'product_id', 'qyt', 'harga_product', 'diskon_product', 'eceran'];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
