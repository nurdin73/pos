<?php
namespace App\Services;

use App\Models\Stocks;

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
        $stocks = Stocks::where('product_id', $product_id)->select('id', 'stok', 'harga_dasar', 'tgl_update')->paginate(5);
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
}