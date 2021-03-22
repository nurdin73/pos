<?php
namespace App\Services;

use App\Helpers\PrintTrx;
use App\Models\PrinterSettings;
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
        if($data['new_pass'] != $data['confirm_pass']) return response(['message' => 'Password konfirm tidak sama'], 422);
        if(Hash::check($data['old_pass'], $user->password)) {
            $update = $user->update([
                'password' => Hash::make($data['new_pass'])
            ]);
            if(!$update) return response(['message' => 'terjadi kesalahan'], 500);
            return response(['message' => 'Password berhasil dirubah']); 
        } else {
            return response(['message' => 'Password Lama tidak sesuai'], 422);
        }
    }

    public function updateLogo($file)
    {
        $optimizerChain = OptimizerChainFactory::create();
        $path = "images/logo/";
        $filename = Str::random(20) .'.'. $file->getClientOriginalExtension();
        $img = Image::make($file->getRealPath());
        $img->resize(300, 300);
        $img->encode('jpg', 60);
        Storage::disk('local')->put($path . $filename, $img, 'public');
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix().$path.$filename;
        $optimizerChain->optimize($storagePath);
        $store = Stores::find(1);
        if($store) {
            Storage::disk('local')->delete($store->logo);
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

    public function getDetailStore()
    {
        $result = Stores::find(1);
        return response($result);
    }

    public function updateStore($data)
    {
        $store = Stores::find(1);
        if(!$store) {
            Stores::create($data);
        } else {
            $store->update($data);
        }
        return response(['message' => 'Detail toko berhasil di update']);
    }

    public function printer($data, $id)
    {
        try {
            $check = PrinterSettings::find($id);
            if(!$check) {
                $check = PrinterSettings::create($data);
            } else {
                $check = $check->update($data);
            }
            return response(['message' => 'Settingan berhasil di update']);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()]);
        }
    }

    public function getSettingPrinter($id)
    {
        $result = PrinterSettings::find($id);
        if(!$result) return response(['message' => 'Data masih kosong']);
        return response($result);
    }

    public function testConnection()
    {
        try {
            $printer = new PrintTrx();
            return $printer->testConnection();
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }
}