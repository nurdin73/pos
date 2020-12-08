<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembelianController extends Controller
{

    protected $pembelianService;
    public function __construct() {
        $this->pembelianService = app()->make('PembelianService');
    }

    public function getAll(Request $request)
    {
        $nama_barang = $request->input('nama_barang') != null  ? $request->input('nama_barang') : "";
        $sorting = $request->input('sorting') != null  ? $request->input('sorting') : 10;
        return $this->pembelianService->getAll($nama_barang, $sorting);
    }
}
