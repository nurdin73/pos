<?php
namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseService 
{
    public function getMessages()
    {
        $path = __DIR__ . "/firebaseconfig.json";
        $allData = [];
        $factory = (new Factory)->withServiceAccount($path)
        ->withDatabaseUri('https://bottele-a60c2-default-rtdb.firebaseio.com/');
        $database = $factory->createDatabase();
        $ref = $database->getReference("Messages");
        $messages = $ref->getValue();
        foreach ($messages as $message) {
            $sub = [];
            $sub['id'] = $message['id'];
            $sub['nama'] = $message['nama'];
            $sub['username'] = $message['username'];
            $sub['message'] = $message['message'];
            $sub['histories'] = [];
            $histories = $database->getReference('History')->orderByChild('message_id')->equalTo($message['id'])->getValue();
            foreach ($histories as $history) {
                $histori = [
                    'created_at' => $history['created_at']
                ];
                array_push($sub['histories'], $histori);
            }
            array_push($allData, $sub);
        }
        return $allData;
    }
}