<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnProduct extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'qyt', 'reason', 'status'];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
