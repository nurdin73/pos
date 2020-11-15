<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Models\FileProducts;

class UploadService
{
	public function uploadProductImage($file, $id, $path)
	{
		$result = FileProducts::find($id);
		if(!$result) return response(['message' => 'Gambar tidak ada!'], 404);
		$optimizerChain = OptimizerChainFactory::create();
        $filename = Str::random(20) .'.'. $file->getClientOriginalExtension();
        $img = Image::make($file->getRealPath());
        $img->resize(300, 300);
        $img->stream();
        Storage::disk('local')->put($path . $filename, $img, 'public');
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix().$path.$filename;
        $optimizerChain->optimize($storagePath);
        $create = FileProducts::create([
    		'product_id' => $id,
    		'image' => $path . $filename   	
        ]);
        if(!$create) return response(['message' => 'Upload Image Gagal'], 500);
        return response([
        	'message' => 'Upload Image Success',
        	'create'  => $create
        ]);
	}

	public function delProductImage($id)
	{
		$result = FileProducts::find($id);
		if(!$result) return response(['message' => 'Gambar tidak ada!'], 404);
		Storage::disk('local')->delete($result->image);
		$result->delete();
		return response(['message' => 'Gambar berhasil dihapus!']);
	}
}