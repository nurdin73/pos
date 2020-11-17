<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installments extends Model
{
    protected $fillable = ['cash_receipt_id', 'cicilan', 'tgl_pembayaran', 'method_payment', 'keterangan'];

    public function cashReceipt()
    {
        return $this->belongsTo(CashReceipts::class, 'cash_receipt_id', 'id');
    }
}
