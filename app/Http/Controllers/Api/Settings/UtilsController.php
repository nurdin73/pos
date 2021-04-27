<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UtilsController extends Controller
{
    protected $utilsService;
    public function __construct() {
        $this->utilsService = app()->make('UtilsService');
    }

    public function menus(Request $request)
    {
        return $this->utilsService->menus($request->user());
    }
}
