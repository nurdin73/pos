<?php

namespace Database\Seeders;

use App\Models\RoleAccess;
use App\Models\Roles;
use App\Models\SubMenu;
use Illuminate\Database\Seeder;

class RoleAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Roles::all();
        $submenus = SubMenu::all();
        foreach ($roles as $role) {
            foreach ($submenus as $submenu) {
                RoleAccess::create([
                    'role_id' => $role->id,
                    'sub_menu_id' => $submenu->id
                ]);
            }    
        }
    }
}
