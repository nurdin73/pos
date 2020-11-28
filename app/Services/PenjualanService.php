<?php
namespace App\Services;

use App\Models\Products;
use App\Models\Transactions;
use DateTime;

class PenjualanService
{
    public function getall($year)
    {
        $month = [];
        $monthset = [];
        for ($i=1; $i <= 12; $i++) { 
            $i = $i < 10 ? "0".$i : $i;
            $bln = $year."-".$i;
            $month[$bln] = [];
        }
        foreach ($month as $m => $value) {
            $transactions = Transactions::with('carts.product.stocks')
            ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'tgl_transaksi', 'jam_transaksi')
            ->where('tgl_transaksi', 'like', '%'.$m.'%')
            ->get();
            $monthName = explode('-', $m);
            $convertMonth = DateTime::createFromFormat('!m', $monthName[1]);
            $nameMonth = $convertMonth->format('F');
            $monthset[$nameMonth] = [];
            foreach ($transactions as $trx) {
                $dataset = [];
                foreach ($trx->carts as $cart) {
                    $harga_dasar = 0;
                    foreach ($cart->product->stocks as $stock) {
                        $harga_dasar = $stock->harga_dasar;
                    }
                    $dataset[] = [
                        'modal' => $harga_dasar * $cart->qyt,
                        'pendapatan' => $trx->total,
                        'keuntungan' => ($trx->total) - ($harga_dasar * $cart->qyt)
                    ];
                }
                $modal = 0;
                $pendapatan = 0;
                $keuntungan = 0;
                foreach ($dataset as $data) {
                    $modal += $data['modal'];
                    $pendapatan += $data['pendapatan'];
                    $keuntungan += $data['keuntungan'];
                }
                $data = [
                    'modal' => $modal,
                    'pendapatan' => $pendapatan,
                    'keuntungan' => $keuntungan,
                ];
                array_push($monthset[$nameMonth], $data);
            }
        }
        // $data = [];
        // $transactions = Transactions::with('carts.product.stocks')->get();
        // $products = Products::with('stocks:id,product_id,harga_dasar')->select('id', 'selled', 'harga_jual')->get();
        // foreach ($products as $p) {
        //     $harga_dasar = 0;
        //     foreach ($p->stocks as $s) {
        //         $harga_dasar = $s->harga_dasar;
        //     }
        //     $data[] = [
        //         'modal' => $harga_dasar * $p->selled,
        //         'pendapatan' => $p->harga_jual * $p->selled,
        //         'keuntungan' => ($p->harga_jual * $p->selled) - ($harga_dasar * $p->selled)
        //     ];
        // }
        return response($monthset);
    }
}