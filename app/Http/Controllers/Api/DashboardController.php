<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    protected $dashboardService;
    public function __construct() {
        $this->dashboardService = app()->make('DashboardService');
    }

    public function transactions()
    {
        return $this->dashboardService->transactions();
    }

    public function chartTransactions(Request $request)
    {
        $time = $request->input('time');
        if(!$time) {
            $time = "days";
        }
        return $this->dashboardService->chartTransactions($time);
    }

    public function bestSeller(Request $request)
    {
        $year = $request->input('year');
        if(!$year) {
            $year = date('Y');
        }
        return $this->dashboardService->bestSeller($year);
    }

    public function newTransactions(Request $request)
    {
        $year = $request->input('year');
        if(!$year) {
            $year = date('Y');
        }
        return $this->dashboardService->newTransactions($year);
    }
}
