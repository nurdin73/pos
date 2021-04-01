<?php
namespace App\Services;

use App\Helpers\CreatePaginationLink;
use App\Models\RoleAccess;

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

    public function update($req, $id)
    {
        
    }
}