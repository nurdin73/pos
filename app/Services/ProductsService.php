<?php
namespace App\Services;

use App\Models\FileProducts;
use App\Models\Products;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductsService
{
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
}