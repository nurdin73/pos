<?php

namespace App\Http\Controllers\Api\Exports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModalController extends Controller
{
    protected $stockService;
    public function __construct() {
        $this->stockService = app()->make('StockService');
    }

    public function export()
    {
        return $this->stockService->export();
    }
}
