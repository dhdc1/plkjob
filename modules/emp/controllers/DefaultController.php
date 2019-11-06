<?php

namespace app\modules\emp\controllers;

use yii\web\Controller;

/**
 * Default controller for the `emp` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
