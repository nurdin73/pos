<?php
namespace App\Traits;

trait MakeComponent 
{
    private function makeBtn($option)
    {
        $keyboard = [
            'keyboard' => $option,
            'resize_keyboard' => true,
            'on_time_key' => false,
            'selective' => true
        ];
        $keyboard = json_encode($keyboard);
        return $keyboard;
    }
}