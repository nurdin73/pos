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
}
