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
use app\models\Language;
use app\models\Page;
use app\models\PageForm;

class MainController extends Controller
{
    public $layout = '@vendor/hail812/yii2-adminlte3/src/views/layouts/main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'dashboard', 'order', 'page', 'lang'],
                'rules' => [
                    [
                        'actions' => ['logout', 'dashboard', 'order', 'page', 'lang'],
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

    public function actionOrder(){
        $getParams = [];
        if(isset($_GET)){
            foreach($_GET as $getKey => $getValue){
                $getParams[$getKey] = $getValue;
            }
        }
        $pageSizes = [5, 10, 15, 20];
        if(!empty($_GET['per-page'])){
            $pageSize = $_GET['per-page'];
        }else{
            $pageSize = $pageSizes[0];
        }
        $query = Order::find()->orderBy(['date' => SORT_DESC]);
        if(isset($_GET["from"]) || isset($_GET["to"])){
            if($_GET["from"] && $_GET["to"]){
                $query = $query
                ->where(['between', 'date', $getParams["from"], $getParams["to"]]);
            }else{
                if($_GET["from"]){
                    $query = $query->andFilterWhere(['>=', 'date', $getParams["from"]]);
                }
                if($_GET["to"]){
                    $query = $query->andFilterWhere(['<=', 'date', $getParams["to"]]);
                }
            }
            
            
        }
        $countQuery = clone $query;
        $pagination = new Pagination([
            'totalCount' => $countQuery->count(), 
            'pageSize' => $pageSize, 
            'defaultPageSize' => $pageSizes[0],
            'params' => $getParams
        ]);
        $models = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('@app/views/admin/user',[
            'models' => $models, 'pagination' => $pagination, 'pageSizes' => $pageSizes]);
    }

    public function actionLang(){
        $lang = Language::find()->all();
        return $this->render('@app/views/admin/lang', ["lang" => $lang]);
    }

    public function actionLangCreate(){
        $model = new Language();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            $url = Yii::getAlias('@app/views/main');
            file_put_contents($url."/".$model->lang_code."-index.php", "");
            file_put_contents($url."/".$model->lang_code."-checkout.php", "");
            file_put_contents($url."/".$model->lang_code."-success.php", "");
            return $this->redirect("/admin/lang");
        }
        return $this->render('@app/views/admin/lang_create', ["model" => $model]);
    }

    public function actionLangEdit(){
        $model = Language::find()->where(['id' => $_GET["id"] ])->one();
        $pre_lang = $model->lang_code;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            $url = Yii::getAlias('@app/views/main');
            $index = file_get_contents($url."/".$pre_lang."-index.php");
            $checkout = file_get_contents($url."/".$pre_lang."-checkout.php");
            $success = file_get_contents($url."/".$pre_lang."-success.php");
            file_put_contents($url."/".$model->lang_code."-index.php", $index);
            file_put_contents($url."/".$model->lang_code."-checkout.php", $checkout);
            file_put_contents($url."/".$model->lang_code."-success.php", $success);
            unlink($url."/".$pre_lang."-index.php");
            unlink($url."/".$pre_lang."-checkout.php");
            unlink($url."/".$pre_lang."-success.php");
            return $this->redirect("/admin/lang");
        }
        return $this->render('@app/views/admin/lang_create', ["model" => $model]);
    }

    public function actionLangDelete(){
        $model = Language::find()->where(['id' => $_GET["id"] ])->one();
        $url = Yii::getAlias('@app/views/main');
        unlink($url."/".$model->lang_code."-index.php");
        unlink($url."/".$model->lang_code."-checkout.php");
        unlink($url."/".$model->lang_code."-success.php");
        $model->delete();
        return $this->redirect("/admin/lang");
    }

    public function actionPage(){
        $tmp = [];
        $url = Yii::getAlias('@app/views/main');
        $language = Language::find()->select(["lang_code", "lang"])->asArray()->all();
        foreach($language as $item){
            array_push($tmp, [$item["lang_code"] => $item["lang"]]);
        }
        $files = scandir($url);
        $model = new PageForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $lang_code = Yii::$app->request->post("PageForm")["lang_code"];
            $file_name = Yii::$app->request->post("PageForm")["file_name"];
            $url = $url . "/" . $lang_code . "-" . $file_name . ".php";
            file_put_contents($url, "");
            return $this->redirect("/admin/page");
        }
        return $this->render('@app/views/admin/page', ["files" => $files, "model" => $model, 'language' => $tmp]);
    }

    public function actionPageEdit(){
        $url = Yii::getAlias('@app/views/main') . "/" . $_GET['file'];
        $data = file_get_contents($url);
        $model = new Page();
        $model->content = htmlspecialchars($data,ENT_HTML5);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $content = htmlspecialchars_decode(Yii::$app->request->post("Page")["content"]);
            file_put_contents($url,$content);
            return $this->redirect("/admin/page");
        }
        return $this->render('@app/views/admin/page_edit', ["model" => $model]);
    }

    public function actionPageDelete(){
        $url = Yii::getAlias('@app/views/main') . "/" . $_GET['file'];
        unlink($url);
        return $this->redirect("/admin/page");
    }

    public function actionIsDefault(){
        $lang = Language::find()->all();
        foreach($lang as $item){
            if($item->id == $_GET["id"]){
                $item->is_default = 1;
            }else{
                $item->is_default = 0;
            }
            $item->save();
        }
        return $this->redirect("/admin/lang");
    }
}