<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function submenus()
    {
        return $this->hasMany(SubMenu::class, 'menu_id', 'id');
    }
}
