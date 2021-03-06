<?php

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tax::create([
            'nama_pajak' => 'PPN',
            'persentase_pajak' => 10,
            'pajak_ditiadakan' => 'Y'
        ]);
    }
}
