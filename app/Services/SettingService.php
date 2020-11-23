<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingService
{
    public function getProfile()
    {
        $user = Auth::user();
        return response($user);
    }

    public function update($data, $id)
    {
        $user = User::find($id);
        if(!$user) return response(['message' => 'user tidak ditemukan'], 404);
        $update = $user->update($data);
        if(!$update) return response(['message' => 'Update profile gagal'], 500);
        return response(['message' => 'Update profile berhasil']);
    }

    public function changePassword($data)
    {
        $idUser = auth()->user()->id;
        $user = User::find($idUser);
        if(!$user) return response(['message' => 'user tidak ditemukan'], 404);
        if($data['new_pass'] != $data['confirm_pass']) return response(['message' => 'Password konfirm tidak sama'], 403);
        if(Hash::check($data['old_pass'], $user->password)) {
            $update = $user->update([
                'password' => Hash::make($data['new_pass'])
            ]);
            if(!$update) return response(['message' => 'terjadi kesalahan'], 500);
            return response(['message' => 'Password berhasil dirubah']); 
        } else {
            return response(['message' => 'Password Lama tidak sesuai'], 403);
        }
    }
}