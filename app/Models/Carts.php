<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $fillable = ['no_invoice', 'product_id', 'qyt', 'diskon_product'];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
