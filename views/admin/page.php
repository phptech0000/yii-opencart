<?php
use yii\helpers\Html;
use yii\bootstrap4\LinkPager;
use yii\web\View;

$i = 1;

$this->title = 'Page';
// $this->registerJs(
//     '
//     $(\'#per_page\').change(function(){
//         window.location.href = "/admin/user?page=1&per-page=" + $(\'#per_page\').val();
//     })
//     ',
//     View::POS_READY,
// );
?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'page-create-form']) ?>
                    <div class="row">
                        <div class="col-lg-4">
                        <?= $form->field($model, 'lang_code', [
                                    'options' => ['class' => 'form-group has-feedback'],
                                    'template' => '{beginWrapper}{input}{error}{endWrapper}',
                                    'wrapperOptions' => ['class' => 'input-group mb-3']
                                ])
                            ->label(false)
                            ->dropdownList($language,
                            ['prompt'=>'Select Language']) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'file_name', [
                                    'options' => ['class' => 'form-group has-feedback'],
                                    'template' => '{beginWrapper}{input}{error}{endWrapper}',
                                    'wrapperOptions' => ['class' => 'input-group mb-3']
                                ])
                            ->label(false)
                            ->textInput(['placeholder' => $model->getAttributeLabel('file_name')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= Html::submitButton('Create', ['class' => 'btn btn-primary btn-block']) ?>
                        </div>
                    </div>
                    <?php \yii\bootstrap4\ActiveForm::end(); ?>
                </div>
                <div class="col-lg-12" style="overflow: auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($files as $file){ ?>
                            <?php if($file != "." && $file != ".."){ ?>
                                <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $file ?></td>
                                <td>
                                    <div class="row">
                                        <div class="col-6">
                                            <a type="button" href="/admin/page/edit?file=<?= $file ?>" class="btn btn-block btn-primary">
                                                Edit
                                            </a>
                                        </div>  
                                        <div class="col-6">
                                            <a type="button" href="/admin/page/delete?file=<?= $file ?>" class="btn btn-block btn-danger">
                                                Delete
                                            </a>
                                        </div>    
                                    </div>              
                                </td>
                            </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
</div>