<?php
namespace App\Services;

use App\Models\Stocks;

class StockService 
{
    public function updateStok($data, $id_product)
    {
        $stock = Stocks::where('product_id', $id_product)->orderBy('tgl_update', 'ASC')->first();
        $sisaStok = 0;
        if($data['method'] == "kurangi") {
            $sisaStok = $data['jumlah'] % $stock->stok;
        }
        $stokNew = null;
        if($sisaStok > 0) {
            $deleteStok = Stocks::find($stock->id)->delete();
            $stokNew = Stocks::where('product_id', $id_product)->orderBy('tgl_update', 'ASC')->first();
        }
        return response([
            'stokOld' => $stock,
            'stokNew' => $stokNew
        ]);
    }
}