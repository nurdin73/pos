<?php
namespace App\Services;

use App\Helpers\CreatePaginationLink;
use App\Models\RoleAccess;
use Illuminate\Support\Facades\Cache;

class RoleAccessService
{
    public function all($search, $sorting)
    {
        $results = RoleAccess::with('role')->select('*')->orderBy('id', 'ASC');
        if($search != "") {
            $results = $results->whereHas('role', function($q) use($search) {
                $q->where('name', 'like', "%$search%");
            })->paginate($sorting);
        } else {
            $results = $results->paginate($sorting);
        }

        $convertpaginate = new CreatePaginationLink($results->getCollection(), $results->links(), $results->currentPage());
        return $convertpaginate->crafting();
    }

    public function isGranted($isGranted, $id)
    {
        $check = RoleAccess::findOrFail($id);
        $check->isGranted = $isGranted;
        $check->save();
        Cache::forget('menus:'.$check->role_id);
        return response(['message' => 'Data berhasil diubah']);
    }
}