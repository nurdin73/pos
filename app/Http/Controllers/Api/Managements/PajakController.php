<?php

namespace App\Http\Controllers\Api\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PajakController extends Controller
{
    protected $taxService;

    public function __construct() {
        $this->taxService = app()->make('TaxService');
    }

    protected function validateTax($request)
    {
        $request->validate([
            'nama_pajak'        => 'required',
            // 'barang_id'         => 'required',
            'persentase_pajak'  => 'required'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nama = $request->input('search_pajak');
        if($nama == null) {
            $nama = "";
        }
        $sorting = $request->input('sorting');
        if($sorting == null) {
            $sorting = 10;
        }
        return $this->taxService->getAll($nama, $sorting);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateTax($request);
        return $this->taxService->addTax($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->taxService->getDetail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $this->validateTax($request);
        return $this->taxService->updateTax($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->taxService->deleteTax($id);
    }
}
