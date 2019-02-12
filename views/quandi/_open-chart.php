<?php

use app\models\search\QuandiSearch;
use app\widgets\chartJs\ChartJsWidget;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

/**
 * @var QuandiSearch $searchModel
 * @var ArrayDataProvider $dataProvider
 */
?>

<h2>Open chart</h2>

<?= ChartJsWidget::widget([
    'type' => ChartJsWidget::TYPE_LINE,
    'data' => [
        'labels' => array_map(function ($model) use ($searchModel) {
            $attribute = $searchModel->getAttributeByLabel(QuandiSearch::DATE_FIELD);

            if ($attribute === null) {
                return null;
            }

            return ArrayHelper::getValue($model, $attribute);
        }, $dataProvider->getModels()),
        'datasets' => [
            [
                'backgroundColor' => [
                    "#3594C3",
                ],
                'label' => 'Open',
                'data' => array_map(function ($model) use ($searchModel) {
                    $attribute = $searchModel->getAttributeByLabel(QuandiSearch::OPEN_FIELD);

                    if ($attribute === null) {
                        return null;
                    }

                    return ArrayHelper::getValue($model, $attribute);
                }, $dataProvider->getModels()),
            ],
        ],
    ],
    'options' => [],
]); ?>
