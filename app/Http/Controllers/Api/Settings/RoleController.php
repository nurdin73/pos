<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct() {
        $this->roleService = app()->make('RoleService');
    }

    public function getall(Request $request)
    {
        $search = $request->input('search') ?? "";
        $sorting = $request->input('sorting') ?? 10;
        return $this->roleService->getall($search, $sorting);
    }

    public function get($id)
    {
        return $this->roleService->get($id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:name'
        ]);
        return $this->roleService->create($request->input('name'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        return $this->roleService->update($request->input('name'), $id);
    }

    public function destroy($id)
    {
        return $this->roleService->destroy($id);
    }
}
