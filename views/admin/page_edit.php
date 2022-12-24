<?php

use yii\bootstrap4\LinkPager;
use yii\web\View;
use floor12\summernote\Summernote;
use yii\helpers\Html;

$this->title = 'Page';
$this->registerCss(
    '
        .note-editable{
            height: 260px !important;
        }
    ',
);
$this->registerJs(
    '
    $("button[type=button]").click(function(){
        if($("body .btn-codeview").hasClass("active")){
            $("body .btn-codeview").trigger("click");
        }
        $("#page_edit").submit();
    });
        $(document).ready(function(){
            $("body .note-style").remove();
            $("body .note-para").remove();
            $("body .note-link").remove();
            $("body .note-insert").remove();
            $("body .btn-fullscreen").remove();
            $("body .btn-codeview").trigger("click");
        });
    ',
    View::POS_READY,
);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php $form = \yii\bootstrap4\ActiveForm::begin(["id" => "page_edit"]); ?>

                    <?php echo $form->field($model, 'content')
                        ->widget(Summernote::class); ?>

                    <div class="row">
                        <div class="col-12">
                            <?= Html::Button('Save', ['class' => 'btn btn-primary btn-block']) ?>
                        </div>
                    </div>
                                
                    <?php \yii\bootstrap4\ActiveForm::end(); ?>
                </div>
            </div>
        </div> 
    </div>
</div>