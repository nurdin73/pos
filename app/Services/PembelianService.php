<?php
namespace App\Services;

use App\Exports\PembelianProductExport;
use App\Helpers\CreatePaginationLink;
use App\Models\Products;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class PembelianService
{
    public function getAll($nama_barang, $sorting)
    {
        $results = Products::with('stocks:id,product_id,stok,harga_dasar,created_at') ->select('id', 'nama_barang', 'selled');
        if($nama_barang != "") {
            $results = $results->where('nama_barang', 'like', '%'.$nama_barang.'%')->paginate($sorting);
        } else {
            $results = $results->paginate($sorting);
        }
        $data = new CreatePaginationLink($results->getCollection(), $results->links(), $results->currentPage());
        return $data->crafting();
    }

    public function export()
    {
        $results = Products::with('stocks:id,product_id,stok,harga_dasar,created_at')->select('id', 'nama_barang', 'selled')->get();
        $filename = 'Pembelian-'. Str::random(20) . '.xlsx';
        return Excel::download(new PembelianProductExport($results), $filename);
    }
}