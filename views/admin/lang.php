<?php

use yii\bootstrap4\LinkPager;
use yii\web\View;

$i = 1;

$this->title = 'Language';
$this->registerJs(
    '
    $(\'select[name=default]\').change(function(){
        if($(this).val() == 1){
            window.location.href = "/admin/lang/default/" + $(this).attr("data-id");
        }
    })
    ',
    View::POS_READY,
);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 mb-2" style="text-align: -webkit-right;">
                        <a type="button" href="/admin/lang/create" class="btn btn-block btn-primary" style="width: 100px;">
                            Add
                        </a>
                    </div>
                    <div class="col-lg-12" style="overflow: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Language Code</th>
                                    <th>Language</th>
                                    <th>Is Default</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($lang as $field){ ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $field->lang_code ?></td>
                                    <td><?= $field->lang ?></td>
                                    <td>
                                        <select class="form-control" name="default" data-id="<?php echo $field->id ?>">
                                            <option value=0 <?php if($field->is_default === 0){ ?> selected <?php } ?>>FALSE</option>
                                            <option value=1 <?php if($field->is_default === 1){ ?> selected <?php } ?>>TRUE</option>
                                        </select>
                                    </td>
                                    <td>
                                        <?php if(!$field->is_default){ ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <a type="button" href="/admin/lang/edit/<?= $field->id ?>" class="btn btn-block btn-primary">
                                                    Edit
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a type="button" href="/admin/lang/delete/<?= $field->id ?>" class="btn btn-block  btn-danger">
                                                    Delete
                                                </a>
                                            </div>
                                        </div>   
                                        <?php } ?>                         
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>