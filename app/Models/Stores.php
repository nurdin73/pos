<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $fillable = ['logo', 'jenis_usaha', 'nama_toko', 'owner', 'no_telp', 'npwp', 'alamat'];
}
