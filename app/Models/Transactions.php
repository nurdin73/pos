<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = ['no_invoice', 'createdBy', 'customer_id', 'diskon_transaksi', 'total', 'modal', 'cash', 'pajak', 'change', 'tgl_transaksi', 'jam_transaksi', 'keterangan'];

    
    protected $hidden = [
        'createdBy', 'customer_id', 'created_at', 'updated_at'
    ];
    
    public function carts()
    {
        return $this->hasMany(Carts::class, 'no_invoice', 'no_invoice');
    }
    
    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'createdBy', 'id');
    }
}
