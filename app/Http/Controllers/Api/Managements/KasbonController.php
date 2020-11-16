<?php

namespace App\Http\Controllers\Api\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KasbonController extends Controller
{

    protected $kasbonService;

    public function __construct() {
        $this->kasbonService = app()->make('KasbonService');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nama = $request->input('nama');
        if($nama == null) {
            $nama = "";
        }
        $tempo = $request->input('jatuh_tempo');
        if($tempo == null) {
            $tempo = "";
        }
        $page = $request->input('page');
        if($page == null) {
            $page = 1;
        }
        return $this->kasbonService->getAll($nama, $tempo);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'jatuh_tempo' => 'required',
            'keterangan' => 'required'
        ]);

        $data = [
            'pelanggan_id' => $request->input('pelanggan_id'),
            'jumlah' => $request->input('jumlah'),
            'jatuh_tempo' => $request->input('jatuh_tempo'),
            'keterangan' => $request->input('keterangan'),
            'tgl_kasbon' => date("Y-m-d H:i:s"),
            'status' => 'belum lunas'
        ];

        return $this->kasbonService->add($data);
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
        //
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
