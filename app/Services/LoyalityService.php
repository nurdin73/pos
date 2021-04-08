<?php
namespace App\Services;

use App\Helpers\CreatePaginationLink;
use App\Models\LoyalityProgram;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class LoyalityService 
{
    public function getall($search, $sorting)
    {
        $results = LoyalityProgram::with(['category' => function($q) {
            $q->select(['id', 'name']);
        }])->select(['id', 'name', 'category_id', 'image', 'point']);
        if($search != "") {
            $results = $results->where('name', 'like', "%$search%")
                        ->orWhere('point', 'like', "%$search%")
                        ->orWhere('codePoint', 'like', "%$search%")
                        ->orWhereHas('category', function($q) use($search) {
                            $q->where('name', 'like', "%$search%");
                        })->paginate($sorting);
        } else {
            $results = $results->paginate($sorting);
        }
        $craftingPagination = new CreatePaginationLink($results->getCollection(), $results->links(), $results->currentPage());
        return $craftingPagination->crafting();
    }

    public function get($id)
    {
        $result = LoyalityProgram::with('category')->findOrFail($id);
        return $result;
    }

    public function store($req, $file)
    {
        try {
            if($file != "") {
                $path = 'images/loyality/';
                $optimizerChain = OptimizerChainFactory::create();
                $filename = Str::random(20) .'.'. $file->getClientOriginalExtension();
                $img = Image::make($file->getRealPath());
                $img->stream();
                Storage::disk('local')->put($path . $filename, $img, 'public');
                $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix().$path.$filename;
                $optimizerChain->optimize($storagePath);
                $req['image'] = $path . $filename ;
            }
            $create = LoyalityProgram::create($req);
            return response(['message' => 'Loyality berhasil ditambahkan']);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }

    public function update($req, $file, $id)
    {
        try {
            $check = LoyalityProgram::findOrFail($id);
            if($file != "") {
                $path = 'images/loyality/';
                $optimizerChain = OptimizerChainFactory::create();
                $filename = Str::random(20) .'.'. $file->getClientOriginalExtension();
                $img = Image::make($file->getRealPath());
                $img->stream();
                if($check->image != null) {
                    Storage::disk('local')->delete($check->image);
                }
                Storage::disk('local')->put($path.$filename, $img, 'public');
                $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix().$path . $filename ;
                $optimizerChain->optimize($storagePath);
                $req['image'] = $path . $filename;
            }
            $update = $check->update($req);
            return response(['message' => 'loyality berhasil diupdate']);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        $check = LoyalityProgram::findOrFail($id);
        if($check->image != null) {
            Storage::disk('local')->delete($check->image);
        }
        $delete = $check->delete();
        return response(['message' => 'Loyality berhasil dihapus']);
    }
}