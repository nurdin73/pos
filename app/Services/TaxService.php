<?php
namespace App\Services;

use App\Models\Tax;
use App\Models\Products;

class TaxService
{
    protected function getTax()
    {
        $results = Tax::select('*');
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
        $result = $this->getTax()->where('id', $id)->first();
        return response($result);
    }

    public function addTax($data)
    {
        $create = Tax::create($data);
        if(!$create) return response(['message' => 'Pajak gagal ditambahkan'], 500);
        return response(['message' => 'Pajak berhasil ditambahkan']);
    }

    public function updateTax($data, $id)
    {
        $checkTax = Tax::find($id);
        $update = null;
        if(!$checkTax) {
            $update = Tax::create($data);
        } else {
            $update = $checkTax->update($data);
        }
        if(!$update) return response(['message' => 'Update Pajak tidak berhasil'], 500);
        return response(['message' => 'Update Pajak berhasil']);
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