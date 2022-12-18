<?php
use yii\helpers\Html;
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    </head>
    <body>
        <?php $this->beginBody() ?>
            <?= $content ?>
        <?php $this->endBody() ?>  
    </body>
</html>
<?php $this->endPage() ?>