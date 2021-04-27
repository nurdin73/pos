<?php

namespace App\Http\Controllers\Api\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReturnProductController extends Controller
{
    protected $returnProductService;
    public function __construct() {
        $this->returnProductService = app()->make('ReturnProductService');
    }

    public function getall(Request $request)
    {
        $search = $request->input('search') ?? "";
        $sorting = $request->input('sorting') ?? 10;
        return $this->returnProductService->getall($search, $sorting);
    }

    public function get($id)
    {
        return $this->returnProductService->get($id);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'qyt' => 'required',
        ]);
        return $this->returnProductService->add($request->all(['product_id', 'qyt', 'reason']));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'qyt' => 'required',
        ]);
        return $this->returnProductService->update($request->all(['product_id', 'qyt', 'reason']), $id);
    }

    public function destroy($id)
    {
        return $this->returnProductService->destroy($id);
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');
        return $this->returnProductService->updateStatus($status, $id);
    }
}
