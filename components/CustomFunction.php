<?php

namespace app\components;

use app\models\Language;

class CustomFunction
{
    public static function getUserCountry() {
        $country = "";
        if(isset($_SERVER["HTTP_CF_IPCOUNTRY"])){
            $country = $_SERVER["HTTP_CF_IPCOUNTRY"];
        }
        return $country;
    }

    public static function getLang(){
        $default_language = Language::find()->where(["is_default" => 1 ])->one()->lang_code;
        if(isset($_COOKIE["language"])){
            if($_COOKIE["language"] && ($_COOKIE['language'] !== $default_language)){
                $language = $_COOKIE["language"];
            }else{
                $language = "";
            }
        }else{
            $language = "";
        }
        return $language;
    }

    public static function getDefaultLang(){
        $lang = Language::find()->where(["is_default" => 1 ])->one();
        return $lang->lang_code;
    }
}