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
        $returnQytProd = false;
        $checkCart = Carts::where('no_invoice', $data['no_invoice'])->get();
        if($checkCart) {
            foreach ($checkCart as $cc) {
                $updateProduct = Products::find($cc->product_id);
                $sisaStok = $updateProduct->stok - $updateProduct->selled;
                if($cc->qyt > $sisaStok) {
                    $returnQytProd = true;
                } else {
                    $updateProduct->update([
                        'selled' => $updateProduct->selled + $cc->qyt
                    ]);
                }
            }
        }
        if($returnQytProd == false) {
            $create = Transactions::create($data);
            if(!$create) return response(['message' => 'transaksi gagal ditambahkan'], 500);
            return response(['message' => 'transaksi berhasil ditambahkan']);
        } else {
            return response(['message' => 'transaksi gagal ditambahkan'], 500);
        }
    }

    public function delete($id)
    {
        $check = Carts::find($id);
        if(!$check) return response(['message' => 'terjadi kesalahan. silahkan coba kembali'], 406);
        $delete = $check->delete();
        if(!$delete) return response(['message' => 'terjadi kesalahan. silahkan coba kembali'], 500);
        return response(['message' => 'Keranjang berhasil dihapus']);
    }

    public function detailCart($id)
    {
        $cart = Carts::with('product:id,kode_barang,nama_barang,harga_jual')->where('id', $id)->first();
        if(!$cart) return response(['message' => 'terjadi kesalahan. silahkan coba kembali'], 406);
        return response($cart);
    }

    public function updateCart($data, $id)
    {
        $cart = Carts::find($id);
        if(!$cart) return response(['message' => 'terjadi kesalahan. silahkan coba kembali'], 406);
        $checkStok = Products::find($cart->product_id);
        $sisaStok = $checkStok->stok - $checkStok->selled;
        if($data['qyt'] > $sisaStok) return response(['message' => 'jumlah barang melebihi batas. silahkan masukkan jumlah barang dibawah '.$sisaStok], 406);
        $update = $cart->update($data);
        if(!$update) return response(['message' => 'Keranjang gagal diupdate'], 500);
        return response(['message' => 'keranjang berhasil diupdate']);
    }

    public function transactions($hari)
    {
        if($hari == "hari ini") {
            $date = date('Y-m-d');
            $transactions = Transactions::with('carts.product:id,harga_dasar,harga_jual,selled')
            ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'tgl_transaksi')
            ->where('tgl_transaksi', 'like', '%'.$date.'%')->get();
            return $transactions;
        } else {
            $date = date('Y-m-d', strtotime("-1 days"));
            $transactions = Transactions::with('carts.product:id,harga_dasar,harga_jual,selled')
            ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'tgl_transaksi')
            ->where('tgl_transaksi', 'like', '%'.$date.'%')->get();
            return $transactions;
        }
    }
}