<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'sub_menu_id', 'isGranted'];
    protected $hidden = ['created_at', 'updated_at'];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id', 'id');
    }

    public function submenu()
    {
        return $this->belongsTo(SubMenu::class, 'sub_menu_id', 'id');
    }
}
