<?php

use App\Helpers\GenerateCode;
use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 40; $i++) { 
            Products::create([
                'nama_barang' => 'produk '.$i,
                'type_barang' => 'baru',
                'kode_barang' => GenerateCode::kode(),
                'harga_dasar' => 1000,
                'harga_jual'  => 2000,
                'stok'        => 100,
                'selled'        => 0,
                'kategori_id' => 1
            ]);
        }
    }
}
