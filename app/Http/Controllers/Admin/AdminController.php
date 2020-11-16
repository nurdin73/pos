<?php

namespace App\Http\Controllers\Admin;

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
        $data['id'] = decrypt($id);
        return view('admin.managements.barang.edit', $data);
    }

    public function detailProduct($id)
    {
        $data['id'] = decrypt($id);
        return view('admin.managements.barang.detail', $data);
    }

    public function kategori()
    {
        return view('admin.managements.kategori.index');
    }

    public function managementStok()
    {
        return view('admin.managements.managementStok');
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

    public function bayarKasbon($id)
    {
        $data['id'] = $id;
        return view('admin.managements.kasbon.bayar', $data);
    }
    
    public function pajak()
    {
        return view('admin.managements.pajak');
    }
}