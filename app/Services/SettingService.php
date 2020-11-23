<?php
namespace App\Services;

use App\Models\Stores;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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

    public function updateLogo($file)
    {
        $optimizerChain = OptimizerChainFactory::create();
        $path = "images/logo/";
        $filename = Str::random(20) .'.'. $file->getClientOriginalExtension();
        $img = Image::make($file->getRealPath());
        $img->resize(300, 300);
        $img->stream();
        Storage::disk('local')->put($path . $filename, $img, 'public');
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix().$path.$filename;
        $optimizerChain->optimize($storagePath);
        $store = Stores::find(1);
        if($store) {
            $store->update([
                'logo' => $path . $filename
            ]);
        } else {
            $create = Stores::create([
                'logo' => $path . $filename
            ]);
        }
        return response(['message' => 'Logo berhasil diupdate']);
    }
}