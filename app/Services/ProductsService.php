<?php
namespace App\Services;

use App\Models\FileProducts;
use App\Models\Products;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class ProductsService
{
    public function getAll()
    {
        $results = Products::select('id', 'nama_barang', 'stok', 'kode_barang', 'harga_dasar', 'harga_jual')->get();
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
                ->addColumn('checkbox', function ($row){
                    $row = json_encode($row);
                    $row = json_decode($row);
                    $id = $row->id;
                    $checkbox = "<input type='checkbox' class='check' name='check' id='check' data-id='$id'>";
                    return $checkbox;
                })
                ->rawColumns(['checkbox', 'actions'])
                ->make(true);
    }

    public function addProduct($data, $files)
    {
        $return = false;
        $path = 'images/products/';
        $pathOfFile = [];
        foreach ($files as $file) {
            $optimizerChain = OptimizerChainFactory::create();
            $filename = Str::random(20) .'.'. $file->getClientOriginalExtension();
            $img = Image::make($file->getRealPath());
            $img->resize(300, 300);
            $img->stream();
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
                    Products::find($create->id)->destroy();
                }
            }
        }
        if($return == false) return response(['message' => 'Produk gagal ditambahkan'], 406);
        return response(['message' => 'Produk berhasil ditambahkan']);
    }

    public function show($id)
    {
        $result = Products::with('images:id,product_id,image')->where('id', $id)->first();
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
}