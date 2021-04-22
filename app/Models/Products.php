<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = ['suplier_id', 'cabang_id', 'nama_barang', 'alias_name', 'type_barang', 'harga_dasar', 'harga_jual', 'stok', 'selled', 'kategori_id', 'berat', 'satuan', 'diskon', 'rak', 'keterangan', 'point', 'isRetail', 'jumlah', 'jumlahEceranPermanent', 'harga_satuan'];

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

    function codeProducts()
    {
        return $this->hasMany(CodeProducts::class, 'product_id', 'id');
    }

    public function typePrices()
    {
        return $this->hasMany(TypePrices::class, 'product_id', 'id');
    }

    public function suplier()
    {
        return $this->belongsTo(Supliers::class, 'suplier_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(BranchStores::class, 'cabang_id', 'id');
    }

    public function returnProducts()
    {
        return $this->hasMany(ReturnProduct::class, 'product_id', 'product_id');
    }
}
