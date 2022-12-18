<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\BuyForm;
use app\models\CheckoutForm;
use app\models\Country;
use app\models\Order;
use \yii\db\Expression;

class MainController extends Controller
{
    public $layout = 'layout-1';
    
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
        if(Yii::$app->request->isPost){
            $ua = Yii::$app->request->getUserAgent();
            $ip = Yii::$app->request->userIP;
            $result = array();
            $data = Yii::$app->request->post();
            $model = new BuyForm();
            $model->first_name = $data['first_name'];
            $model->email = $data['email'];
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
            // add a new cookie to the response to be sent
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
            return $this->render("pay");
        }        
    }

    public function actionCheckout(){
        if(Yii::$app->request->isPost){
            $ua = Yii::$app->request->getUserAgent();
            $ip = Yii::$app->request->userIP;
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
            $model->lang = $data['lang'];
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
                $order->lang = $data['lang'];
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
            $country_data = Country::find()->select(["country_id", "name"])->asArray()->all();
            return $this->render("checkout", ['country_data' => $country_data]);
        }
    }
    public function actionSuccess(){
        return $this->render("success");
    }

    public function actionHome(){
        return $this->redirect('/index.html');
    }
}
