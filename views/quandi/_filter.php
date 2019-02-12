<?php

use app\models\QuandiSearch;
use kartik\date\DatePicker;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var ArrayDataProvider $dataProvider
 * @var QuandiSearch $searchModel
 */

$datePickerCfg = [
    'language' => 'en',
    'readonly' => true,
    'pluginOptions' => [
        'autoclose' => true,
        'todayHighlight' => true,
        'format' => 'yyyy-mm-dd',
    ],
];

$form = ActiveForm::begin([
    'action' => ['search'],
    'method' => 'get',
]);
?>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <?= $form->field($searchModel, 'companySymbol'); ?>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <?= $form->field($searchModel, 'email'); ?>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <?= $form->field($searchModel, 'startAt')->widget(DatePicker::class, $datePickerCfg)->label('Start at'); ?>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <?= $form->field($searchModel, 'endAt')->widget(DatePicker::class, $datePickerCfg)->label('End at'); ?>
        </div>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']); ?>
    <?= Html::a('Reset', ['search'], ['class' => 'btn btn-default']); ?>
</div>

<?php ActiveForm::end(); ?>
