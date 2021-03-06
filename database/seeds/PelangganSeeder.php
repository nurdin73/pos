<?php

use App\Models\CashReceipts;
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
        for ($i=0; $i < 30; $i++) { 
            $cs = Customers::create([
                'nik' => '1111222233334444',
                'nama' => 'sample '.$i,
                'email' => 'sample'.$i.'@gmail.com',
                'no_telp' => "1231-5434-234".$i,
                'alamat' => 'cirebon'
            ]);
            CashReceipts::create([
                'pelanggan_id' => $cs->id,
                'jumlah' => 5000,
                'tgl_kasbon' => date('Y-m-d H:i:s'),
                'jatuh_tempo' => '2020-12-23 00:00:00',
                'keterangan' => 'tes'
            ]);
        }
    }
}
