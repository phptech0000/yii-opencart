<?php    
namespace app\controllers;
use Yii;
class Controller extends \yii\web\Controller
{
    public function init(){
        if (!empty($_GET['language'])){
            Yii::$app->language = $_GET['language'];
        }else{
            Yii::$app->language = '';
        }
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