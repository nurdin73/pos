<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supliers extends Model
{
    protected $fillable = ['nama_suplier', 'email', 'no_telp', 'alamat'];

    public function products()
    {
        return $this->hasMany(Products::class, 'suplier_id', 'id');
    }
}
