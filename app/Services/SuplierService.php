<?php
namespace App\Services;

use App\Models\Supliers;

class SuplierService 
{
    protected function getSuplier()
    {
        $results = Supliers::with('products:id,kode_barang,nama_barang,suplier_id')->select('*');
        return $results;
    }

    public function getAll($nama, $paginate)
    {
        $results = $this->getSuplier();
        $results->orderBy('nama_suplier', 'ASC');
        if($nama != "") {
            $results = $results->where('nama_suplier', 'like', '%'.$nama.'%')->paginate($paginate);
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

    public function addSuplier($data)
    {
        $checkNamaSuplier = $this->getSuplier()->where('nama_suplier', $data['nama_suplier'])->first();
        if($checkNamaSuplier) return response(['message' => 'Nama suplier sudah ada'], 422);
        $create = Supliers::create($data);
        if(!$create) return response(['message' => 'Suplier gagal ditambahkan'], 500);
        return response(['message' => 'Suplier berhasil ditambahkan']);
    }

    public function updateSuplier($data, $id)
    {
        $checkSuplier = $this->getSuplier()->where('id', $id)->first();
        if(!$checkSuplier) return response(['message' => 'Data Suplier tidak ditemukan'], 404);
        $update = $checkSuplier->update($data);
        if(!$update) return response(['message' => 'Update Suplier tidak berhasil'], 500);
        return response(['message' => 'Update suplier berhasil']);
    }

    public function deleteSuplier($id)
    {
        $checkSuplier = $this->getSuplier()->where('id', $id)->first();
        if(!$checkSuplier) return response(['message' => 'Data Suplier tidak ditemukan'], 404);
        $delete = $checkSuplier->delete();
        if(!$delete) return response(['message' => 'Hapus Suplier tidak berhasil'], 500);
        return response(['message' => 'Hapus suplier berhasil']);
    }
}