<?php
namespace App\Services;

use App\Models\BranchStores;

class BranchStoreService
{
    public function getAll($nama_cabang, $sorting)
    {
        $results = BranchStores::select('id', 'nama_cabang', 'no_telp', 'alamat');
        $results->orderBy('nama_cabang', 'ASC');
        if($nama_cabang != "") {
            $results = $results->where('nama_cabang', 'like', '%'.$nama_cabang.'%')->paginate($sorting);
        } else {
            $results = $results->paginate($sorting);
        }
        return response($results);
    }

    public function show($id)
    {
        $result = BranchStores::find($id);
        if(!$result) return response(['message' => 'Cabang tidak ditemukan'], 404);
        return response($result);
    }

    public function add($data)
    {
        $create = BranchStores::create($data);
        if(!$create) return response(['message' => 'Cabang gagal ditambahkan'], 500);
        return response(['message' => 'Cabang berhasil ditambahkan']);
    }

    public function update($data, $id)
    {
        $result = BranchStores::find($id);
        if(!$result) return response(['message' => 'Cabang tidak ditemukan'], 404);
        $update = $result->update($data);
        if(!$update) return response(['message' => 'Cabang gagal diperbarui'], 500);
        return response(['message' => 'Cabang berhasil diperbarui']);
    }

    public function delete($id)
    {
        $result = BranchStores::find($id);
        if(!$result) return response(['message' => 'Cabang tidak ditemukan'], 404);
        $delete = $result->delete();
        if(!$delete) return response(['message' => 'Cabang gagal dihapus'], 500);
        return response(['message' => 'Cabang berhasil dihapus']);
    }
}