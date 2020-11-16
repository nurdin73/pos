<?php

use App\Models\CashReceipts;
use Illuminate\Database\Seeder;

class KasbonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            1000,
            2000,
            3000,
            4000,
            5000,
            6000,
            7000,
            8000,
            9000,
            10000,
            11000,
            12000,
        ];
        for ($i=0; $i < count($data); $i++) { 
            CashReceipts::create([
                'pelanggan_id' => 1,
                'jumlah' => $data[$i],
                'tgl_kasbon' => '2020-11-09 00:00:00',
                'jatuh_tempo' => '2020-11-16 00:00:00',
                'keterangan' => 'tes'
            ]);
        }
    }
}
