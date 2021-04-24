<?php

use App\Helpers\GenerateCode;
use App\Models\Categories;
use App\Models\CodeProducts;
use App\Models\Products;
use App\Models\Stocks;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Categories::create([
            'name' => 'tes',
            'alias' => 'tes'
        ]);
        for ($i=301; $i < 500; $i++) { 
            $product = Products::create([
                'nama_barang' => 'produk '.$i,
                'alias_name' => Str::of('produk '.$i)->slug(),
                'type_barang' => 'baru',
                'harga_jual'  => 2000,
                'selled'        => 0,
                'kategori_id' => $category->id
            ]);
            $kodebarang = CodeProducts::create([
                'product_id' => $product->id,
                'kode_barang' => "COBA00".$i,
            ]);
            $stock = Stocks::create([
                'stok' => 10000,
                'product_id' => $product->id,
                'harga_dasar' => 1500,
                'tgl_update' => Carbon::now()
            ]);
        }
    }
}
