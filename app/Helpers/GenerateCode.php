<?php
namespace App\Helpers;

use App\Models\Products;
use App\Models\Transactions;
use Illuminate\Support\Facades\DB;

class GenerateCode 
{
    public static function kode()
    {
        $checkKode = Products::select("*")->max('kode_barang');
        $getCodeStore = env('KODE_TOKO');
        $explode = "";
        if($checkKode) {
            $lengthOfCode = strlen($getCodeStore);
            $explode = explode($getCodeStore[$lengthOfCode - 1], $checkKode);
        }
        $urutan = $explode != "" ? (int)$explode[1] : (int)$checkKode;
        $urutan++;
        $kode = sprintf("%09s", $urutan);
        return $getCodeStore.$kode;
    }

    public static function invoice()
    {
        $date = date('ymd');
        $query = "SELECT MAX(MID(no_invoice, 10, 4)) AS no_invoice FROM transactions WHERE MID(no_invoice, 4, 6) = $date";
        $checkNoInvoice = DB::select($query);
        $getCodeStore = "INV";
        $urutan = (int)$checkNoInvoice[0]->no_invoice;
        $urutan++;
        $kode = sprintf("%04s", $urutan);
        return $getCodeStore.$date.$kode;
    }
}