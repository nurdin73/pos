<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    protected $settingService;

    public function __construct() {
        $this->settingService = app()->make('SettingService');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $data = [
            'name' => $request->input('name'),
            'alamat' => $request->input('alamat')
        ];
        return $this->settingService->update($data, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function detail()
    {
        return $this->settingService->getProfile();
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_pass' => 'required',
            'new_pass' => 'required|min:8',
            'confirm_pass' => 'required|min:8'
        ]);
        $data = [
            'old_pass' => $request->input('old_pass'),
            'new_pass' => $request->input('new_pass'),
            'confirm_pass' => $request->input('confirm_pass'),
        ];
        return $this->settingService->changePassword($data);
    }

    public function locked()
    {
        $password = request()->password;
        return $this->settingService->locked($password);
    }
}
