<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

AppAsset::register($this);

$this->registerCsrfMetaTags();
?>
<?php $this->beginPage() ?>
<html>
    <head>
        <title><?= Html::encode($this->title) ?></title>
        <?= Html::csrfMetaTags() ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/custom.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="container mt-3">
            <div class="row">
                <div class="col-7">

                </div>
                <div class="col-2">
                    <select class="form-select" id="language">
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
    <script type="text/javascript">
        $("#language").change(function(){
            var currentUrl = "<?= Url::current(); ?>";
            currentUrl = currentUrl.replace("<?= $_GET["language"] ?>", $(this).val());
            window.location.href = currentUrl;
        })
        $(document).ready(function(){
            $("#language").val("<?= $_GET["language"] ?>");
        });
    </script>
</html>
<?php $this->endPage() ?>