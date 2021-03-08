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
        $totalModal = 0;
        $totalPembelian = 0;
        foreach ($transactions as $trx) {
            $totalPembelian += $trx->total;
            foreach ($trx->carts as $cart) {
                $harga_dasar = 0;
                foreach ($cart->product->stocks as $stock) {
                    $harga_dasar = $stock->harga_dasar;
                }
                $totalModal += $harga_dasar * $cart->qyt;
            }
        }
        $data['total'] = $totalPembelian;
        $data['keuntungan'] = $totalPembelian - $totalModal;
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
                            $earning = ($cart->harga_product - $cart->diskon_product) * $cart->qyt;
                            $cap = $harga_dasar * $cart->qyt;
                            $dataset[] = [
                                'modal' => $cap,
                                'pendapatan' => $earning,
                                'keuntungan' => $earning - $cap
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
                            $earning = ($cart->harga_product - $cart->diskon_product) * $cart->qyt;
                            $cap = $harga_dasar * $cart->qyt;
                            $dataset[] = [
                                'modal' => $cap,
                                'pendapatan' => $earning,
                                'keuntungan' => $earning - $cap
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
                            $earning = ($cart->harga_product - $cart->diskon_product) * $cart->qyt;
                            $cap = $harga_dasar * $cart->qyt;
                            $dataset[] = [
                                'modal' => $cap,
                                'pendapatan' => $earning,
                                'keuntungan' => $earning - $cap
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
                            $earning = ($cart->harga_product - $cart->diskon_product) * $cart->qyt;
                            $cap = $harga_dasar * $cart->qyt;
                            $dataset[] = [
                                'modal' => $cap,
                                'pendapatan' => $earning,
                                'keuntungan' => $earning - $cap
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

    public function bestSeller()
    {
        $products = Products::where('selled', '>', 10)->select('id', 'nama_barang', 'type_barang', 'kode_barang', 'harga_jual', 'selled')->orderBy('selled', 'DESC')->limit(5)->get();
        return response($products);
    }

    public function newTransactions()
    {
        $transactions = Transactions::with('customer')->orderBy('id', 'DESC')->limit(5)->get();
        return response($transactions);
    }
}