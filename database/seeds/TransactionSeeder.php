<?php

namespace Database\Seeders;

use App\Helpers\GenerateCode;
use App\Models\Carts;
use App\Models\Products;
use App\Models\Stocks;
use App\Models\Transactions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10000; $i++) { 
            $total = 0;
            $cash = 0;
            $trx['no_invoice'] = GenerateCode::invoice();
            $trx['createdBy'] = 1;
            $trx['customer_id'] = 0;
            $trx['diskon_transaksi'] = 0;
            $trx['tgl_transaksi'] = date('Y-m-d');
            $trx['jam_transaksi'] = date('H') < 10 ? "0".date('H').":00:00" : date('H').":00:00";
            for ($x=1; $x < 3; $x++) { 
                $qyt = 1;
                $product = Products::with('stocks')->find($x);
                $cart['no_invoice'] = $trx['no_invoice'];
                $cart['product_id'] = $x;
                $cart['qyt'] = $qyt;
                $cart['harga_product'] = $product->harga_jual;
                $total += $qyt * $product->harga_jual;
                $cash += $qyt * $product->harga_jual;
                $cart['eceran'] = 0;
                $cart['diskon_product'] = 0;
                Carts::create($cart);
                $product->selled = $product->selled + $qyt;
                $update = $product->save();
                foreach ($product->stocks as $stock) {
                    if($qyt > $stock->stok) {
                        $idStok = $stock->id;
                        $qyt -= $stock->stok;
                        $stock->stok = 0;
                        $update = Stocks::find($idStok)->delete();
                    } else {
                        $idStok = $stock->id;
                        $stock->stok -= $qyt;
                        $qyt = 0;
                        $update = Stocks::find($idStok)->update([
                            'stok' => $stock->stok
                            ]);
                            break;
                        }
                    }
                }
                $trx['total'] = $total;
                $trx['cash'] = $cash;
                $trx['change'] = $cash - $total;
                $trx['pajak'] = (10 / 100) * $trx['total'];
            Transactions::create($trx);
        }

    }
}
