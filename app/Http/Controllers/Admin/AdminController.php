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
        return view('admin.managements.kategori');
    }

    public function managementStok()
    {
        return view('admin.managements.managementStok');
    }

    public function pelanggan()
    {
        return view('admin.managements.pelanggan');
    }

    public function kasbon()
    {
        return view('admin.managements.kasbon');
    }
    
    public function pajak()
    {
        return view('admin.managements.pajak');
    }
}