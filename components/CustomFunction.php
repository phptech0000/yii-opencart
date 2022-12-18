<?php

namespace app\components;

class CustomFunction
{
     public static function getUserCountry() {
        $country = "";
        if(isset($_SERVER["HTTP_CF_IPCOUNTRY"])){
            $country = $_SERVER["HTTP_CF_IPCOUNTRY"];
        }
        return $country;
     }
}