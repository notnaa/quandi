<?php

use app\models\QuandiSearch;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

/**
 * @var QuandiSearch $searchModel
 * @var ArrayDataProvider $dataProvider
 */
?>

<h2>Data table</h2>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $searchModel->getColumns(),
]); ?>
