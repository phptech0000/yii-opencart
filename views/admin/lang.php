<?php

use yii\bootstrap4\LinkPager;
use yii\web\View;

$i = 1;

$this->title = 'Language';
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
                                        <?php if($field->lang_code !== "en"){ ?>
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