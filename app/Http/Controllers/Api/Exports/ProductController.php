<?php

namespace App\Http\Controllers\Api\Exports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productsService;

    public function __construct() {
        $this->productsService = app()->make('ProductsService');
    }

    public function index()
    {
        return $this->productsService->exportExcel();
    }
}
