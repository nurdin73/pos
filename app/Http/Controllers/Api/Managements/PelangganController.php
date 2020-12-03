<?php

namespace App\Http\Controllers\Api\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PelangganController extends Controller
{

    protected $customerService;
    
    public function __construct() {
        $this->customerService = app()->make('CustomerService');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->customerService->getAll();
    }

    public function search(Request $request)
    {
        $nama = $request->input('nama');
        return $this->customerService->search($nama);
    }

    public function getKasbon($id)
    {
        return $this->customerService->kasbonCustomers($id);
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
            'nik'      => 'required|unique:customers',
            'nama'      => 'required',
            'email'     => 'required|email|unique:customers',
            'no_telp'   => 'required|unique:customers',
            'alamat'    => 'required'
        ]);
        $data = [
            'nik' => $request->input('nik'),
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'no_telp' => $request->input('no_telp'),
            'alamat' => $request->input('alamat'),
        ];
        return $this->customerService->add($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->customerService->get($id);
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
            'nik'       => 'required',
            'nama'      => 'required',
            'no_telp'   => 'required',
            'alamat'    => 'required'
        ]);
        $data = [
            'nik' => $request->input('nik'),
            'nama' => $request->input('nama'),
            'no_telp' => $request->input('no_telp'),
            'alamat' => $request->input('alamat'),
            'point' => $request->input('point'),
        ];

        return $this->customerService->update($data, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->customerService->destroy($id);
    }
}
