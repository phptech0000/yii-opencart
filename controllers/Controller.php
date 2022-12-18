<?php    
    namespace app\controllers;

    class Controller extends \yii\web\Controller
    {
        public function init(){
            parent::init();

        }
        public function getUserIP(){
            $ip = "";
            if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])){
                $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
            }else{
                $ip = $_SERVER["REMOTE_ADDR"];
            }
            return $ip;
        }
    }