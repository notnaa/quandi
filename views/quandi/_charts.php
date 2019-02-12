<?php

use app\models\QuandiSearch;
use yii\data\ArrayDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var QuandiSearch $searchModel
 * @var ArrayDataProvider $dataProvider
 */
?>

<?= $this->render('_common-chart', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]); ?>
<?= $this->render('_open-chart', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]); ?>
<?= $this->render('_close-chart', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]); ?>
