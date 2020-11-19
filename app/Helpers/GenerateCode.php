<?php
namespace App\Helpers;

use App\Models\Products;
use App\Models\Transactions;

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
        $checkNoInvoice = Transactions::select('no_invoice')->max('no_invoice');
        $getCodeStore = "INVPOS";
        $explode = "";
        if($checkNoInvoice) {
            $lengthOfCode = strlen($getCodeStore);
            $explode = explode($getCodeStore[$lengthOfCode - 1], $checkNoInvoice);
        }
        $urutan = $explode != "" ? (int)$explode[1] : (int)$checkNoInvoice;
        $urutan++;
        $kode = sprintf("%06s", $urutan);
        return $getCodeStore.$kode;
    }
}