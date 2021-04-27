<?php
namespace App\Services;

use App\Models\Products;
use App\Models\Transactions;
use DateTime;

class DashboardService
{
    public function transactions()
    {
        $transactions = Transactions::select('no_invoice', 'total');
        $total = $transactions->sum('total');
        $data['total_trx'] = $transactions->count();
        $data['average'] = $data['total_trx'] > 0 ? round($total / $data['total_trx']) : 0;
        $data['total'] = $total;
        $data['keuntungan'] = $total - $transactions->sum('modal');
        return $data;
    }

    public function chartTransactions($time)
    {
        $labelTime = [];
        $sets = [];
        switch ($time) {
            case 'days':
                for ($i=1; $i <= 31; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $tgl = date('Y-m'). "-" .$i;
                    $labelTime[$tgl] = [];
                }
                foreach ($labelTime as $y => $value) {
                    $transactions = Transactions::with('carts.product.stocks')
                    ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'modal','tgl_transaksi', 'jam_transaksi')
                    ->where('tgl_transaksi', 'like', '%'.$y.'%');
                    $total = $transactions->sum('total');
                    $modal = $transactions->sum('modal');
                    $sets[$y] = [];
                    array_push($sets[$y], [
                        'modal' => $modal,
                        'pendapatan' => intval($total),
                        'keuntungan' => $total - $modal
                    ]);
                }
                break;
            
            case 'months':
                for ($i=1; $i <= 12; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $bln = date('Y')."-".$i;
                    $labelTime[$bln] = [];
                }
                foreach ($labelTime as $m => $value) {
                    $transactions = Transactions::with('carts.product.stocks')
                    ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'modal', 'tgl_transaksi', 'jam_transaksi')
                    ->where('tgl_transaksi', 'like', '%'.$m.'%');
                    $monthName = explode('-', $m);
                    $convertMonth = DateTime::createFromFormat('!m', $monthName[1]);
                    $nameMonth = $convertMonth->format('F');
                    $sets[$nameMonth] = [];
                    $total = $transactions->sum('total');
                    $modal = $transactions->sum('modal');
                    array_push($sets[$nameMonth], [
                        'modal' => $modal,
                        'pendapatan' => intval($total),
                        'keuntungan' => $total - $modal
                    ]);
                }
                break;
            case 'years':
                for ($i=date('Y') - 2; $i <= date('Y') + 8; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $labelTime[$i] = [];
                }
                foreach ($labelTime as $y => $value) {
                    $transactions = Transactions::with('carts.product.stocks')
                    ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'modal','tgl_transaksi', 'jam_transaksi')
                    ->where('tgl_transaksi', 'like', '%'.$y.'%');
                    $total = $transactions->sum('total');
                    $modal = $transactions->sum('modal');
                    $sets[$y] = [];
                    array_push($sets[$y], [
                        'modal' => $modal,
                        'pendapatan' => intval($total),
                        'keuntungan' => $total - $modal
                    ]);
                }
                break;
            
            default:
                for ($i=1; $i <= 31; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $tgl = date('Y-m'). "-" .$i;
                    $labelTime[$tgl] = [];
                }
                foreach ($labelTime as $y => $value) {
                    $transactions = Transactions::with('carts.product.stocks')
                    ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'modal','tgl_transaksi', 'jam_transaksi')
                    ->where('tgl_transaksi', 'like', '%'.$y.'%');
                    $total = $transactions->sum('total');
                    $modal = $transactions->sum('modal');
                    $sets[$y] = [];
                    array_push($sets[$y], [
                        'modal' => $modal,
                        'pendapatan' => intval($total),
                        'keuntungan' => $total - $modal
                    ]);
                }
                break;
        }
        return $sets;
    }

    public function bestSeller()
    {
        $products = Products::where('selled', '>', 10)->select('id', 'nama_barang', 'type_barang', 'harga_jual', 'selled')->orderBy('selled', 'DESC')->limit(5)->get();
        return response($products);
    }

    public function newTransactions()
    {
        $transactions = Transactions::with('customer')->orderBy('id', 'DESC')->limit(5)->get();
        return response($transactions);
    }
}