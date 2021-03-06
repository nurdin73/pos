<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Demo',
            'email' => 'demo@demo.com',
            'password' => Hash::make("demo"),
            'role' => 'owner'
        ]);
    }
}
