<?php
namespace App\Services;

use App\Helpers\CreatePaginationLink;
use App\Models\Staffs;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffService
{
    public function getall($search, $sorting)
    {
        $results = Staffs::select('*')->orderBy('id', 'DESC')->with('role');
        if($search != "") {
            $results = $results->whereHas('role', function($q) use($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhereHas('role', function($q) use($search) {
                $q->where('name', 'like', "%$search%");
            })->where('nama_staff', 'like', '%'.$search.'%')->orWhere('email', 'like', "%$search%")->orWhere('no_telp', 'like', "%$search%")->orWhere('alamat', 'like', "%$search%")->paginate($sorting);
        } else {
            $results = $results->paginate($sorting);
        }
        $convertPaginate = new CreatePaginationLink($results->getCollection(), $results->links(), $results->currentPage());
        return $convertPaginate->crafting();
    }

    public function add($req)
    {
        DB::beginTransaction();
        try {
            $create = Staffs::create($req);
            if(!$create) return response(['message' => 'Staff gagal ditambahkan'], 500);
            $createUser = User::create([
                'name' => $create->nama_staff,
                'email' => $create->email,
                'password' => bcrypt('password'),
                'role_id' => $create->role_id,
                'alamat' => $create->alamat
            ]);
            DB::commit();
            return response(['message' => 'Staff berhasil ditambahkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['message' => $e->getMessage()], 500);
        }
    }

    public function get($id)
    {
        $result = Staffs::where('id', $id)->with('role')->first();
        if(!$result) return response(['message' => 'Staff tidak ditemukan'], 404);
        return response($result);
    }

    public function update($req, $id)
    {
        $result = Staffs::find($id);
        if(!$result) return response(['message' => 'Staff tidak ditemukan'], 404);
        $update = $result->update($req);
        if(!$update) return response(['message' => 'Staff gagal diupdate'], 500);
        User::where('email', $result->email)->update([
            'role_id' => $req['role_id']
        ]);
        return response(['message' => 'Staff berhasil di update']);
    }

    public function destroy($id)
    {
        $result = Staffs::find($id);
        if(!$result) return response(['message' => 'Staff tidak ditemukan'], 404);
        $delete = $result->delete();
        if(!$delete) return response(['message' => 'Staff gagal dihapus'], 500);
        User::where('email', $result->email)->delete();
        return response(['message' => 'Staff berhasil dihapus']);
    }
}