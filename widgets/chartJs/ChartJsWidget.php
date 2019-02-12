<?php

namespace app\widgets\chartJs;

use phpnt\chartJS\ChartJs;

/**
 * Class ChartJsWidget
 *
 * @package app\widgets\chartJs
 */
class ChartJsWidget extends ChartJs
{
    /**
     * @inheritdoc
     */
    public function registerScript()
    {
        $view = $this->getView();
        ChartJsWidgetAsset::register($view);

        $js = <<< JS
            var ctx = $("#$this->id");
            var myChart = new Chart(ctx, {
                type: '$this->type',
                data: $this->data,
                options: $this->options
            });
JS;
        $view->registerJs($js);
    }
}
