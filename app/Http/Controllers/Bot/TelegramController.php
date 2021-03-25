<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use App\Traits\MakeComponent;
use App\Traits\RequestTrait;
use App\Traits\ActionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram;

class TelegramController extends Controller
{

    use RequestTrait;
    use MakeComponent;


    public function webhook()
    {
        return $this->apiRequest('setWebhook', [
            'url' => 'https://8a56e8f2b919.ngrok.io/api/telegram'
        ]) ? ['success'] : ['something wrong'];
    }

    public function index()
    {
        $result = json_decode(file_get_contents('php://input'));
        $action = $result->message->text;
        $exp = explode(' ', $action);
        $chatId = $result->message->from->id;
        $name = $result->message->from->first_name;
        $sendData = [];
        $sendData['chat_id'] = $chatId;
        switch ($exp[0]) {
            case '/start':
                $sendData['text'] = "Hi, $name. \nSaya adalah bot official dari rittercoding. Kamu bisa memasukkan perintah dibawah ini untuk mempermudah aku mengetahui permintaanmu. \n \n/daftar - mendaftarkan diri sebagai customer kami \n/transaksi - mencatat seluruh pesananmu hanya dengan klik klik saja \n/kasbon - merequest pinjaman/ hutang dulu ke kami\n/profile - check datamu sendiri";
                break;
            case '/daftar':
                $sendData['text'] = "Hi, $name. \nPertama masukkan NIK kamu ya. awas jangan sampai salah :) tenang datamu aman ko. \nini formatnya yah \n/nik [NIK kamu]\n\n *tanpa [ ]";
                break;
            case '/nik':
                $sendData['text'] = "Hi, $name. \n Ini data yang sudah dimasukkan \nNIK = $exp[1]\n. Selanjutnya email kamu yah. berikut formatnya \n/email [Email kamu]";
                break;
            case '/transaksi':
                $sendData['text'] = "Hi, $name. Silahkan tambahkan barang yang ingin kamu beli yahh";
                break;
            case '/kasbon':
                $sendData['text'] = "Hi, $name. Silahkan masukan jumlah uang yang ingin dipinjam yah";
                break;
            case '/profile':
                $sendData['text'] = "Hi, $name. ini data diri kamu";
                break;
            default:
                $sendData['text'] = "Hi, $name. \nSaya adalah bot official dari rittercoding. Kamu bisa memasukkan perintah dibawah ini untuk mempermudah aku mengetahui permintaanmu. \n \n/daftar - mendaftarkan diri sebagai customer kami \n/transaksi - mencatat seluruh pesananmu hanya dengan klik klik saja \n/kasbon - merequest pinjaman/ hutang dulu ke kami\n/profile - check datamu sendiri";
                break;
        }
        return $this->apiRequest('sendMessage', $sendData);
    }

    public function getMessages()
    {
        $actifity = Telegram::getUpdates();
        dd($actifity);
    }

    public function sendMessage()
    {
        $send = Telegram::sendMessage([
            'chat_id' => 869500768,
            'text' => 'Haloo sayang'
        ]);
        return $send;
    }
}
