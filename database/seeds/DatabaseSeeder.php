<?php

use Database\Seeders\MenuSeeder;
use Database\Seeders\RoleAccessSeeder;
use Database\Seeders\TransactionSeeder;
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
            RoleAccessSeeder::class,
            ProductSeeder::class,
            // TransactionSeeder::class,
        ]);
    }
}
