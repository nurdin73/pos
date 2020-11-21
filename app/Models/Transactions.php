<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = ['no_invoice', 'createdBy', 'customer_id', 'diskon_transaksi', 'total', 'tgl_transaksi', 'jam_transaksi', 'keterangan'];

    public function carts()
    {
        return $this->hasMany(Carts::class, 'no_invoice', 'no_invoice');
    }
}
