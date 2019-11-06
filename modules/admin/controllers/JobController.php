<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Job;
use app\models\JobSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\MyHelper;
use yii\web\UploadedFile;

/**
 * JobController implements the CRUD actions for Job model.
 */
class JobController extends Controller {

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
     * Lists all Job models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new JobSearch();

        if (!MyHelper::isAdmin() && MyHelper::isUser()) {
            $params = Yii::$app->request->queryParams;
            $params['JobSearch']['send_department'] = \Yii::$app->user->identity->profile->location;
            //$searchModel->send_department = \Yii::$app->user->identity->profile->location;
            $dataProvider = $searchModel->search($params);
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }




        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Job model.
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
     * Creates a new Job model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        if (!MyHelper::isAdmin()) {
            return $this->redirect(['/user/login']);
        }

        $model = new Job();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->upload_file = UploadedFile::getInstance($model, 'upload_file');
            if ($model->upload_file) {
                $model->job_file = $model->id . "_" . date('YmdHis') .".". $model->upload_file->extension;
                $model->update(FALSE);
                $model->upload();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Job model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        if (!MyHelper::isAdmin()) {
            return $this->redirect(['/user/login']);
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->upload_file = UploadedFile::getInstance($model, 'upload_file');


            if ($model->upload_file) {
                $model->job_file = $model->job_file . "|" . $model->id . "_" . date('YmdHis') . "." . $model->upload_file->extension;
                $model->update(FALSE);
                $model->upload();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Job model.
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
     * Finds the Job model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Job the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Job::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAccept($job_id = NULL) {
        if (\Yii::$app->request->isPost) {
            $model = Job::findOne($job_id);
            $model->accepted_at = date('Y-m-d H:i:s');
            $model->accepted_by = Yii::$app->user->identity->username;
            $model->accepted_officer = \Yii::$app->request->post('officer');
            $model->status = 2;
            $model->save(FALSE);
            return $this->redirect(['job/view', 'id' => $job_id]);
        }
        return $this->render('accept', [
                    'job_id' => $job_id
        ]);
    }

    public function actionDownload($file) {
        return \Yii::$app->response->sendFile($file);
    }

    public function actionSuccess($id) {
        $model = Job::findOne($id);
        $model->status = 3;
        $model->save(FALSE);
        return $this->redirect(['view', 'id' => $id]);
    }

}
