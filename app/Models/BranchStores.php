<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchStores extends Model
{
    protected $fillable = ['nama_cabang', 'no_telp', 'alamat'];

    public function products()
    {
        return $this->hasMany(Products::class, 'cabang_id', 'id');
    }
}
