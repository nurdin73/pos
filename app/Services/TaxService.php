<?php
namespace App\Services;

use App\Models\Tax;
use App\Models\Products;

class TaxService
{
    protected function getTax()
    {
        $results = Tax::with('product')->select('*');
        return $results;
    }

    public function getAll($nama, $paginate)
    {
        $results = $this->getTax();
        $results->orderBy('nama_pajak', 'ASC');
        if($nama != "") {
            $results = $results->where('nama_pajak', 'like', '%'.$nama.'%')->paginate($paginate);
        } else {
           $results = $results->paginate($paginate);
        }

        return response($results);
    }

    public function getDetail($id)
    {
        $result = Supliers::where('id', $id)->first();
        $result->setRelation('products', $result->products()->select('id', 'suplier_id', 'nama_barang', 'kode_barang', 'selled')->paginate(5));
        return response($result);
    }

    public function addTax($data)
    {
        $create = Tax::create($data);
        if(!$create) return response(['message' => 'Pajak gagal ditambahkan'], 500);
        return response(['message' => 'Pajak berhasil ditambahkan']);
    }

    public function updateSuplier($data, $id)
    {
        $checkSuplier = $this->getSuplier()->where('id', $id)->first();
        if(!$checkSuplier) return response(['message' => 'Data Suplier tidak ditemukan'], 404);
        $update = $checkSuplier->update($data);
        if(!$update) return response(['message' => 'Update Suplier tidak berhasil'], 500);
        return response(['message' => 'Update suplier berhasil']);
    }

    public function deleteTax($id)
    {
        $checkTax = $this->getTax()->where('id', $id)->first();
        if(!$checkTax) return response(['message' => 'Data Pajak tidak ditemukan'], 404);
        $delete = $checkTax->delete();
        if(!$delete) return response(['message' => 'Hapus Pajak tidak berhasil'], 500);
        return response(['message' => 'Hapus Pajak berhasil']);
    }
}