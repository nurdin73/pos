<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.umum');
    }

    public function transaksi()
    {
        return view('admin.report.transaksi');
    }

    public function penjualan()
    {
        return view('admin.report.penjualan');
    }

    public function pembelian()
    {
        return view('admin.report.pembelian.index');
    }
    
    public function barang()
    {
        return view('admin.report.barang.index');
    }

    public function modal()
    {
        return view('admin.report.modal');
    }

    public function pajak()
    {
        return view('admin.report.pajak.index');
    }

    public function reportPelanggan()
    {
        return view('admin.report.pelanggan.index');
    }

    public function reportKasbon()
    {
        return view('admin.report.kasbon.index');
    }

    public function cetakStruk(Request $request)
    {
        $isi = $request->input('isi');
        $noInv = $request->input('noInv');
        $data['isi'] = $isi;
        $data['noInv'] = $noInv;
        return view('exports.nota', $data);
    }
}
