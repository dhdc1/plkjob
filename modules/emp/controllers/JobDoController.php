<?php

namespace app\modules\emp\controllers;

use Yii;
use app\models\JobDo;
use app\models\JobDoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * JobDoController implements the CRUD actions for JobDo model.
 */
class JobDoController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all JobDo models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new JobDoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JobDo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new JobDo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($job_id) {
        $model = new JobDo();
        $model->job_id = $job_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->upload_file = UploadedFile::getInstance($model, 'upload_file');

            if ($model->upload_file) {
                $model->do_file = $job_id."_".$model->id . "." . $model->upload_file->extension;
                $model->update(FALSE);
                $model->upload($job_id);
            }

            return $this->redirect(['/admin/job/view', 'id' => $job_id]);
        }

        return $this->render('create', [
                    'model' => $model,
                    'job_id' => $job_id
        ]);
    }

    /**
     * Updates an existing JobDo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing JobDo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the JobDo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JobDo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = JobDo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDownload($file) {
        return \Yii::$app->response->sendFile($file);
    }

}
