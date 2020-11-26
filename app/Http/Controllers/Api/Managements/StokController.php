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

    public function listStok($id_product)
    {
        return $this->stockService->listStok($id_product);
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

    public function show($id)
    {
        return $this->stockService->detail($id);
    }

    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'harga_dasar' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);
        $data = [
            'harga_dasar' => $request->input('harga_dasar'),
            'stok' => $request->input('stok')
        ];
        return $this->stockService->update($data, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->stockService->destroy($id);
    }
}
