<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\GenerateCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function barang()
    {
        return view('admin.managements.barang.index');
    }

    public function editProduct($id)
    {
        $data['id'] = $id;
        return view('admin.managements.barang.edit', $data);
    }

    public function detailProduct($id)
    {
        $data['id'] = $id;
        return view('admin.managements.barang.detail', $data);
    }

    public function kategori()
    {
        return view('admin.managements.kategori.index');
    }

    public function managementTransaksi()
    {
        $data['no_invoice'] = GenerateCode::invoice();
        return view('admin.managements.transaksi.index', $data);
    }

    public function pelanggan()
    {
        return view('admin.managements.customer.index');
    }

    public function kasbon()
    {
        return view('admin.managements.kasbon.index');
    }

    public function addKasbon()
    {
        return view('admin.managements.kasbon.add');
    }

    public function payment($id, $id_kasbon)
    {
        $data['id_kasbon'] = $id_kasbon;
        return view('admin.managements.kasbon.payment-next', $data);
    }

    public function bayarKasbon($id)
    {
        $data['id'] = $id;
        return view('admin.managements.kasbon.bayar', $data);
    }
    
    public function pajak()
    {
        return view('admin.managements.pajak');
    }

    public function managementStok()
    {
        return view('admin.managements.managementStok');
    }
}