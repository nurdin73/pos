<?php

namespace App\Http\Controllers\ThirdParty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Xendit\Xendit;

class XenditController extends Controller
{
    public function request()
    {
        Xendit::setApiKey('xnd_development_8Bos4bAJLUUlmFCa4YknYNOn1hjUOBZK6vg9tEUCJjXes6568AT6NIot9ju9oX2s');

        $params = [
            'external_id' => '123',
            'retail_outlet_name' => 'ALFAMART',
            'name' => 'Rika Sutanto',
            'expected_amount' => 10000
        ];

        $createFPC = \Xendit\Retail::create($params);
        var_dump($createFPC);
    }
}
