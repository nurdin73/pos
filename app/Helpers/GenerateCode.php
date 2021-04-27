<?php
namespace App\Helpers;

use App\Models\Products;
use App\Models\Transactions;
use Illuminate\Support\Facades\DB;

class GenerateCode 
{
    public static function kode()
    {
        $query = "SELECT MAX(SUBSTRING(kode_barang, 4, 9)) AS kode_barang FROM products";
        $checkKodeBarang = DB::select($query);
        $getCodeStore = env('KODE_TOKO', 'POS');
        $urutan = $checkKodeBarang[0]->kode_barang;
        $urutan++;
        $kode = sprintf("%09s", $urutan);
        return $getCodeStore.$kode;
        // return response($checkNoInvoice);
    }

    public static function invoice()
    {
        $date = date('ymd');
        $query = "SELECT MAX(SUBSTRING(no_invoice, 10, 5)) AS no_invoice FROM transactions WHERE SUBSTRING(no_invoice, 4, 6) = $date";
        $checkNoInvoice = DB::select($query);
        $getCodeStore = "INV";
        $urutan = (int)$checkNoInvoice[0]->no_invoice;
        $urutan++;
        $kode = sprintf("%05s", $urutan);
        return $getCodeStore.$date.$kode;
    }

    public static function generateId($char = "1234567890", $length = 10)
    {
        $charLength = strlen($char);
        $randStr = "";
        for ($i=0; $i < $length; $i++) { 
            $randStr .= $char[rand(0, $charLength - 1)];
        }
        return $randStr;
    }
}