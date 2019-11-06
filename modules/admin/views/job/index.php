<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\CJobStatus;
use app\models\CDepartment;
use yii\helpers\ArrayHelper;
use app\common\MyHelper;

$search_status = CJobStatus::find()->all();
$search_status = ArrayHelper::map($search_status, 'id', 'desc');

$search_depart = CDepartment::find()->all();
$search_depart = ArrayHelper::map($search_depart, 'id', 'dep');

/* @var $this yii\web\View */
/* @var $searchModel app\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-index">


    <p>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i>เพิ่มรายการ', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => $search_status,
                'value' => function($model) {
                    $color = [
                        '1' => 'red',
                        '2' => 'yellow',
                        '3' => 'green',
                        '4' => 'gray'
                    ];
                    $color = $color[$model->status];
                    return Html::a('<i class="glyphicon glyphicon-search"></i>', ['job/view', 'id' => $model->id], ['class' => "btn btn-sm btn-$color"]);
                },
            ],
            'created_at:date:วันที่',
            //'id',
            'job_title',
            //'job_detail:ntext',
            //'job_file',
            'send_officer:text:มอบหมาย',
            [
                'attribute' => 'send_department',
                'value' => 'department.dep',
                'filter' => $search_depart
            ],
        //'job_deadline:date:วันครบกำหนด',
        //'line_alert',
        //'updated_at',
        //'accepted_at:datetime:รับทราบเมื่อ',
        //'accepted_by',
        //'accepted_officer',
        /* [
          'attribute'=>'status',
          'value'=>'jobstatus.desc',
          'filter'=> $search_status
          ], */
        //'note',
        ],
    ]);
    ?>


</div>
