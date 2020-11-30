<?php
namespace App\Services;

use App\Models\Products;
use App\Models\Transactions;
use DateTime;

class DashboardService
{
    public function transactions()
    {
        $transactions = Transactions::with('carts.product.stocks')->get();
        $data = [
            'total_trx' => count($transactions),
        ];
        $data['total'] = 0;
        $data['keuntungan'] = 0;
        foreach ($transactions as $trx) {
            $data['total'] += $trx->total;
            $totalKeuntungan = 0;
            foreach ($trx->carts as $cart) {
                $harga_dasar = 0;
                foreach ($cart->product->stocks as $stock) {
                    $harga_dasar = $stock->harga_dasar;
                }
                $totalKeuntungan += ($trx->total)  - ($harga_dasar * $cart->qyt);
            }
            $data['keuntungan'] += $totalKeuntungan;
        }
        return response($data);
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
                    ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'tgl_transaksi', 'jam_transaksi')
                    ->where('tgl_transaksi', 'like', '%'.$y.'%')
                    ->get();
                    $sets[$y] = [];
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
                        array_push($sets[$y], $data);
                    }
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
                    ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'tgl_transaksi', 'jam_transaksi')
                    ->where('tgl_transaksi', 'like', '%'.$m.'%')
                    ->get();
                    $monthName = explode('-', $m);
                    $convertMonth = DateTime::createFromFormat('!m', $monthName[1]);
                    $nameMonth = $convertMonth->format('F');
                    $sets[$nameMonth] = [];
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
                        array_push($sets[$nameMonth], $data);
                    }
                }
                break;
            case 'years':
                for ($i=date('Y') - 2; $i <= date('Y') + 8; $i++) { 
                    $i = $i < 10 ? "0".$i : $i;
                    $labelTime[$i] = [];
                }
                foreach ($labelTime as $y => $value) {
                    $transactions = Transactions::with('carts.product.stocks')
                    ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'tgl_transaksi', 'jam_transaksi')
                    ->where('tgl_transaksi', 'like', '%'.$y.'%')
                    ->get();
                    $sets[$y] = [];
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
                        array_push($sets[$y], $data);
                    }
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
                    ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'tgl_transaksi', 'jam_transaksi')
                    ->where('tgl_transaksi', 'like', '%'.$y.'%')
                    ->get();
                    $sets[$y] = [];
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
                        array_push($sets[$y], $data);
                    }
                }
                break;
        }
        return $sets;
    }

    public function bestSeller($year)
    {
        $products = Products::where('selled', '>', 0)->select('id', 'nama_barang', 'type_barang', 'kode_barang', 'harga_jual', 'selled')->orderBy('selled', 'DESC')->limit(5)->get();
        return response($products);
    }

    public function newTransactions($year)
    {
        
    }
}