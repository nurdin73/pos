<?php

use App\Models\Customers;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customers::create([
            'nama' => 'Umum',
            'email' => 'umum@umum.com',
            'no_telp' => 0000,
            'alamat' => 'umum'
        ]);
    }
}
