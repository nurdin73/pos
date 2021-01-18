<?php

namespace App\Http\Controllers\Api\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BranchStoreController extends Controller
{
    protected $branchStoreService;

    public function __construct() {
        $this->branchStoreService = app()->make('BranchStoreService');
    }

    public function getAll(Request $request)
    {
        $nama_cabang = $request->input('search_cabang');
        $sorting = $request->input('sorting');
        if($nama_cabang == null) {
            $nama_cabang = "";
        }
        if($sorting == null) {
            $sorting = 10;
        }
        return $this->branchStoreService->getAll($nama_cabang, $sorting);
    }

    public function show($id)
    {
        return $this->branchStoreService->show($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_cabang' => 'required',
            'no_telp'     => 'required',
            'alamat'      => 'required'
        ]);

        return $this->branchStoreService->update($request->all(), $id);
    }

    public function add(Request $request)
    {
        $request->validate([
            'nama_cabang' => 'required|unique:branch_stores',
            'no_telp'     => 'required',
            'alamat'      => 'required'
        ]);

        return $this->branchStoreService->add($request->all());
    }

    public function delete($id)
    {
        return $this->branchStoreService->delete($id);
    }
}
