<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staffs extends Model
{
    protected $fillable = ['email', 'nama_staff', 'no_telp', 'role_id', 'alamat'];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id', 'id');
    }
}
