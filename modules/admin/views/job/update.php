<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = $model->job_title;
//$this->params['breadcrumbs'][] = ['label' => 'รายการ', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->job_title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ปรับปรุง';
?>
<div class="panel panel-danger" style="padding: 15px">   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
