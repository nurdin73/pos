<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.profile');
    }

    public function toko()
    {
        return view('admin.settings.toko');
    }

    public function database()
    {
        return view('admin.settings.database');
    }

    public function managementStaff()
    {
        return view('admin.settings.managementStaff');
    }
}
