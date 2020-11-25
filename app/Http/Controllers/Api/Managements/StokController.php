<?php

namespace App\Http\Controllers\Api\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StokController extends Controller
{
    protected $stockService;

    public function __construct() {
        $this->stockService = app()->make('StockService');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $request->validate([
            'harga_dasar' => 'numeric',
            'jumlah' => 'required|numeric',
            'method' => 'required'
        ]);

        $data = [
            'harga_dasar' => $request->input('harga_dasar'),
            'jumlah' => $request->input('jumlah'),
            'method' => $request->input('method')
        ];

        return $this->stockService->updateStok($data, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
