<?php

namespace App\Http\Controllers\Api\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    protected $suplierService;

    public function __construct() {
        $this->suplierService = app()->make('SuplierService');
    }

    protected function validateSuplier($request)
    {
        $request->validate([
            'nama_suplier'  => 'required',
            'no_telp'       => 'required',
            'alamat'        => 'required'
        ]);
    }

    public function getAll(Request $request)
    {
        $nama = $request->input('search_nama_suplier');
        if($nama == null) {
            $nama = "";
        }
        $sorting = $request->input('sorting');
        if($sorting == null) {
            $sorting = 10;
        }
        return $this->suplierService->getAll($nama, $sorting);
    }

    public function getDetail($id)
    {
        return $this->suplierService->getDetail($id);
    }

    public function addSuplier(Request $request)
    {
        $this->validateSuplier($request);
        return $this->suplierService->addSuplier($request->all());
    }

    public function updateSuplier(Request $request, $id)
    {
        $this->validateSuplier($request);
        return $this->suplierService->updateSuplier($request->all(), $id);
    }

    public function deleteSuplier($id)
    {
        return $this->suplierService->deleteSuplier($id);
    }
}
