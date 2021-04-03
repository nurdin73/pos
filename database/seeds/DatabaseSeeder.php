<?php

use Database\Seeders\MenuSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            Database\Seeders\RoleSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            // ProductSeeder::class
        ]);
    }
}
