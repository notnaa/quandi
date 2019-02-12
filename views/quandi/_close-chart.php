<?php

use app\models\QuandiSearch;
use app\widgets\chartJs\ChartJsWidget;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

/**
 * @var QuandiSearch $searchModel
 * @var ArrayDataProvider $dataProvider
 */
?>

<h2>Close chart</h2>

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
                    "#F99E21",
                ],
                'label' => QuandiSearch::CLOSE_FIELD,
                'data' => array_map(function ($model) use ($searchModel) {
                    $attribute = $searchModel->getAttributeByLabel(QuandiSearch::CLOSE_FIELD);

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
