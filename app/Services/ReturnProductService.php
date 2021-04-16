<?php
namespace App\Services;

use App\Helpers\CreatePaginationLink;
use App\Models\ReturnProduct;

class ReturnProductService
{
    public function getall($search, $sorting)
    {
        $results = ReturnProduct::with('product')->select('product_id', 'qyt', 'status');
        if($search != "") {
            $results = $results->whereHas('product', function($q) use($search) {
                $q->where('nama_barang', 'like', "%$search%")->select('id', 'nama_barang');
            })->paginate($sorting);
        } else {
            $results = $results->paginate($sorting);
        }
        $createPaginate = new CreatePaginationLink($results->getCollection(), $results->links(), $results->currentPage());
        return $createPaginate->crafting();
    }

    public function get($id)
    {
        $result = ReturnProduct::with('product:id,nama_barang')->findOrFail($id);
        return $result;
    }

    public function add($req)
    {
        $create = ReturnProduct::create($req);
        return response(['message' => 'return barang berhasil ditambahkan']);
    }

    public function update($req, $id)
    {
        $update = ReturnProduct::findOrFail($id);
        $update = $update->update($req);
        return response(['message' => 'return barang berhasil diupdate']);
    }

    public function destroy($id)
    {
        $delete = ReturnProduct::select('id')->findOrFail($id);
        $delete = $delete->delete();
        return response(['message' => 'Return barang berhasil dihapus']);
    }

    public function updateStatus($status, $id)
    {
        $check = ReturnProduct::select('id', 'status')->findOrFail($id);
        $check = $check->update([
            'status' => $status
        ]);
        return response(['message' => "status return diupdate"]);
    }
}