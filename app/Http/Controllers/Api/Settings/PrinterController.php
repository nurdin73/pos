<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    protected $settingService;
    public function __construct() {
        $this->settingService = app()->make('SettingService');
    }

    public function setting(Request $request, $id)
    {
        $this->validate($request, [
            'os' => 'required',
            'koneksi' => 'required',
            'name_printer' => 'required'
        ]);

        $data = [
            'os' => $request->input('os'),
            'koneksi' => $request->input('koneksi'),
            'name_printer' => $request->input('name_printer'),
        ];

        return $this->settingService->printer($data, $id);
    }

    public function getSetting($id)
    {
        return $this->settingService->getSettingPrinter($id);
    }

    public function testConnection()
    {
        return $this->settingService->testConnection();
    }
}
