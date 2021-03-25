<?php
namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait RequestTrait 
{
    private function apiRequest($method, $params = [])
    {
        $url = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN', '1552642243:AAFsegQdNOgufvp0GgmnoCea_0U-WfEk1LA') . '/' . $method;
        Log::info(json_encode($params));
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5); 
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($params));
        $response = curl_exec($handle);
        if($response === false) {
            curl_close($handle);
            return false;
        }
        curl_close($handle);
        $response = json_decode($response, true);
        if($response['ok'] == false) {
            return false;
        }
        $response = $response['result'];
        return $response;
    }
}