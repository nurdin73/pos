<?php

namespace App\Http\Controllers\Api\Managements;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
    }

    public function getLike(Request $request)
    {
        $name = $request->input('name');
        $results = "";
        if($name) {
            $results = Categories::where('name', 'like', '%'. $name .'%')->select('id','name')->limit(5)->get();
        } else {
            $results = Categories::select('id','name')->limit(5)->get();
        }
        return response($results);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checkAuth = Auth::user();
        $request->validate([
            'name' => 'required'
        ]);
        $name = $request->input('name');
        if(!$checkAuth) return response(['message' => 'please login terlebih dahulu'], 403); 
        $checkKategori = Categories::where('name', $name)->first();
        if($checkKategori) return response(['message' => 'Nama kategori sudah ada'], 403);
        $create = Categories::create([
            'name' => $name,
            'alias' => Str::slug($name)
        ]);
        if(!$create) return response(['message' => 'Terjadi kesalahan'], 500);
        return response(['message' => 'Kategori berhasil ditambahkan']);
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
