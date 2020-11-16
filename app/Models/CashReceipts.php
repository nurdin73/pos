<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashReceipts extends Model
{
    protected $fillable = ['pelanggan_id', 'jumlah', 'tgl_kasbon', 'jatuh_tempo', 'keterangan', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'pelanggan_id', 'id');
    }
}
