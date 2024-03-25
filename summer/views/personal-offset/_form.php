<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PersonalOffset */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personal-offset-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название защиты') ?>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i>Команды</h4></div>
            <?php
            $teams = \app\models\PartyPersonal::find()->where(['personal_offset_id' => $model->id])->all();
            if ($teams != null)
            {
                echo '<table class="table table-bordered"><tr><td><b>ФИО</b></tr>';
                foreach ($teams  as $team) {
                    echo '<tr><td style="padding-left: 20px"><h4>'.$team->secondname.' '.$team->firstname.' '.$team->patronymic.'</h4></td><td>&nbsp;'.Html::a('Удалить', \yii\helpers\Url::to(['personal-offset/delete-party-personal', 'id' => $team->id, 'modelId' => $model->id]), ['class' => 'btn btn-danger']).'</td></tr>';
                }
                echo '</table>';
            }
            ?>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper1', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items1', // required: css class selector
                    'widgetItem' => '.item1', // required: css class
                    'limit' => 20, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelTeams[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'eventExternalName',
                    ],
                ]); ?>

                <div class="container-items1" ><!-- widgetContainer -->
                    <?php foreach ($modelTeams as $i => $modelTeam): ?>
                        <div class="item1 panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left"></h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <div>
                                    <div class="col-xs-4">
                                        <?= $form->field($modelTeam, "[{$i}]secondname")->textInput(['maxlength' => true])->label('Фамилия') ?>
                                    </div>
                                    <div class="col-xs-4">
                                        <?= $form->field($modelTeam, "[{$i}]firstname")->textInput(['maxlength' => true])->label('Имя') ?>
                                    </div>
                                    <div class="col-xs-4">
                                        <?= $form->field($modelTeam, "[{$i}]patronymic")->textInput(['maxlength' => true])->label('Отчество') ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

