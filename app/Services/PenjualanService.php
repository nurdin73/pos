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
            ->select('id', 'no_invoice', 'diskon_transaksi', 'total', 'modal', 'tgl_transaksi', 'jam_transaksi')
            ->where('tgl_transaksi', 'like', '%'.$m.'%');
            $monthName = explode('-', $m);
            $convertMonth = DateTime::createFromFormat('!m', $monthName[1]);
            $nameMonth = $convertMonth->format('F');
            $monthset[$nameMonth] = [];
            $total = $transactions->sum('total');
            $modal = $transactions->sum('modal');
            $monthset[$nameMonth] = [
                'pendapatan' => intval($total),
                'keuntungan' => $total - $modal,
                'modal' => $modal,
            ];
        }
        if($type == "export") {
            $filename = 'Penjualan-'.Str::random(20). '.xlsx';
            return Excel::download(new PenjualanProductExport($monthset), $filename);
        } else {
            return response($monthset);
        }
    }
}