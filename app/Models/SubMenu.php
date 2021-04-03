<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'name', 'url', 'icon'];
    protected $hidden = ['created_at', 'updated_at'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function childSubMenus()
    {
        return $this->hasMany(ChildSubMenu::class, 'sub_menu_id', 'id');
    }

    public function roleAcceses()
    {
        return $this->hasMany(RoleAccess::class, 'sub_menu_id', 'id');
    }
}
