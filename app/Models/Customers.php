<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $fillable = ['nama', 'email', 'no_telp', 'alamat'];

    public function cashReceipts()
    {
        return $this->hasMany(CashReceipts::class, 'id', 'id');
    }
}
