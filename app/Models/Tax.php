<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = ['nama_pajak', 'persentasePajak', 'persentaseLayanan', 'hargaBarang', 'pajakAktif', 'layananAktif'];
}
