<?php
namespace App\Services;

use App\Models\Categories;

class CategoriesService
{
    function getAll()
    {
        $results = Categories::select("id", "name")->orderBy('id', 'DESC')->get();
        return datatables()
        ->of($results)
        ->addIndexColumn()
        ->addColumn('actions', function($rows) {
            $rows = json_encode($rows);
            $rows = json_decode($rows);
            $id = $rows->id;
            $btn = "<div class='btn-group'>";
            $btn .= "<button class='btn btn-sm btn-info update' data-id='$id' data-toggle='modal' data-target='#updateCategoryModal'>Update</button>";
            $btn .= "<button class='btn btn-sm btn-danger delete' data-id='$id'>Delete</button>";
            $btn .= '</btn>';
            return $btn;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function update($data, $id)
    {
        $result = Categories::find($id);
        if(!$result) return response(['message' => 'terjadi kesalahan'], 500);
        $result->update([
            'name' => $data
        ]);
        return response(['message' => 'Update data berhasil']);
    }

    public function destroy($id)
    {
        $result = Categories::find($id);
        if(!$result) return response(['message' => 'terjadi kesalahan'], 500);
        $result->delete();
        return response(['message' => 'Hapus kategori berhasil']);
    }
}