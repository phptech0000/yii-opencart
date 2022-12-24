<?php    
namespace app\controllers;

use app\models\Language;
use Yii;
class Controller extends \yii\web\Controller
{
    public $lang;
    public function init(){
        if (!empty($_GET['language'])){
            Yii::$app->language = $_GET['language'];
        }else{
            Yii::$app->language = '';
        }
        $this->lang = Language::find()->select(["lang_code", "lang"])->asArray()->all();
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

    public function getLang(){
        $default_lang = Language::find()->where(["is_default" => 1])->one();
        $lang = $default_lang->lang_code;
        if(Yii::$app->language !== ""){
            $lang = Yii::$app->language;
        }
        return $lang;
    }
}