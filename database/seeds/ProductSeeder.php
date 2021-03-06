<?php

use App\Helpers\GenerateCode;
use App\Models\Products;
use App\Models\Stocks;
use Carbon\Carbon;
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
        for ($i=0; $i < 300; $i++) { 
            $product = Products::create([
                'nama_barang' => 'produk '.$i,
                'type_barang' => 'baru',
                'kode_barang' => "COBA00".$i,
                'harga_jual'  => 2000,
                'selled'        => 0,
                'kategori_id' => 1
            ]);
            $stock = Stocks::create([
                'stok' => 100,
                'product_id' => $product->id,
                'harga_dasar' => 1500,
                'tgl_update' => Carbon::now()
            ]);
        }
    }
}
