<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchLocalResponsibility */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="local-responsibility-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'responsibility_type_id') ?>

    <?= $form->field($model, 'branch_id') ?>

    <?= $form->field($model, 'auditorium_id') ?>

    <?= $form->field($model, 'people_id') ?>

    <?php // echo $form->field($model, 'regulation_id') ?>

    <?php // echo $form->field($model, 'files') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
