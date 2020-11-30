<?php
namespace App\Services;

use App\Models\FileProducts;
use App\Models\Products;
use App\Models\Stocks;
use App\Models\TypePrices;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class ProductsService
{
    public function getAll()
    {
        $results = Products::select('id', 'nama_barang', 'kode_barang', 'harga_jual')->get();
        return datatables()->of($results)
                ->addIndexColumn()
                ->addColumn('actions', function($row) {
                    $row = json_encode($row);
                    $row = json_decode($row);
                    $url = url('admin');
                    $id = $row->id;
                    $btn = "<div class='btn-group'>";
                    $btn .= "<a href=".$url . "/management/barang/edit/". encrypt($id) ." class='btn btn-info btn-sm'>Update</a>";
                    $btn .= "<a href=".$url . "/management/barang/detail/". encrypt($id) ." class='btn btn-primary btn-sm'>Detail</a>";
                    $btn .= "<button class='btn btn-sm btn-danger delete' data-id=". encrypt($id) .">Delete</button>";
                    $btn .= "</div>";
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
    }

    public function showAll($nama, $kode, $sorting)
    {
        $results = Products::with('stocks') ->select('id', 'nama_barang', 'kode_barang', 'harga_jual', 'selled');
        $results->orderBy('kode_barang', 'ASC');
        if($nama != "") {
            if($kode != "") {
                $results = $results->where('kode_barang', 'like', '%'.$kode.'%')->where('nama_barang', 'like', '%'.$nama.'%')->paginate($sorting);
            } else {
                $results = $results->where('nama_barang', 'like', '%'.$nama.'%')->paginate($sorting);
            }
        } else {
            if($kode != "") {
                $results = $results->where('kode_barang', 'like', '%'.$kode.'%')->paginate($sorting);
            } else {
                $results = $results->paginate($sorting);
            }
        }
        return response($results);
    }

    public function addProduct($data, $files, $typeHarga, $stocks)
    {
        $return = false;
        $path = 'images/products/';
        $wm = public_path('wm.png');
        $pathOfFile = [];
        foreach ($files as $file) {
            $optimizerChain = OptimizerChainFactory::create();
            $filename = Str::random(20) .'.'. $file->getClientOriginalExtension();
            $img = Image::make($file->getRealPath());
            $img->resize(300, 300);
            $img->insert($wm, 'center');
            $img->encode('jpg', 60);
            Storage::disk('local')->put($path . $filename, $img, 'public');
            $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix().$path.$filename;
            $optimizerChain->optimize($storagePath);
            array_push($pathOfFile, $path.$filename);
        }

        $create = Products::create($data);
        if($create) {
            foreach ($pathOfFile as $val) {
                $addImage = FileProducts::create([
                    'product_id' => $create->id,
                    'image' => $val
                ]);
                if($addImage) {
                    $return = true;
                } else {
                    Products::find($create->id)->delete();
                }
            }
            $managementStok = Stocks::create([
                'product_id' => $create->id,
                'stok' => $stocks['stok'],
                'harga_dasar' => $stocks['harga_dasar'],
                'tgl_update' => date('Y-m-d H:i:s')
            ]);
            if($typeHarga['typeHarga'] != "false") {
                Log::info('masuk sini '. json_encode($typeHarga));
                $nama_agen = explode(',', $typeHarga['data']['nama_agen']);
                $harga = explode(',', $typeHarga['data']['harga']);
                for ($i=0; $i < count($nama_agen); $i++) { 
                    $addTypePrice = TypePrices::create([
                        'product_id' => $create->id,
                        'nama_agen' => $nama_agen[$i],
                        'harga' => $harga[$i],
                    ]);
                }
            }
            // foreach ($typeHarga['data'] as $th) {
            //     $addTypePrice = TypePrices::create([
            //         'product_id' => $create->id,
            //         'nama_agen' => $th['nama_agen'],
            //         'harga' => $th['harga'],
            //     ]);
            // }
        }
        if($return == false) return response(['message' => 'Produk gagal ditambahkan'], 500);
        return response(['message' => 'Produk berhasil ditambahkan']);
    }

    public function show($id)
    {
        $result = Products::with('images:id,product_id,image', 'stocks', 'typePrices')->where('id', $id)->first();
        return $result;
    }

    public function updateProduct($data, $id)
    {
        $result = Products::find($id);
        if(!$result) return response(['message' => 'Data tidak cocok dengan dokumen apapun'], 404);
        $result->update($data);
        $result->save();
        return response(['message' => 'Update produk berhasil']);
    }

    public function deleteProduct($id)
    {
        $result = Products::with('images:id,product_id,image')->where('id', $id)->first();
        if(!$result) return response(['message' => 'Data tidak cocok dengan dokumen apapun'], 404);
        foreach ($result->images as $image) {
            Storage::disk('local')->delete($image->image);
        }
        $delete = Products::find($id)->delete();
        if(!$delete) return response(['message' => 'produk gagal dihapus'], 500);
        return response(['message' => 'Produk berhasil dihapus']); 
    }

    public function detailTypePrice($id)
    {
        $checkTypePrice = TypePrices::find($id);
        if(!$checkTypePrice) return response(['message' => 'Type Price tidak ditemukan'], 404);
        return response($checkTypePrice);
    }

    public function addTypePrice($data)
    {
        $checkProd = Products::find($data['product_id']);
        if(!$checkProd) return response(['message' => 'Produk tidak ditemukan'], 404);
        $create = TypePrices::create($data);
        if(!$create) return response(['message' => 'type harga gagal ditambahkan'], 500);
        return response(['message' => 'Type harga berhasil ditambahkan']);
    }

    public function updateTypePrice($data, $id)
    {
        $checkTypePrice = TypePrices::find($id);
        if(!$checkTypePrice) return response(['message' => 'Type Price tidak ditemukan'], 404);
        $update = $checkTypePrice->update($data);
        if(!$update) return response(['message' => 'type harga gagal diupdate'], 500);
        return response(['message' => 'Type harga berhasil diupdate']);
    }

    public function deleteTypePrice($id)
    {
        $checkTypePrice = TypePrices::find($id);
        if(!$checkTypePrice) return response(['message' => 'Type Price tidak ditemukan'], 404);
        $delete = $checkTypePrice->delete();
        if(!$delete) return response(['message' => 'type harga gagal dihapus'], 500);
        return response(['message' => 'Type harga berhasil dihapus']);
    }
}