<?php

use yii\bootstrap4\LinkPager;
use yii\web\View;

$this->title = 'User';
$this->registerJs(
    '
    $(\'#per_page\').change(function(){
        window.location.href = "/admin/user?page=1&per-page=" + $(\'#per_page\').val();
    })
    ',
    View::POS_READY,
);
$i = $j = $pagination->limit * $pagination->page + 1;
?>
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12" style="overflow: auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Order ID</th>
                                <th>Order Status</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Street1</th>
                                <th>Street2</th>
                                <th>ZIP</th>
                                <th>City</th>
                                <th>Country</th>
                                <th>Language</th>
                                <th>IP</th>
                                <th>UA</th>
                                <th>UOI</th>
                                <th>PaymentMethod</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($models as $field){ ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $field->date ?></td>
                                    <td><?= $field->id ?></td>
                                    <td><?= $field->order_status ?></td>
                                    <td><?= $field->first_name ?></td>
                                    <td><?= $field->last_name ?></td>
                                    <td><?= $field->email ?></td> 
                                    <td><?= $field->phone ?></td> 
                                    <td><?= $field->street1 ?></td> 
                                    <td><?= $field->street2 ?></td> 
                                    <td><?= $field->zip ?></td> 
                                    <td><?= $field->city ?></td> 
                                    <td><?= $field->country ?></td> 
                                    <td><?= strtoupper($field->lang) ?></td> 
                                    <td><?= $field->ip ?></td> 
                                    <td><?= $field->ua ?></td> 
                                    <td><?= $field->uoi ?></td> 
                                    <td><?= $field->payment_method ?></td> 
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <select class="form-control" style="width: 100px" id="per_page">
                                <?php foreach($pageSizes as $item){ ?>
                                    <option value="<?= $item ?>" 
                                    <?php if($item == $_GET['per-page']){ ?>
                                        selected
                                    <?php } ?>
                                    ><?= $item ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3" style="margin-top: 7px;">
                        <p>Showing <?= $j ?> to <?= $i - 1 ?> of <?= $pagination->totalCount ?> entries</p>
                    </div>
                    <div class="col-5">
                        
                        <?=
                            LinkPager::widget([
                                'pagination' => $pagination,
                                'options' => ['class' => 'pagination pagination-md m-0 float-right'],
                                'maxButtonCount' => 6,
                                'firstPageLabel' => 'First',
                                'lastPageLabel' => 'Last',
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>