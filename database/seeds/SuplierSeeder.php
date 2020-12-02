<?php

use App\Models\Supliers;
use Illuminate\Database\Seeder;

class SuplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 20; $i++) { 
            Supliers::create([
                'nama_suplier' => 'CV coba ' . $i,
                'email' => 'email@email.com',
                'no_telp' => '093722364234',
                'alamat' => 'cirebon'
            ]);
        }
    }
}
