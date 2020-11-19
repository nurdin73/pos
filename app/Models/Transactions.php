<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = ['no_invoice', 'createdBy', 'customer_id', 'diskon_transaksi', 'total', 'tgl_transaksi', 'keterangan'];
}
