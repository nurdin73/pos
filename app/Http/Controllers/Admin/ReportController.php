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
        return view('admin.report.pembelian');
    }

    public function modal()
    {
        return view('admin.report.modal');
    }

    public function pajak()
    {
        return view('admin.report.pajak');
    }

    public function pengunjung()
    {
        return view('admin.report.pengunjung');
    }
}
