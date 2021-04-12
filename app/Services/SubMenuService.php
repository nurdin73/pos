<?php
namespace App\Services;

use App\Helpers\CreatePaginationLink;
use App\Models\RoleAccess;
use App\Models\SubMenu;

class SubMenuService
{
    public function getall($search, $role_id)
    {
        $results = SubMenu::select('*')->with(['roleAcceses' => function($q) use($role_id) {
            $q->where('role_id', $role_id);
        }]);
        // $results = RoleAccess::with('subMenu')->where('role_id', $role_id);
        if($search != "") {
            $results = $results->where('name', 'like', "%$search%")->get();
        } else {
            $results = $results->get();
        }
        return response($results);
    }
}