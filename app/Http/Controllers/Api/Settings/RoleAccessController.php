<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleAccessController extends Controller
{
    protected $roleAccessService;
    public function __construct() {
        $this->roleAccessService = app()->make('RoleAccessService');
    }

    public function all(Request $request)
    {
        $search = $request->input('search') ?? "";
        $sorting = $request->input('sorting') ?? 10;
        return $this->roleAccessService->all($search, $sorting);
    }
}
