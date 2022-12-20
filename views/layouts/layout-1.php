<?php
use yii\helpers\Html;

use app\assets\AppAsset;
use app\components\CustomFunction;

AppAsset::register($this);
$language = CustomFunction::getLang();
$region = CustomFunction::getUserCountry() == "" ? "XX" : CustomFunction::getUserCountry();
?>
<?php $this->beginPage() ?>
<html>
    <head>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="language" content="<?= $language ?>">
        <meta name="region" content="<?= $region ?>">
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
                        <option value="en">English</option>
                        <option value="de">German</option>
                        <option value="nl">Dutch</option>
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
            $.cookie('language', $(this).val(), { expires: 5 * 365, path: '/' });
            var currentUrl = "<?= Yii::$app->request->url ?>";
            if($(this).val()){
                currentUrl = currentUrl.replace("<?= $language ?>", $(this).val());
            }else{
                currentUrl = currentUrl.replace("/" + "<?= $language ?>", $(this).val());
            }
            window.location.href = currentUrl;
        })
        $(document).ready(function(){
            $("#language").val("<?= $language ?>");
        });
    </script>
</html>
<?php $this->endPage() ?>