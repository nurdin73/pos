<?php
namespace App\Services;

use App\Models\Carts;
use App\Models\Products;
use App\Models\Transactions;

class TransactionService
{
    public function store($data)
    {
        $queryForProd = Products::find($data['product_id']);
        if($queryForProd->stok < 1) return response(['message' => 'stok barang ini sudah habis'], 406);
        $checkCart = Carts::where(['no_invoice' => $data['no_invoice'], 'product_id' => $data['product_id']])->first();
        if($checkCart) {
            $data['qyt'] = $checkCart->qyt + $data['qyt'];
            $checkCart->update([
                'qyt' => $data['qyt']
            ]);
        } else {
            $create = Carts::create($data);
        }
        return response(['message' => 'Pesanan berhasil ditambahkan', 'no_invoice' => $data['no_invoice']]);
    }

    public function getCarts($no_invoice)
    {
        $results = Carts::with('product:id,kode_barang,nama_barang,harga_jual')->where('no_invoice', $no_invoice)->select('id','product_id', 'qyt', 'diskon_product')->get();
        return response($results);
    }

    public function add($data)
    {
        $data['tgl_transaksi'] = date('Y-m-d H:i:s');
        $create = Transactions::create($data);
        $returnQytProd = false;
        if(!$create) return response(['message' => 'transaksi gagal ditambahkan'], 500);
        $checkCart = Carts::where('no_invoice', $create->no_invoice)->get();
        if($checkCart) {
            foreach ($checkCart as $cc) {
                $selled = $cc->qyt;
                $updateProduct = Products::find($cc->product_id);
                $selled += $updateProduct->selled;
                if($selled > $updateProduct->qyt) {
                    $returnQytProd = true;
                } else {
                    $updateProduct->update([
                        'selled' => $selled
                    ]);
                }
            }
        }
        if($returnQytProd == false) {
            return response(['message' => 'transaksi berhasil ditambahkan']);
        } else {
            return response(['message' => 'transaksi gagal ditambahkan'], 500);
        }
    }
}