<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CJobStatus;
use app\models\CDepartment;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Job */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'job_title')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'job_detail')->textarea(['rows' => 3]) ?>
        </div>

    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'upload_file')->fileInput() ?>
        </div>
        <div class="col-md-4">
            <?php
            $items = CDepartment::find()->all();
            $items = ArrayHelper::map($items, 'id', 'dep');
            ?>
            <?= $form->field($model, 'send_department')->dropDownList($items, ['prompt' => '']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'send_officer')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'job_deadline')->textInput(['type' => 'date']) ?>
        </div>



        <div class="col-md-4">
            <?php
            $items = CJobStatus::find()->all();
            $items = ArrayHelper::map($items, 'id', 'desc');
            if ($model->isNewRecord) {
                $model->status = 1;
            }
            ?>
            <?= $form->field($model, 'status')->dropDownList($items) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
