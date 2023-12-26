<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\work\UserWork */

?>
<div style="width:100%; height:1px; clear:both;"></div>
<div class="change-password">
    <?= $this->render('menu') ?>
    <div class="content-container col-xs-8" style="float: left">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'oldPass')->textInput() ?>
        <?= $form->field($model, 'newPass')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php $form = ActiveForm::end(); ?>
    </div>

</div>
<div style="width:100%; height:1px; clear:both;"></div>