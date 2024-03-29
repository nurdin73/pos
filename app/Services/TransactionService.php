<?php
namespace App\Services;

use App\Exports\TransactionExport;
use App\Exports\TransaksiExport;
use App\Helpers\CreatePaginationLink;
use App\Helpers\PrintTrx;
use App\Models\Carts;
use App\Models\CodeProducts;
use App\Models\Customers;
use App\Models\PrinterSettings;
use App\Models\Products;
use App\Models\Stocks;
use App\Models\Transactions;
use App\Notifications\NotifyUserCompleteExport;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class TransactionService
{

    public function store($data)
    {
        // $queryForProd = Products::with('stocks')->where('kode_barang', $data['kode'])->first();
        $queryForProd = CodeProducts::with('product.stocks')->where('kode_barang', $data['kode'])->first();
        if(!$queryForProd) return response(['message' => 'kode produk tidak ditemukan'], 404);
        $data['product_id'] = $queryForProd->product_id;
        $sisaStok = 0;
        if(count($queryForProd->product->stocks) > 0) {
            foreach ($queryForProd->product->stocks as $stock) {
                $sisaStok += $stock->stok;
            }
        }
        if($sisaStok < 1) return response(['message' => 'stok barang ini sudah habis'], 403);
        $checkCart = Carts::where(['no_invoice' => $data['no_invoice'], 'product_id' => $queryForProd->product->id])->first();
        if($checkCart) {
            $discountProduct = $queryForProd->product->diskon !== null ? $checkCart->harga_product * ($queryForProd->product->diskon / 100) : 0;
            $discountBefore = $checkCart->diskon_product ?? 0;
            $data['diskon_product'] = ($discountBefore + $discountProduct) * $checkCart->qyt;
            // return $discountProduct;
        } else {
            $discountProduct = $queryForProd->product->diskon !== null ? $queryForProd->product->harga_jual * ($queryForProd->product->diskon / 100) : 0;
            $discountBefore = $checkCart->diskon_product ?? 0;
            $data['diskon_product'] = ($discountBefore + $discountProduct) * $data['qyt'];
            // return $discountProduct;
        }
        // return $checkCart;
        if($checkCart) {
            if($checkCart->qyt < $sisaStok) {
                $data['qyt'] = $checkCart->qyt + $data['qyt'];
                $checkCart->update([
                    'qyt' => $data['qyt']
                ]);
            } else {
                return response(['message' => 'jumlah quantity melebihi sisa stok'], 403);
            }
        } else {
            $data['harga_product'] = $queryForProd->product->harga_jual;
            $create = Carts::create($data);
        }
        return response(['message' => 'Pesanan berhasil ditambahkan', 'no_invoice' => $data['no_invoice']]);
    }

    public function changePrice($price, $id_cart, $eceran)
    {
        $cart = Carts::with('product')->find($id_cart);
        if(!$cart) return response(['message' => 'terjadi kesalahan. silahkan coba kembali'], 406);
        $discountProduct = ($cart->product->diskon / 100) * $price;
        $update = $cart->update([
            'harga_product' => $price,
            'diskon_product' => $discountProduct,
            'eceran' => $eceran ?? 0
        ]);
        if(!$update) return response(['message' => 'Harga gagal diupdate'], 406);
        return response(['message' => 'Harga berhasil diupdate']);
    }

    public function getCarts($no_invoice)
    {
        $results = Carts::with('product.stocks', 'product.typePrices')->where('no_invoice', $no_invoice)->select('id','product_id', 'qyt', 'harga_product', 'diskon_product')->get();
        return response($results);
    }

    public function add($data)
    {
        $data['tgl_transaksi'] = date('Y-m-d');
        $data['jam_transaksi'] = date('H') < 10 ? "0".date('H').":00:00" : date('H').":00:00";
        $returnQytProd = false;
        $totalPoint = 0;
        $checkCart = Carts::with('product.stocks')->where('no_invoice', $data['no_invoice'])->get();
        if(!$checkCart) return response(['message' => 'kerangjang masih kosong silahkan coba lagi'], 422);
        DB::beginTransaction();
        try {
            $modal = 0;
            foreach ($checkCart as $cc) {
                $totalPoint += $cc->product->point; // total point
                
                // check sisa stok

                $sisaStok = 0;
                $priceModalProduct = 0;
                if(count($cc->product->stocks)) {
                    foreach ($cc->product->stocks as $stock) {
                        $sisaStok += $stock->stok;
                        $priceModalProduct = $stock->harga_dasar;
                    }
                }

                
                // check jika stok nya cukup atau tidak
                
                if($cc->qyt > $sisaStok) {
                    $returnQytProd = true;
                } else {
                    if($cc->eceran == 1) {
                        $modal += $cc->qyt * $cc->product->harga_satuan;
                        $qyt = $cc->qyt;
                        $jumlahEceran = $cc->product->jumlah;
                        $penguranganStok = floor($qyt / $jumlahEceran);
                        $sisanya = null;
                        if($qyt <= $jumlahEceran) {
                            $sisanya = $jumlahEceran - $qyt;
                            if($sisanya == 0) {
                                Products::find($cc->product_id)->update([
                                    'jumlah' => $jumlahEceran
                                ]);
                            } else {
                                Products::find($cc->product_id)->update([
                                    'jumlah' => $sisanya
                                ]);
                            }
                        } else {
                            if($penguranganStok == 1) {
                                $sisanya = $qyt % $jumlahEceran;
                                $sisanya = $cc->product->jumlahEceranPermanent - $sisanya;
                            } else {
                                $jumlahEceran = $jumlahEceran * $penguranganStok;
                                $sisanya = $qyt % $jumlahEceran;
                            }

                            Products::find($cc->product_id)->update([
                                'jumlah' => $sisanya,
                                'selled' => $cc->product->selled + $penguranganStok
                            ]);
                            foreach ($cc->product->stocks as $stock) {
                                if($cc->qyt > $stock->stok) {
                                    $idStok = $stock->id;
                                    $penguranganStok -= $stock->stok;
                                    $stock->stok = 0;
                                    $update = Stocks::find($idStok)->delete();
                                } else {
                                    $idStok = $stock->id;
                                    $stock->stok -= $penguranganStok;
                                    $penguranganStok = 0;
                                    $update = Stocks::find($idStok)->update([
                                        'stok' => $stock->stok
                                    ]);
                                    break;
                                }
                            }
                        }
                    } else {
                        $modal += $priceModalProduct * $cc->qyt;
                        Products::find($cc->product_id)->update([
                            'selled' => $cc->product->selled + $cc->qyt
                        ]);
                        foreach ($cc->product->stocks as $stock) {
                            if($cc->qyt > $stock->stok) {
                                $idStok = $stock->id;
                                $cc->qyt -= $stock->stok;
                                $stock->stok = 0;
                                $update = Stocks::find($idStok)->delete();
                            } else {
                                $idStok = $stock->id;
                                $stock->stok -= $cc->qyt;
                                $cc->qyt = 0;
                                $update = Stocks::find($idStok)->update([
                                    'stok' => $stock->stok
                                ]);
                                break;
                            }
                        }
                    }
                }
            }
            if($returnQytProd == false) {
                $data['modal'] = $modal;
                $create = Transactions::create($data);
                if(!$create) return response(['message' => 'transaksi gagal ditambahkan'], 500);
                if($totalPoint > 0) {
                    $checkCust = Customers::find($data['customer_id']);
                    if($checkCust) {
                        $checkCust->update([
                            'point' => $checkCust->point + $totalPoint
                        ]);
                    }
                }
                // Print nota
                
                // $printTrx = new PrintTrx();
                // $printTrx->invoice($create->id);

                DB::commit();
                return response([
                    'message' => 'transaksi berhasil ditambahkan', 
                    'idTrx' => $create->id,
                    'kembalian' => $create->change
                ]);
            } else {
                return response(['message' => 'transaksi gagal ditambahkan'], 500);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['message' => $e->getMessage()], 500);
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
        $cart = Carts::with('product:id,nama_barang,harga_jual', 'product.typePrices')->where('id', $id)->first();
        if(!$cart) return response(['message' => 'terjadi kesalahan. silahkan coba kembali'], 500);
        return response($cart);
    }

    public function updateCart($data, $id)
    {
        $cart = Carts::find($id);
        if(!$cart) return response(['message' => 'terjadi kesalahan. silahkan coba kembali'], 500);
        $checkStok = Products::with('stocks')->where('id', $cart->product_id)->first();
        $sisaStok = 0;
        if(count($checkStok->stocks) > 0) {
            foreach ($checkStok->stocks as $stock) {
                $sisaStok += $stock->stok;
            }
        }
        // $diskonProduk = $checkStok->diskon != null ? $checkStok->harga_jual * ($checkStok->diskon / 100) : 0;
        // $totalHarga = $checkStok->harga_jual - $diskonProduk;
        if($data['qyt'] > $sisaStok) return response(['message' => 'jumlah barang melebihi batas. silahkan masukkan jumlah barang dibawah '.$sisaStok], 422);
        if($data['diskon_product'] > $cart->harga_product) return response(['message' => 'diskon yang dimasukkan melebihi total pembelian.'], 422);
        $update = $cart->update($data);
        if(!$update) return response(['message' => 'Keranjang gagal diupdate'], 500);
        return response(['message' => 'keranjang berhasil diupdate']);
    }

    public function transactions($hari)
    {
        $transactions = null;
        if($hari == "hari ini") {
            $date = date('Y-m-d');
            $transactions = Transactions::with('carts.product.stocks')
            ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'tgl_transaksi', 'jam_transaksi')
            ->where('tgl_transaksi', 'like', '%'.$date.'%')
            ->orderBy('jam_transaksi', 'ASC');
        } else {
            $date = date('Y-m-d', strtotime("-1 days"));
            $transactions = Transactions::with('carts.product.stocks')
            ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'tgl_transaksi', 'jam_transaksi')
            ->where('tgl_transaksi', 'like', '%'.$date.'%')
            ->orderBy('jam_transaksi', 'ASC');
        }
        $total = $transactions->sum('total');
        $data['total_trx'] = $transactions->count();
        $data['average'] = $data['total_trx'] > 0 ? round($total / $data['total_trx']) : 0;
        $data['total'] = $total;
        $data['keuntungan'] = $total - $transactions->sum('modal');
        return response($data);
    }

    public function getTrxPerHours($type = "graph")
    {
        $dataset = [];
        $date = date('Y-m-d');
        $jam = [
            "00:00:00" => [],
            "01:00:00" => [],
            "02:00:00" => [],
            "03:00:00" => [],
            "04:00:00" => [],
            "05:00:00" => [],
            "06:00:00" => [],
            "07:00:00" => [],
            "08:00:00" => [],
            "09:00:00" => [],
            "10:00:00" => [],
            "11:00:00" => [],
            "12:00:00" => [],
            "13:00:00" => [],
            "14:00:00" => [],
            "15:00:00" => [],
            "16:00:00" => [],
            "17:00:00" => [],
            "18:00:00" => [],
            "19:00:00" => [],
            "20:00:00" => [],
            "21:00:00" => [],
            "22:00:00" => [],
            "23:00:00" => [],
        ];
        $dataset = array_merge($dataset, $jam);
        foreach ($jam as $j => $val) {
            $transactions = Transactions::with('carts.product.stocks')
            ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'modal', 'tgl_transaksi', 'jam_transaksi')
            ->where('tgl_transaksi', 'like', '%'.$date.'%')
            ->where('jam_transaksi', 'like', '%'.$j.'%');
            $totaltransactions = $transactions->count();
            $totalModal = $transactions->sum('modal');
            $total = $transactions->sum('total');
            $keuntungan = $total - $totalModal;
            $dataset[$j] = [
                'totalTrx' => $totaltransactions,
                'totalKeuntungan' => $keuntungan,
                'totalPendapatan' => $total,
                'totalModal' => $totalModal
            ];
        }
        if($type == "export") {
            $fileName = "trx-hours-".date('ymd').".xlsx";
            return Excel::download(new TransactionExport($dataset), $fileName);
        } else {
            return response($dataset);
        }
    }

    public function getTrxPerDays($type = "graph")
    {
        $days = [];
        for ($i=1; $i <= 31; $i++) { 
            $i = $i < 10 ? "0".$i : $i;
            $tgl = date('Y-m'). "-" .$i;
            $days[$tgl] = [];
        }
        // $dataset = array_merge($dataset, $days);
        foreach ($days as $d => $value) {
            $transactions = Transactions::with('carts.product.stocks')
            ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'modal', 'tgl_transaksi', 'jam_transaksi')
            ->where('tgl_transaksi', $d);
            $totaltransactions = $transactions->count();
            $totalModal = $transactions->sum('modal');
            $total = $transactions->sum('total');
            $keuntungan = $total - $totalModal;
            $days[$d] = [
                'totalTrx' => $totaltransactions,
                'totalKeuntungan' => $keuntungan,
                'totalPendapatan' => $total,
                'totalModal' => $totalModal
            ];
        }
        if($type == "export") {
            $fileName = "trx-days-".date('ymd').".xlsx";
            return Excel::download(new TransactionExport($days), $fileName);
        } else {
            return response($days);
        }
    }

    public function getTrxPerMonth($type = "graph")
    {
        $month = [];
        for ($i=1; $i <= 12; $i++) { 
            $i = $i < 10 ? "0".$i : $i;
            $bln = date('Y')."-".$i;
            $month[$bln] = [];
        }
        foreach ($month as $m => $value) {
            $transactions = Transactions::with('carts.product.stocks')
            ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'modal', 'tgl_transaksi', 'jam_transaksi')
            ->where('tgl_transaksi', 'like', '%'.$m.'%');
            $totaltransactions = $transactions->count();
            $totalModal = $transactions->sum('modal');
            $total = $transactions->sum('total');
            $keuntungan = $total - $totalModal;
            $month[$m] = [
                'totalTrx' => $totaltransactions,
                'totalKeuntungan' => $keuntungan,
                'totalPendapatan' => $total,
                'totalModal' => $totalModal
            ];
        }
        if($type == "export") {
            $fileName = "trx-months-".date('ymd').".xlsx";
            return Excel::download(new TransactionExport($month), $fileName);
        } else {
            return $month;
        }
    }

    public function getTrxPerYear($type = "graph")
    {
        $years = [];
        for ($i=date('Y') - 2; $i <= date('Y') + 8; $i++) { 
            $i = $i < 10 ? "0".$i : $i;
            $years[$i] = [];
        }
        foreach ($years as $y => $value) {
            $transactions = Transactions::with('carts.product.stocks')
            ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'modal', 'tgl_transaksi', 'jam_transaksi')
            ->where('tgl_transaksi', 'like', '%'.$y.'%');
            $totaltransactions = $transactions->count();
            $totalModal = $transactions->sum('modal');
            $total = $transactions->sum('total');
            $keuntungan = $total - $totalModal;
            $years[$y] = [
                'totalTrx' => $totaltransactions,
                'totalKeuntungan' => $keuntungan,
                'totalPendapatan' => $total,
                'totalModal' => $totalModal
            ];
        }
        if($type == "export") {
            $fileName = "trx-year-".date('ymd').".xlsx";
            return Excel::download(new TransactionExport($years), $fileName);
        } else {
            return $years;
        }
    }

    public function listTransaksi($no_invoice, $sorting)
    {
        $results = Transactions::with('user', 'customer')->select("*")->orderBy('id', 'DESC');
        if($no_invoice != "") {
            $results = $results->where('no_invoice', 'like', '%'.$no_invoice.'%')->paginate($sorting);
        } else {
            $results = $results->paginate($sorting);
        }
        $results = new CreatePaginationLink($results->getCollection(), $results->links(), $results->currentPage());
        $results = $results->crafting();
        return $results;
    }

    public function invoice($id)
    {
        $result = Transactions::with('user:id,name', 'customer:id,nama', 'carts:id,no_invoice,qyt,harga_product,diskon_product,product_id', 'carts.product:id,nama_barang,harga_jual,harga_satuan')->where('id', $id)->first();
        if(!$result) return response(['message' => 'Invoice tidak ditemukan'], 404);
        return $result;
    }

    public function exportTransactions($years)
    {
        $results = Transactions::with('user:id,name', 'customer:id,nama')->where('tgl_transaksi', 'like', '%'.$years.'%')->get();
        $fileName = "transaksi-".$years.".xlsx";
        $path = "export/excel/";
        // (new TransaksiExport($results, $years))->store($path . $fileName, 'local')->chain([
        //     new NotifyUserCompleteExport(auth()->id, $fileName, $path . $fileName),
        // ]);
        (new TransaksiExport($results, $years))->queue($path . $fileName,'local')->chain([
            new NotifyUserCompleteExport(auth()->id(),$fileName, $path . $fileName),
        ])->onQueue('exports');

        return response(['message' => 'Export excel dijalankan. tunggu notifikasi selanjutnya']);
        // return Excel::download(new TransaksiExport($results, $years), $fileName);
    }

    public function cetakStruk($id)
    {
        $printerSetting = PrinterSettings::find(1);
        $printTrx = new PrintTrx($printerSetting);
        return $printTrx->invoice($id);
    }

    public function cancelTransaction($no_invoice)
    {
        $check = Carts::where('no_invoice', $no_invoice)->count();
        if($check > 0) {
            $delete = Carts::where('no_invoice', $no_invoice)->delete();
            if(!$delete) return response(['message' => 'Cancel order gagal'], 500);
            return response(['message' => 'cancel order berhasil']);
        } else {
            return response(['message' => 'keranjang masih kosong'], 422);
        }
    }

    public function exportPdfInvoice($id)
    {
        $nota = $this->invoice($id);
        $fileName = $nota->no_invoice . "-" . strtoupper(Str::random(4));
        $pdf = new Dompdf();
        $options = $pdf->getOptions();
        $options->isHtml5ParserEnabled(true);
        $pdf->setOptions($options);
        $pdf->loadHtml(view('exports.invoice', ['transactions' => $nota]));
        $pdf->render();
        $pdf->stream($fileName);
    }
}