<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\extended\ForeignEventReportModel */
/* @var $form yii\bootstrap\ActiveForm */
?>

<?php
$this->title = 'Генерация отчета по мероприятиям';
?>

<style>
    .block-report{
        background: #e9e9e9;
        width: auto;
        padding: 10px 10px 0 10px;
        margin-bottom: 20px;
        border-radius: 10px;
        margin-right: 10px;
    }
</style>

<div class="man-hours-report-form">

    <h5><b>Введите период для генерации отчета</b></h5>
    <div class="col-xs-6 block-report">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'start_date', ['template' => '{label}&nbsp;{input}',
            'options' => ['class' => 'form-group form-inline']])->widget(\yii\jui\DatePicker::class, [
            'dateFormat' => 'php:Y-m-d',
            'language' => 'ru',
            'options' => [
                'placeholder' => '',
                'class'=> 'form-control',
                'autocomplete'=>'off'
            ],
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '2000:2050',
            ]])->label('С') ?>
    </div>

    <div class="col-xs-6 block-report">
        <?= $form->field($model, 'end_date', [ 'template' => '{label}&nbsp;{input}',
            'options' => ['class' => 'form-group form-inline']])->widget(\yii\jui\DatePicker::class, [
            'dateFormat' => 'php:Y-m-d',
            'language' => 'ru',
            'options' => [
                'placeholder' => '',
                'class'=> 'form-control',
                'autocomplete'=>'off'
            ],
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '2000:2050',
            ]])->label('По') ?>
    </div>
    <div class="panel-body" style="padding: 0; margin: 0"></div>
    <div class="col-xs-8 block-report">
        <?php
        $branchs = \app\models\work\BranchWork::find()->all();
        $arr = \yii\helpers\ArrayHelper::map($branchs, 'id', 'name');
        echo $form->field($model, 'branch')->checkboxList($arr, ['item' => function ($index, $label, $name, $checked, $value) {
            return
                '<div class="checkbox" style="font-size: 16px; font-family: Arial; color: black;">
                    <label for="branch-'. $index .'">
                        <input id="branch-'. $index .'" name="'. $name .'" type="checkbox" '. $checked .' value="'. $value .'">
                        '. $label .'
                    </label>
                </div>';
        }])->label('Отдел');
        ?>
    </div>
    <div class="col-xs-8 block-report">
        <?php
        $focus = \app\models\work\FocusWork::find()->all();
        $arr = \yii\helpers\ArrayHelper::map($focus, 'id', 'name');
        echo $form->field($model, 'focus')->checkboxList($arr, ['item' => function ($index, $label, $name, $checked, $value) {
            return
                '<div class="checkbox" style="font-size: 16px; font-family: Arial; color: black;">
                    <label for="focus-'. $index .'">
                        <input id="focus-'. $index .'" name="'. $name .'" type="checkbox" '. $checked .' value="'. $value .'">
                        '. $label .'
                    </label>
                </div>';
        }])->label('Направленность');
        ?>
    </div>
    <div class="col-xs-8 block-report">
        <?php
        $arr = ['1' => 'Бюджет', '0' => 'Внебюджет'];
        echo $form->field($model, 'budget')->checkboxList($arr, ['item' => function ($index, $label, $name, $checked, $value) {
            return
                '<div class="checkbox" style="font-size: 16px; font-family: Arial; color: black;">
                    <label for="budget-'. $index .'">
                        <input disabled id="budget-'. $index .'" name="'. $name .'" type="checkbox" '. $checked .' value="'. $value .'">
                        '. $label .'
                    </label>
                </div>';
        }])->label('Основа');
        ?>
    </div>

    <div class="panel-body" style="padding: 0; margin: 0"></div>

    <div class="col-xs-8 block-report">
        <?php
        $focus = \app\models\work\AllowRemoteWork::find()->all();
        $arr = \yii\helpers\ArrayHelper::map($focus, 'id', 'name');
        echo $form->field($model, 'allow_remote')->checkboxList($arr, ['item' => function ($index, $label, $name, $checked, $value) {
            return
                '<div class="checkbox" style="font-size: 16px; font-family: Arial; color: black;">
                    <label for="allow-'. $index .'">
                        <input id="allow-'. $index .'" name="'. $name .'" type="checkbox" '. $checked .' value="'. $value .'">
                        '. $label .'
                    </label>
                </div>';
        }])->label('Форма реализации');
        ?>
    </div>

    <div class="panel-body" style="padding: 0; margin: 0"></div>

    <div class="col-xs-8 block-report">
        <?php
        $arr = ['1' => 'Победители', '0' => 'Призеры'];
        echo $form->field($model, 'prize')->checkboxList($arr, ['item' => function ($index, $label, $name, $checked, $value) {
            return
                '<div class="checkbox" style="font-size: 16px; font-family: Arial; color: black;">
                    <label for="prize-'. $index .'">
                        <input id="prize-'. $index .'" name="'. $name .'" type="checkbox" '. $checked .' value="'. $value .'">
                        '. $label .'
                    </label>
                </div>';
        }])->label('Победители и призеры');
        ?>
    </div>

    <div class="col-xs-8 block-report">
        <?php
        $level = \app\models\work\EventLevelWork::find()->all();
        $arr = \yii\helpers\ArrayHelper::map($level, 'id', 'name');
        echo $form->field($model, 'level')->checkboxList($arr, ['item' => function ($index, $label, $name, $checked, $value) {
            return
                '<div class="checkbox" style="font-size: 16px; font-family: Arial; color: black;">
                    <label for="level-'. $index .'">
                        <input id="level-'. $index .'" name="'. $name .'" type="checkbox" '. $checked .' value="'. $value .'">
                        '. $label .'
                    </label>
                </div>';
        }])->label('Уровень мероприятия');
        ?>
    </div>

    <div class="panel-body" style="padding: 0; margin: 0"></div>

    <div class="form-group">
        <?= Html::submitButton('Генерировать отчет', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script>

</script>