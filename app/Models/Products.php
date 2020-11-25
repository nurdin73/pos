<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = ['nama_barang', 'type_barang', 'kode_barang', 'harga_dasar', 'harga_jual', 'stok', 'selled', 'kategori_id', 'berat', 'satuan', 'diskon', 'rak', 'keterangan'];

    function kategori()
    {
        return $this->belongsTo(Categories::class, 'kategori_id', 'id');
    }

    function images()
    {
        return $this->hasMany(FileProducts::class, 'product_id', 'id');
    }

    function stocks()
    {
        return $this->hasMany(Stocks::class, 'product_id', 'id');
    }
}
