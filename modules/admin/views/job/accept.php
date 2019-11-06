<?php

use app\models\Job;
use yii\widgets\ActiveForm;

$model = Job::findOne($job_id);

$this->title = $model->job_title;
$this->params['breadcrumbs'][] = ['label' => 'รายการ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->job_title;
?>
<div align="center">
    <div>

        <pre><?= $model->job_detail ?></pre>
        <p>Dead-Line : <?= \Yii::$app->formatter->asDatetime($model->job_deadline) ?></p>

    </div>
    <div>

        <?php ActiveForm::begin(); ?>
        <input name='officer' autocomplete="off" placeholder="ระบุชื่อผู้รับงาน" />
        <button>ตกลง</button>
        <?php ActiveForm::end(); ?>
    </div>


</div>

