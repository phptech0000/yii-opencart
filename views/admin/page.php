<?php

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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
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
                                        <div class="col-6">
                                            <a type="button" href="/admin/page/edit?file=<?= $file ?>" class="btn btn-block btn-primary">
                                                Edit
                                            </a>
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
</div>