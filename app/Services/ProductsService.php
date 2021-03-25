<?php
namespace App\Services;

use App\Exports\ProductsExport;
use App\Helpers\CreatePaginationLink;
use App\Models\CodeProducts;
use App\Models\FileProducts;
use App\Models\Products;
use App\Models\Stocks;
use App\Models\TypePrices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductsService
{
    public function getAll()
    {
        $results = Products::select('id', 'nama_barang', 'harga_jual')->get();
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

    public function showAll($nama, $kode, $sorting, $byBranch)
    {
        $results = Products::with('stocks') ->select('id', 'nama_barang', 'harga_jual', 'selled', 'isRetail', 'jumlah');
        if($byBranch !== null) {
            $results = $results->where('cabang_id', $byBranch);
        }
        if($nama != "") {
            if($kode != "") {
                $results = $results->whereHas('codeProducts', function($q) use($kode) {
                    $q->where('kode_barang', 'like', "%$kode%");
                })->with(['codeProducts' => function($q) use($kode) {
                    $q->where('kode_barang', 'like', "%$kode%");
                }])->where('nama_barang', 'like', '%'.$nama.'%')->paginate($sorting);
            } else {
                $results = $results->where('nama_barang', 'like', '%'.$nama.'%')->paginate($sorting);
            }
        } else {
            if($kode != "") {
                $results = $results->whereHas('codeProducts', function($q) use($kode) {
                    $q->where('kode_barang', 'like', "%$kode%");
                })->with(['codeProducts' => function($q) use($kode) {
                    $q->where('kode_barang', 'like', "%$kode%");
                }])->paginate($sorting);    
            } else {
                $results = $results->with('codeProducts')->paginate($sorting);
            }
        }
        $createData = new CreatePaginationLink($results->getCollection(), $results->links(), $results->currentPage());
        return $createData->crafting();
        // return response($results);
    }

    public function addProduct($data, $files, $typeHarga, $stocks, $kode_barang)
    {
        DB::beginTransaction();
        try {
            $return = false;
            $path = 'images/products/';
            $wm = public_path('wm.png');
            $pathOfFile = [];
            if(!is_null($files)) {
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
            }

            $create = Products::create($data);
            if($create) {

                // images
                if(count($pathOfFile) > 0) {
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
                }
                // kode barang
                for ($x=0; $x < count($kode_barang); $x++) { 
                    $kodebarang = CodeProducts::create([
                        'product_id' => $create->id,
                        'kode_barang' => $kode_barang[$x]
                    ]);
                }

                // add stok
                $managementStok = Stocks::create([
                    'product_id' => $create->id,
                    'stok' => $stocks['stok'],
                    'harga_dasar' => $stocks['harga_dasar'],
                    'tgl_update' => date('Y-m-d H:i:s')
                ]);

                // type harga
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
            // if($return == false) return response(['message' => 'Produk gagal ditambahkan'], 500);
            DB::commit();
            return response(['message' => 'Produk berhasil ditambahkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response(['message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $result = Products::with('images:id,product_id,image', 'stocks', 'typePrices', 'suplier', 'branch')->where('id', $id)->first();
        $result->setRelation('codeProducts', $result->codeProducts()->simplePaginate(10));
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

    public function reportProducts()
    {
        $results = Products::with('stocks:id,product_id,stok,harga_dasar')
        ->select('id', 'nama_barang', 'selled')
        ->orderBy('id', 'ASC')->paginate(10);
        $convertData = new CreatePaginationLink($results->getCollection(), $results->links(), $results->currentPage());
        $pagination = collect([
            'data' => $convertData->crafting()
        ]);
        $results2 = Products::with('stocks:id,product_id,stok,harga_dasar')
        ->select('id', 'nama_barang', 'selled')
        ->orderBy('id', 'ASC')->get();
        $data = [];
        $data['totalStok'] = 0;
        $data['totalSelled'] = 0;
        foreach ($results2 as $r) {
            $totalStok = 0;
            foreach ($r->stocks as $s) {
                $totalStok += $s->stok;
            }
            $data['totalStok'] += $totalStok;
            $data['totalSelled'] += $r->selled;
        }
        $response = $pagination->merge($data);
        // return $convertData->crafting();
        return response($response);
    }

    public function exportExcel()
    {
        $results = Products::with('stocks:id,product_id,stok,harga_dasar')
        ->select('id', 'nama_barang', 'selled')
        ->orderBy('id', 'ASC')->get();
        $filename = "Products-". Str::random(20) . '.xlsx';
        return Excel::download(new ProductsExport($results), $filename);
    }

    public function codeProduct($id)
    {
        $result = CodeProducts::find($id);
        return $result;
    }

    public function addCodeProduct($data)
    {
        try {
            $create = CodeProducts::create($data);
            if(!$create) return response(['message' => 'kode barang gagal ditambahkan'], 500);
            return response(['message' => 'kode barang berhasil ditambahkan']);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }

    public function updateCodeProduct($kode_barang, $id)
    {
        $check = CodeProducts::find($id);
        if(!$check) return response(['message' => 'kode produk tidak ditemukan'], 404);
        $check->kode_barang = $kode_barang;
        $update = $check->save();
        if(!$update) return response(['message' => 'kode barang gagal diupdate'], 500);
        return response(['message' => 'kode barang berhasil diupdate']);
    }

    public function deleteCodeProduct($id)
    {
        $check = CodeProducts::find($id);
        if(!$check) return response(['message' => 'kode produk tidak ditemukan'], 404);
        $delete = $check->delete();
        if(!$delete) return response(['message' => 'kode barang gagal didelete'], 500);
        return response(['message' => 'kode barang berhasil didelete']);
    }
}