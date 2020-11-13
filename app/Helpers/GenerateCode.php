<?php
namespace App\Helpers;

class GenerateCode 
{
    public static function kode($length = 5)
    {
        $char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($char);
        $random_string = '';
        for ($i=0; $i < $length; $i++) { 
            $random_string .= $char[rand(0, $charLength - 1)];
        } 
        return $random_string;
    }
}