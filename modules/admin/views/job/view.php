<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\common\MyHelper;
use app\models\JobDo;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = $model->job_title;
$this->params['breadcrumbs'][] = ['label' => 'รายการ', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'No ' . $model->id;
\yii\web\YiiAsset::register($this);
?>
<div class="job-view">


    <div class="row">
        <div class="col-md-7">            
            <div style="padding: 5px" class="panel panel-danger"> 

                <div style="display:<?= MyHelper::isAdmin() ? '' : 'none' ?>">
                    <?=
                    Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-pink',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ])
                    ?>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php if ($model->status <> 3): ?>
                        <?= Html::a('ยืนยัน Success', ['success', 'id' => $model->id], ['class' => 'btn btn-green', 'data-confirm' => 'งานนี้สำเร็จแล้ว-ยืนยัน?']) ?>
                    <?php endif; ?>
                    <?php
                    $color = ['1' => 'red', '2' => 'yellow', '3' => 'green', '4' => 'gray'];
                    ?>

                    <div class="pull-right" style="background-color: <?= $color[$model->status] ?>;padding: 15px"></div>
                </div>
                <div class="pull-right" style="display: <?= MyHelper::isAdmin() ? 'none' : '' ?>;background-color: <?= $color[$model->status] ?>;padding: 15px"></div>

                <h4><?= $model->job_title ?></h4>
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        //'job_title',
                        //'created_at:date:มอบหมายเมื่อ',
                        'job_detail:ntext',
                        [
                            'attribute' => 'job_file',
                            'format' => 'raw',
                            'value' => function($model) {
                                $link = explode("|", $model->job_file);
                                $a = "";
                                foreach ($link as $l) {
                                    $a .= Html::a($l, ['download', "file" => "./attach/admin/$l"]) . " | ";
                                }
                                return $a;
                            }
                        ],
                        'department.dep',
                        'send_officer',
                        'job_deadline:date:วันครบกำหนด',
                        //'line_alert',
                        //'updated_at',
                        //'accepted_at:date:รับทราบเมื่อ',
                        //'accepted_by',
                        //'accepted_officer',
                        'jobstatus.desc',
                    //'note',
                    ],
                ])
                ?>
            </div>

        </div>
        <div class="col-md-5">            
            <div style="padding: 5px" class="panel panel-danger">

                <div style="display:<?= MyHelper::isUser() ? '' : 'none' ?>">
                    <?php if (empty($model->accepted_by) && !MyHelper::isAdmin()) : ?>
                        <?= Html::a('รับทราบ', ['accept', 'job_id' => $model->id], ['class' => 'btn btn-pink']) ?>
                    <?php endif; ?>
                    <?php if (!empty($model->accepted_by) && !MyHelper::isAdmin()): ?>
                        <?= Html::a('รายงานความก้าวหน้า', ['/emp/job-do/create', 'job_id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php endif; ?>

                </div>

                <h4>ความก้าวหน้า</h4>
                <?php
                $job_do = JobDo::find()->where(['job_id' => $model->id])->all();
                ?>
                <ul>
                    <li> <?= \Yii::$app->formatter->asDatetime($model->created_at) ?> -- มอบหมายงาน</li>
                    <?php if (!empty($model->accepted_at)): ?>
                        <li> <?= \Yii::$app->formatter->asDatetime($model->accepted_at) ?> -- รับทราบ (<?= $model->accepted_officer ?>)</li>
                    <?php endif; ?>

                    <?php foreach ($job_do as $value): ?>
                        <li> 
                            <?= \Yii::$app->formatter->asDatetime($value['created_at']) ?> 
                            --
                            <?= $value['do_detail'] ?> 
                            <?= Html::a($value['do_file'], ['download', "file" => "./attach/emp/$value[do_file]"]) ?>
                        </li>
                    <?php endforeach; ?>
                    <?php if ($model->status == 3): ?>
                        <li><span style="padding: 3px;background-color: green;color: white">สำเร็จแล้ว</span></li>
                        <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

</div>
