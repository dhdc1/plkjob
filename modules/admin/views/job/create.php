<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = 'เพิ่ม';
$this->params['breadcrumbs'][] = ['label' => 'รายการ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-danger" style="padding: 15px">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
