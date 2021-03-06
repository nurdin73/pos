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
        return $this->kasbonService->showAll($nama);
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
        ];

        return $this->kasbonService->add($data);
    }

    public function payment(Request $request, $id)
    {
        $request->validate([
            'cicilan' => 'required|numeric',
            'method_payment' => 'required',
            'keterangan' => 'required'
        ]);
        $method_payment = $request->input('method_payment');
        if($method_payment != "cash" && $method_payment != "debit") {
            return response(['message' => 'Metode pembayaran tidak valid'], 406);
        }
        $data = [
            'cicilan' => $request->input('cicilan'),
            'keterangan' => $request->input('keterangan'),
            'method_payment' => $request->input('method_payment'),
        ];
        return $this->kasbonService->processPayment($data, $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->kasbonService->detail($id);
    }

    public function chartKasbon(Request $request)
    {
        $query = $request->get('query');
        $type = $request->get('type');
        return $this->kasbonService->chartKasbon($query, $type);
    }
}
