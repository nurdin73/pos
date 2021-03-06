<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    protected $staffService;

    public function __construct() {
        $this->staffService = app()->make('StaffService');
    }

    public function getall(Request $request)
    {
        $nama = $request->input('nama_staff') != null ? $request->input('nama_staff') : "";
        $sorting = $request->input('sorting') != null ? $request->input('sorting') : 10;

        return $this->staffService->getall($nama, $sorting);
    }

    public function get($id)
    {
        return $this->staffService->get($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_staff' => 'required',
            'email' => 'required',
            'no_telp' => 'required',
            'jabatan' => 'required',
        ]);
        return $this->staffService->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->staffService->destroy($id);
    }

    public function add(Request $request)
    {
        $request->validate([
            'nama_staff' => 'required',
            'email' => 'required|unique:staffs',
            'no_telp' => 'required',
            'jabatan' => 'required',
            'password' => 'required'
        ]);

        return $this->staffService->add($request->all());
    }
}
