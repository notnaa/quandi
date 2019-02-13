<?php

use app\models\search\QuandiSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var QuandiSearch $searchModel
 * @var ArrayDataProvider $dataProvider
 */

$this->title = 'Quandi form';
?>

<h1>
    <?= Html::encode($this->title); ?>
</h1>

<?php Pjax::begin(); ?>

<?= $this->render('_filter', [
    'searchModel' => $searchModel,
]); ?>
<?= $this->render('_charts', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]); ?>
<?= $this->render('_lists', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]); ?>

<?php Pjax::end(); ?>
