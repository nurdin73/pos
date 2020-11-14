<?php
namespace App\Helpers;

use App\Models\Products;

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
        $kode = sprintf("%04s", $urutan);
        return $getCodeStore.date('ymd').$kode;
    }
}