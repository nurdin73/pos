<?php

namespace App\Http\Controllers\Api\Exports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{

    protected $databaseService;
    public function __construct() {
        $this->databaseService = app()->make('DatabaseService');
    }

    public function export(Request $request)
    {
        $namefile = $request->input('namefile');
        return $this->databaseService->export($namefile);
    }

    public function all(Request $request)
    {
        $who = $request->input('search_pengexport') ?? "";
        $rangeTime = $request->input('search_waktu_export') ?? "";
        $sorting = $request->input('sorting') ?? 10;

        return $this->databaseService->all($who, $rangeTime, $sorting);
    }
}
