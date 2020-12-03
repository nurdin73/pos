<?php

namespace App\Http\Controllers\Api\Managements;

use App\Helpers\GenerateCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BarangController extends Controller
{
    protected $productsService;

    public function __construct() {
        $this->productsService = app()->make('ProductsService');
        if(!Auth::user()) {
            return response(['message' => 'not autorized'], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nama = $request->input('search_nama_barang');
        if($nama == null) {
            $nama = "";
        }
        $kode = $request->input('search_kode_barang');
        if($kode == null) {
            $kode = "";
        }
        $sorting = $request->input('sorting');
        if($sorting == null) {
            $sorting = 10;
        }
        // return $this->productsService->getAll();
        return $this->productsService->showAll($nama, $kode, $sorting);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|unique:products',
            'type_barang' => 'required',
            'stok' => 'required|numeric',
            'harga_dasar' => 'required',
            'harga_jual' => 'required',
            'kode_barang' => 'required'
        ]);

        // ----------------------------- //
        // Variable ------------------- //
        $satuan = $request->input('satuan');
        $type_barang = $request->input('type_barang');
        $nama_barang = $request->input('nama_barang');
        $stok = $request->input('stok');
        $harga_dasar = $request->input('harga_dasar');
        $harga_jual = $request->input('harga_jual');
        $berat = $request->input('berat');
        $diskon = $request->input('diskon');
        $rak = $request->input('rak');
        $keterangan = $request->input('keterangan');
        $kategori = $request->input('kategori');
        $kode_barang = $request->input('kode_barang');
        $suplier_id = $request->input('suplier_id');
        $point = $request->input('point');
        $files = $request->file('files');
        // ------------------------------- //
        if($satuan) {
            if($satuan != "gram" && $satuan != "pcs") {
                return response(['message' => 'value satuan tidak valid'], 406);
            }
        }
        if($type_barang) {
            if($type_barang != "baru" && $type_barang != "bekas") {
                return response(['message' => 'type barang tidak valid'], 406);
            }
        }
        if(!$files) return response(['message' => 'gada']);

        $data = [
            'suplier_id' => $suplier_id,
            'nama_barang' => $nama_barang,
            'type_barang' => $type_barang,
            'kode_barang' => $kode_barang,
            'harga_jual' => $harga_jual,
            'selled' => 0,
            'kategori_id' => $kategori,
            'berat' => $berat,
            'satuan' => $satuan,
            'diskon' => $diskon,
            'rak' => $rak,
            'keterangan' => $keterangan,
            'point' => $point
        ];
        $stocks = [
            'harga_dasar' => $harga_dasar,
            'stok' => $stok,
        ];
        $typeharga = [
            'typeHarga' => $request->input('typeHarga'),
            'data' => [
                'nama_agen' => $request->input('nama_agen'),
                'harga' => $request->input('harga'),
            ],
        ];
        return $this->productsService->addProduct($data, $files, $typeharga, $stocks);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->productsService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'type_barang' => 'required',
            'harga_jual' => 'required',
        ]);

        // ----------------------------- //
        // Variable ------------------- //
        $satuan = $request->input('satuan');
        $type_barang = $request->input('type_barang');
        $nama_barang = $request->input('nama_barang');
        $harga_jual = $request->input('harga_jual');
        $berat = $request->input('berat');
        $diskon = $request->input('diskon');
        $rak = $request->input('rak');
        $keterangan = $request->input('keterangan');
        $kategori = $request->input('kategori');
        $suplier_id = $request->input('suplier_id');
        $point = $request->input('point');
        // ------------------------------- //
        if($satuan) {
            if($satuan != "gram" && $satuan != "pcs") {
                return response(['message' => 'value satuan tidak valid'], 406);
            }
        }
        if($type_barang) {
            if($type_barang != "baru" && $type_barang != "bekas") {
                return response(['message' => 'type barang tidak valid'], 406);
            }
        }

        $data = [
            'suplier_id' => $suplier_id,
            'nama_barang' => $nama_barang,
            'type_barang' => $type_barang,
            'harga_jual' => $harga_jual,
            'kategori_id' => $kategori,
            'berat' => $berat,
            'satuan' => $satuan,
            'diskon' => $diskon,
            'rak' => $rak,
            'keterangan' => $keterangan,
            'point'     => $point
        ];
        return $this->productsService->updateProduct($data, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->productsService->deleteProduct($id);
    }

    public function detailTypePrice($id)
    {
        return $this->productsService->detailTypePrice($id);
    }

    public function addTypePrice(Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric',
            'nama_agen'  => 'required',
            'harga'      => 'required|numeric'
        ]);

        $data = [
            'product_id' => $request->input('product_id'),
            'nama_agen' => $request->input('nama_agen'),
            'harga' => $request->input('harga'),
        ];

        return $this->productsService->addTypePrice($data);
    }

    public function updateTypePrice(Request $request, $id)
    {
        $request->validate([
            'nama_agen'  => 'required',
            'harga'      => 'required|numeric'
        ]);

        $data = [
            'nama_agen' => $request->input('nama_agen'),
            'harga' => $request->input('harga'),
        ];

        return $this->productsService->updateTypePrice($data, $id);
    }

    public function deleteTypePrice($id)
    {
        return $this->productsService->deleteTypePrice($id);
    }
}
