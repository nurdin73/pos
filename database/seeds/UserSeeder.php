<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Nurdin',
            'email' => 'nurdin@telering.co.id',
            'password' => Hash::make("password"),
            'role' => 'owner'
        ]);
    }
}
