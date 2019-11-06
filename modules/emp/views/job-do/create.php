<?php

use yii\helpers\Html;
use app\models\Job;

/* @var $this yii\web\View */
/* @var $model app\models\JobDo */

$job = Job::findOne($job_id);

$this->title = $job->job_title;
//$this->params['breadcrumbs'][] = ['label' => 'Job Dos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-do-create panel panel-warning" style="padding: 15px">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
