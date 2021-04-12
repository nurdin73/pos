<?php

namespace App\Http\Controllers\Api\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoyalityProgramController extends Controller
{
    protected $loyalityService;
    public function __construct() {
        $this->loyalityService = app()->make('LoyalityService');
    }
    protected function getValidate($request)
    {
        return $this->validate($request, [
            'name'          => 'required',
            'stock'         => 'required|numeric',
            'point'         => 'required|numeric',
            'codePoint'     => 'required',
            'category_id'   => 'required'
        ]);
    }

    public function getall(Request $request)
    {
        $search = $request->input('search') ?? "";
        $sorting = $request->input('sorting') ?? 10;
        return $this->loyalityService->getall($search, $sorting);
    }

    public function get($id)
    {
        return $this->loyalityService->get($id);
    }

    public function store(Request $request)
    {
        $this->getValidate($request);
        $file = $request->file('image') ?? "";
        return $this->loyalityService->store($request->all(['name', 'stock', 'point', 'codePoint', 'category_id', 'deskripsi']), $file);        
    }

    public function update(Request $request, $id)
    {
        $this->getValidate($request);
        $file = $request->file('image') ?? "";
        return $this->loyalityService->update($request->all(['name', 'stock', 'point', 'codePoint', 'category_id', 'deskripsi']), $file, $id);
    }

    public function delete($id)
    {
        return $this->loyalityService->delete($id);
    }
}
