<?php

namespace App\Http\Controllers\Api\Exports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerService;
    
    public function __construct() {
        $this->customerService = app()->make('CustomerService');
    }

    public function report()
    {
        return $this->customerService->report();
    }
}
