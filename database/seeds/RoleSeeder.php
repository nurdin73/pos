<?php

namespace Database\Seeders;

use App\Models\RoleAccess;
use App\Models\Roles;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'administrator',
            'staff',
        ];
        for ($i=0; $i < count($roles); $i++) { 
            $create = Roles::create([
                'name' => $roles[$i]
            ]);
            RoleAccess::create([
                'role_id' => $create->id,
                'create' => $create->id == 1 ? 1 : 0,
                'read' => $create->id == 1 ? 1 : 0,
                'update' => $create->id == 1 ? 1 : 0,
                'delete' => $create->id == 1 ? 1 : 0 
            ]);
        }
    }
}
