<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = ['nama_pajak', 'persentase_pajak', 'harga_barang', 'biaya_pengiriman', 'pajak_ditiadakan', 'biaya_layanan', 'biaya_ditiadakan'];

    public function product()
    {
        return $this->belongsTo(Products::class, 'barang_id', 'id');
    }
}
