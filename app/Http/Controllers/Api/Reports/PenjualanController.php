<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    protected $penjualanService;

    public function __construct() {
        $this->penjualanService = app()->make('PenjualanService');
    }

    public function getAll(Request $request)
    {
        $year = $request->input('year');
        $type = $request->input('type');
        if(!$year) {
            $year = date('Y');
        }
        if(!$type) {
            $type = "graph";
        }
        return $this->penjualanService->getall($year, $type);
    }
}
