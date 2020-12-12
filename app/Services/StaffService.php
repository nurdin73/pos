<?php
namespace App\Services;

use App\Models\Staffs;
use Illuminate\Support\Facades\Hash;

class StaffService
{
    public function getall($nama, $sorting)
    {
        $results = Staffs::select('*')->orderBy('id', 'DESC');
        if($nama != "") {
            $results = $results->where('nama_staff', 'like', '%'.$nama.'%')->paginate($sorting);
        } else {
            $results = $results->paginate($sorting);
        }
        return response($results);
    }

    public function add($req)
    {
        $req['password'] = Hash::make($req['password']);
        $create = Staffs::create($req);
        if(!$create) return response(['message' => 'Staff gagal ditambahkan'], 500);
        return response(['message' => 'Staff berhasil ditambahkan']);
    }

    public function get($id)
    {
        $result = Staffs::find($id);
        if(!$result) return response(['message' => 'Staff tidak ditemukan'], 404);
        return response($result);
    }

    public function update($req, $id)
    {
        $result = Staffs::find($id);
        if(!$result) return response(['message' => 'Staff tidak ditemukan'], 404);
        $update = $result->update($req);
        if(!$update) return response(['message' => 'Staff gagal diupdate'], 500);
        return response(['message' => 'Staff berhasil di update']);
    }

    public function destroy($id)
    {
        $result = Staffs::find($id);
        if(!$result) return response(['message' => 'Staff tidak ditemukan'], 404);
        $delete = $result->delete();
        if(!$delete) return response(['message' => 'Staff gagal dihapus'], 500);
        return response(['message' => 'Staff berhasil dihapus']);
    }
}