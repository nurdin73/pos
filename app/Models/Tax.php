<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = ['nama_pajak', 'barang_id', 'persentase_pajak'];

    public function product()
    {
        return $this->belongsTo(Products::class, 'barang_id', 'id');
    }
}
