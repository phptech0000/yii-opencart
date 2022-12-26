<?php
use yii\helpers\Html;

use app\assets\AppAsset;
use app\components\CustomFunction;

AppAsset::register($this);
$getLanguage = CustomFunction::getGetLang();
$defaultLanguage = CustomFunction::getDefaultLang();
$language = CustomFunction::getLang();
$region = CustomFunction::getUserCountry() == "" ? "XX" : CustomFunction::getUserCountry();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="language" content="<?= $language ?>">
        <meta name="region" content="<?= $region ?>">
        <link rel="icon" type="image/x-icon" href="/favicon.ico" />
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>
    <body>
        
        <div class="container mt-3">
            <div class="row">
                <div class="col-7">

                </div>
                <div class="col-2">
                    <select class="form-select" id="language" name="language">
                        <option value="">Default</option>
                        <?php foreach($this->context->lang as $item){ ?>
                            <option value="<?= $item["lang_code"] ?>"><?= $item["lang"] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <?php $this->beginBody() ?>
            <?= $content ?>
        <?php $this->endBody() ?>  
    </body>
    <script src="/plugin/jquery.cookie.min.js"></script>
    <script type="text/javascript">
        $("#language").change(function(){
            var currentUrl = "<?= Yii::$app->request->url ?>";
            if($(this).val() && ( $(this).val() !== "<?= $defaultLanguage  ?>")){
                currentUrl = currentUrl.replace("<?= $language ?>", $(this).val());
            }else{
                if(currentUrl.startsWith("/" + $.cookie('language') + "/")){
                    currentUrl = currentUrl.substr(3);
                }  
            }
            $.cookie('language', $(this).val(), { expires: 5 * 365, path: '/', sameSite: 'Lax', secure: true });
            window.location.href = currentUrl;
        })
        $(document).ready(function(){
            var currentUrl = "<?= Yii::$app->request->url ?>";
            var language = $.cookie('language');
            if( "<?= $getLanguage ?>" !== language){
                $("#language").val("<?= $getLanguage ?>");
                if("<?= $getLanguage ?>" && ( "<?= $getLanguage ?>" !== "<?= $defaultLanguage  ?>")){
                
                }else{
                    if(currentUrl.startsWith("/" + "<?= $getLanguage ?>" + "/")){
                        currentUrl = currentUrl.substr(3);
                    }  
                }
                $.cookie('language', "<?= $getLanguage ?>", { expires: 5 * 365, path: '/', sameSite: 'Lax', secure: true });
                window.location.href = currentUrl;
            }
            $("#language").val(language);
        });
    </script>
</html>
<?php $this->endPage() ?>