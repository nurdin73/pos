<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\GenerateCode;
use App\Http\Controllers\Controller;
use App\Models\Tax;
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

    public function return()
    {
        return view('admin.managements.return.index');
    }

    public function kategori()
    {
        return view('admin.managements.kategori.index');
    }

    public function suplier()
    {
        return view('admin.managements.suplier.index');
    }

    public function detailSuplier($id)
    {
        $data['id'] = $id;
        return view('admin.managements.suplier.detail', $data);
    }

    public function managementCabang()
    {
        return view('admin.managements.cabang.index');
    }

    public function detailCabang($id)
    {
        return view('admin.managements.cabang.detail', ['id' => $id]);
    }

    public function managementTransaksi()
    {
        $data['no_invoice'] = GenerateCode::invoice();
        $data['tax'] = Tax::find(1);
        return view('admin.managements.transaksi.index', $data);
    }

    public function listTransaksi()
    {
        return view('admin.managements.transaksi.list');
    }

    public function invoice($id)
    {
        return view('admin.managements.transaksi.invoice', ['id' => $id]);
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
    
    public function pajakBarang()
    {
        return view('admin.managements.pajak.barang');
    }

    public function pajakUniversal()
    {
        return view('admin.managements.pajak.universal');
    }

    public function managementStok()
    {
        return view('admin.managements.stok.managementStok');
    }

    public function managementStaff()
    {
        return view('admin.managements.staff.managementStaff');
    }

    public function loyalityProgram()
    {
        return view('admin.managements.loyality-program.index');
    }
}