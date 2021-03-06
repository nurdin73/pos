<?php
namespace App\Services;

use App\Exports\ModalExport;
use App\Helpers\CreatePaginationLink;
use App\Models\Products;
use App\Models\Stocks;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class StockService 
{
    public function updateStok($data, $id_product)
    {
        if($data['method'] == "tambah") {
            $create = Stocks::create([
                'product_id' => $id_product,
                'stok' => $data['jumlah'],
                'harga_dasar' => $data['harga_dasar'],
                'tgl_update' => date('Y-m-d H:i:s')
            ]);
            return response(['message' => 'Stok berhasil ditambahkan']);
        } else {
            $stocks = Stocks::where('product_id', $id_product)->orderBy('tgl_update', 'ASC')->get();
            foreach ($stocks as $stock) {
                if($data['jumlah'] > $stock->stok) {
                    $data['id_stok'] = $stock->id;
                    $data['jumlah'] -= $stock->stok;
                    $stock->stok = 0;
                    $data['sisa'] = $stock->stok;
                    $update = Stocks::find($data['id_stok'])->delete();
                } else {
                    $data['id_stok'] = $stock->id;
                    $stock->stok -= $data['jumlah'];
                    $data['jumlah'] = 0;
                    $data['sisa'] = $stock->stok;
                    $update = Stocks::find($data['id_stok'])->update([
                        'stok' => $data['sisa']
                    ]);
                    break;
                }
            }
            return response(['message' => 'Stok berhasil dikurangi']);
        }
    }

    public function listStok($product_id)
    {
        $stocks = Stocks::where('product_id', $product_id)->select('id', 'stok', 'harga_dasar', 'tgl_update')->get();
        return response($stocks);
    }

    public function detail($id)
    {
        $stock = Stocks::where('id', $id)->select('id', 'stok', 'harga_dasar')->first();
        if(!$stock) return response(['message' => 'Stok tidak ditemukan'], 404);
        return response($stock);
    }

    public function update($data, $id)
    {
        $stok = Stocks::find($id);
        if(!$stok) return response(['message' => 'Stok tidak ditemukan'], 404);
        $data['tgl_update'] = date('Y-m-d H:i:s');
        $update = $stok->update($data);
        if(!$update) return response(['message' => 'Histori gagal diupdate'], 500);
        return response(['message' => 'Histori berhasil diupdate']);
    }

    public function destroy($id)
    {
        $stok = Stocks::find($id);
        if(!$stok) return response(['message' => 'Stok tidak ditemukan'], 404);
        $delete = $stok->delete();
        if(!$delete) return response(['message' => 'Histori gagal dihapus'], 500);
        return response(['message' => 'Histori berhasil di hapus']);
    }

    public function modal()
    {
        $totalModal = 0;
        $countModal = Stocks::select('stok', 'harga_dasar')->get();
        $modal = [];
        foreach ($countModal as $cm) {
            $modal[] = $cm->stok * $cm->harga_dasar;
        }
        for ($i=0; $i < count($modal); $i++) { 
            $totalModal += $modal[$i];
        }
        $stocks = Stocks::with('product:id,nama_barang')->select('id', 'product_id', 'stok', 'harga_dasar', 'tgl_update')->paginate(5);
        $dataBarang = new CreatePaginationLink($stocks->getCollection(), $stocks->links(), $stocks->currentPage());
        $createPaginate = $dataBarang->crafting();
        $resultModal = collect([
            'total_modal' => $totalModal,
            'modal'        => $createPaginate
        ]);
        // $results = $resultModal->merge($createPaginate);
        return $resultModal;
    }

    public function export()
    {
        $totalModal = 0;
        $countModal = Stocks::select('stok', 'harga_dasar')->get();
        $modal = [];
        foreach ($countModal as $cm) {
            $modal[] = $cm->stok * $cm->harga_dasar;
        }
        for ($i=0; $i < count($modal); $i++) { 
            $totalModal += $modal[$i];
        }
        $stocks = Stocks::with('product:id,nama_barang')->select('id', 'product_id', 'stok', 'harga_dasar', 'tgl_update')->get();
        $resultModal = collect([
            'total_modal' => $totalModal,
            'modal'        => $stocks
        ]);
        // $results = $resultModal->merge($createPaginate);
        $filename = 'Modal-'. Str::random(20) . '.xlsx';
        return Excel::download(new ModalExport($resultModal), $filename);
    }
}