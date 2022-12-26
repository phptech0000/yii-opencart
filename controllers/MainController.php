<?php

namespace app\controllers;

use Yii;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use \yii\db\Expression;


use app\controllers\Controller;
use app\models\BuyForm;
use app\models\CheckoutForm;
use app\models\Language;
use app\models\Order;
use app\components\CustomFunction;

class MainController extends Controller
{
    public $layout = 'layout';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(){
        $ip = $this->getUserIP();
        $order_count = Order::find()->where(["ip" => $ip, 'order_status' => 'WaitingApproval'])->count();
        if(Yii::$app->request->isPost){
            $ua = Yii::$app->request->getUserAgent();
            $result = array();
            $data = Yii::$app->request->post();
            $model = new BuyForm();
            $model->first_name = $data['first_name'];
            $model->email = $data['email'];
            if($order_count >= 2){
                $model->verifyCode = $data['verifyCode'];
                $model->scenario = 'verify_code';
            }else{
                $model->scenario = 'usual';
            }
            if( $model->validate() ){
                if($data["order_id"]){
                    $order = Order::findOne($data["order_id"]);
                }else{
                    $order = new Order;
                }
                $order->date = new Expression('NOW()');
                $order->order_status = "Uncompleted";
                $order->first_name = $data['first_name'];
                $order->email = $data['email'];
                $order->lang = CustomFunction::getLang();
                $order->ua = $ua;
                $order->ip = $ip;
                $order->save();
                $result["status"] = "success";
                $result["order_id"] = $order->id;
            }else{
                $result["status"] = "fail";
                $result["message"] = $model->errors;
            }
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'first_name',
                'value' => $data['first_name'],   
            ]));
            $cookies->add(new \yii\web\Cookie([
                'name' => 'email',
                'value' => $data['email'],
            ]));
            return json_encode($result);
        }else{
            // $this->layout = false;
            return $this->render($this->getLang()."-index", ["order_count" => $order_count]);
        }        
    }

    public function actionCheckout(){
        $ip = $this->getUserIP();
        $order_count = Order::find()->where(["ip" => $ip, 'order_status' => 'WaitingApproval'])->count();
        if(Yii::$app->request->isPost){
            $ua = Yii::$app->request->getUserAgent();
            $result = array();
            $data = Yii::$app->request->post();
            $model = new CheckoutForm();
            $model->first_name = $data['first_name'];
            $model->last_name = $data['last_name'];
            $model->email = $data['email'];
            $model->phone = $data['phone'];
            $model->street1 = $data['street1'];
            $model->street2 = $data['street2'];
            $model->city = $data['city'];
            $model->zip = $data['zip'];
            $model->country = $data['country'];
            if($order_count >= 2){
                $model->verifyCode = $data['verifyCode'];
                $model->scenario = 'verify_code';
            }else{
                $model->scenario = 'usual';
            }
            // $model->payment_method = $data['payment_method'];
            if( $model->validate() ){
                if($data["order_id"]){
                    $order = Order::findOne($data["order_id"]);
                }else{
                    $order = new Order;
                }
                $order->date = new Expression('NOW()');
                $order->order_status = "WaitingApproval";
                $order->first_name = $data['first_name'];
                $order->last_name = $data['last_name'];
                $order->email = $data['email'];
                $order->phone = $data['phone'];
                $order->street1 = $data['street1'];
                $order->street2 = $data['street2'];
                $order->zip = $data['zip'];
                $order->city = $data['city'];
                $order->country = $data['country'];
                $order->lang = CustomFunction::getLang();;
                // $order->payment_method = $data['payment_method'];
                $order->ua = $ua;
                $order->ip = $ip;
                $order->save();
                $result["status"] = "success";
                $result["order_id"] = $order->id;
            }else{
                $result["status"] = "fail";
                $result["message"] = $model->errors;
            }
            return json_encode($result);
        }else{
            // $country_data = Country::find()->select(["country_id", "name"])->asArray()->all();
            return $this->render($this->getLang()."-checkout", ['order_count'=>$order_count]);
        }
    }
    public function actionSuccess(){
        return $this->render($this->getLang()."-success");
    }

    public function actionHome(){
        $default_language = CustomFunction::getDefaultLang();
        if(isset($_COOKIE["language"])){
            if($_COOKIE["language"] && ($_COOKIE["language"] !== $default_language)){
                $url = "/" . $_COOKIE["language"] . "/index.html";
            }else{
                $url = "/index.html";
            }
            
        }else{
            $url = "/index.html";
        }
        return $this->redirect($url);
    }
}