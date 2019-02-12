<?php

namespace app\widgets\chartJs;

use phpnt\chartJS\ChartJSAsset;
use yii\web\JqueryAsset;

/**
 * Class ChartJsWidgetAsset
 *
 * @package app\widgets\chartJs
 */
class ChartJsWidgetAsset extends ChartJSAsset
{
    /** @var string */
    public $sourcePath = __DIR__ . '/assets/';

    /** @var array */
    public $js = [
        'js/chart.js',
    ];

    /** @var array */
    public $depends = [
        JqueryAsset::class,
    ];
}
