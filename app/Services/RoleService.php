<?php
namespace App\Services;

use App\Helpers\CreatePaginationLink;
use App\Models\Roles;

class RoleService
{
    public function getall($search, $sorting)
    {
        $results = Roles::select('id','name');
        if($search != "") {
            $results = $results->where('name', 'like', "%$search%")->paginate($sorting);
        } else {
            $results = $results->paginate($sorting);
        }
        $paginate = new CreatePaginationLink($results->getCollection(), $results->links(), $results->currentPage());
        return $paginate->crafting();
    }

    public function add($name)
    {
        $create = Roles::create([
            'name' => $name
        ]);
        if(!$create) return response(['message' => 'jabatan gagal ditambahkan'], 500);
        return response(['message' => 'jabatan berhasil ditambahkan']);
    }

    public function update($name, $id)
    {
        $update = Roles::find($id)->update([
            'name' => $name
        ]);
        if(!$update) return response(['message' => 'jabatan gagal diupdate'], 500);
        return response(['message' => 'jabatan berhasil diupdate']);
    }

    public function get($id)
    {
        return response(Roles::find($id));
    }

    public function destroy($id)
    {
        $delete = Roles::find($id)->delete();
        if(!$delete) return response(['message' => 'jabatan gagal dihapus'], 500);
        return response(['message' => 'jabatan berhasil dihapus']);
    }
}