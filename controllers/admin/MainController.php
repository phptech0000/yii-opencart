<?php

namespace app\controllers\admin;

use Yii;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use \yii\db\Expression;
use yii\data\Pagination;

use app\controllers\Controller;
use app\models\LoginForm;
use app\models\Order;
use app\models\User;

class MainController extends Controller
{
    public $layout = '@vendor/hail812/yii2-adminlte3/src/views/layouts/main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'dashboard', 'user'],
                'rules' => [
                    [
                        'actions' => ['logout', 'dashboard', 'user'],
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
        $url = "";
        if(!\Yii::$app->user->isGuest){
            $url = "/admin/dashboard";
        }else{
            $url = "/admin/login"; 
        }
        return $this->redirect($url);
    }

    public function actionLogin(){

        $this->layout = '@vendor/hail812/yii2-adminlte3/src/views/layouts/main-login';

        if (!Yii::$app->user->isGuest) {
            return $this->redirect("/admin/dashboard");
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect("/admin/dashboard");
        }

        $model->password = '';
        return $this->render('@app/views/admin/login', ["model" => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect("/admin/login");
    }

    public function actionDashboard(){
        return $this->render('@app/views/admin/dashboard');
    }

    public function actionUser(){
        $pageSizes = [5, 10, 15, 20];
        if($_GET['per-page']){
            $pageSize = $_GET['per-page'];
        }else{
            $pageSize = $pageSizes[0];
        }
        $query = Order::find()->orderBy(['date' => SORT_DESC]);
        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $models = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('@app/views/admin/user',[
            'models' => $models, 'pagination' => $pagination, 'pageSizes' => $pageSizes]);
    }
}