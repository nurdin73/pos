<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $fillable = ['nik', 'nama', 'email', 'no_telp', 'alamat', 'point'];

    public function cashReceipts()
    {
        return $this->hasMany(CashReceipts::class, 'pelanggan_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'customer_id', 'id');
    }
}
