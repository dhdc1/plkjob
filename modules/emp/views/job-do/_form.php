<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JobDo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-do-form">

    <?php $form = ActiveForm::begin(); ?>

   

    <?= $form->field($model, 'do_detail')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'upload_file')->fileInput() ?>

  

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
