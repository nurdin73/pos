<?php
namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;

class UtilsService 
{
    public function menus($userData)
    {

        $menus = Cache::rememberForever('menus:'. $userData->role_id, function () use($userData) {
            return Menu::with(['subMenus' => function($q) use($userData) {
                $q->with(['childSubMenus' => function($z) {
                    $z->select('id', 'url', 'name', 'sub_menu_id');
                }])->whereHas('roleAcceses', function($w) use($userData) {
                    $w->where('role_id', $userData->role_id)->where('isGranted', 1)->select('id', 'role_id', 'isGranted', 'sub_menu_id');
                })->select('id', 'name', 'icon', 'url', 'menu_id');
            }])->get(['id', 'name']);
        });
        return $menus;

    }
}