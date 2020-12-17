<?php
namespace App\Services;

use App\Exports\PenjualanProductExport;
use App\Models\Products;
use App\Models\Transactions;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class PenjualanService
{
    public function getall($year, $type)
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
        if($type == "export") {
            $filename = 'Penjualan-'.Str::random(20). '.xlsx';
            return Excel::download(new PenjualanProductExport($monthset), $filename);
        } else {
            return response($monthset);
        }
    }
}