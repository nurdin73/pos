<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubMenuController extends Controller
{

    protected $subMenuService;
    public function __construct() {
        $this->subMenuService = app()->make('SubMenuService');
    }

    public function getall(Request $request, $role_id)
    {
        $search = $request->input('search') ?? "";
        return $this->subMenuService->getall($search, $role_id);
    }
}
