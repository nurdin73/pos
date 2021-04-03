<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildSubMenu extends Model
{
    use HasFactory;

    protected $fillable = ['sub_menu_id', 'name', 'url'];

    public function subMenu()
    {
        return $this->belongsTo(SubMenu::class, 'sub_menu_id', 'id');
    }
}
