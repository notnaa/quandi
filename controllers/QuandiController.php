<?php

namespace app\controllers;

use app\models\search\QuandiSearch;
use yii\web\Controller;

/**
 * Class QuandiController
 *
 * @package app\controllers
 */
class QuandiController extends Controller
{
    /**
     * @return string
     */
    public function actionSearch()
    {
        $searchModel = new QuandiSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
