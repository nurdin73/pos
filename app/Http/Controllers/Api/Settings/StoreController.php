<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    protected $settingService;

    public function __construct() {
        $this->settingService = app()->make('SettingService');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|mimes:jpg,png,jpeg'
        ]);
        $file = $request->file('logo');
        return $this->settingService->updateLogo($file);
    }

    public function detail()
    {
        return $this->settingService->getDetailStore();
    }

    public function update(Request $request)
    {
        $request->validate([
            'jenis_usaha' => 'required',
            'nama_toko' => 'required',
            'owner' => 'required',
            'no_telp' => 'required|numeric',
            'alamat' => 'required',
        ]);
        return $this->settingService->updateStore($request->all());
    }
}
