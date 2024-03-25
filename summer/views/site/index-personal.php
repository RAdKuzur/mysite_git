<?php

use app\models\Team;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PersonalOffset */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?php

$branch = \app\models\PersonalOffset::find()->all();
$items = \yii\helpers\ArrayHelper::map($branch,'id','name');
$params = [
    'prompt' => '',
];
echo $form->field($model, 'name')->dropDownList($items,$params)->label('Личная защита');
?>

<div class="form-group">
    <?= Html::submitButton('ОК', ['class' => 'btn btn-success']) ?>
</div>

<?php
    $teams = \app\models\PartyPersonal::find()->where(['personal_offset_id' => $model->id])->all();
?>
<h3><?php echo $model->name; ?></h3>
<table class="table table-bordered">
    <tr>
        <td></td>
        <td><img src="water.png" height="50px" width="50px"/></td>
        <td><img src="trash.png" height="50px" width="50px"/></td>
        <td><img src="man.jpg" height="50px" width="50px"/></td>
    </tr>
    <?php
    foreach ($teams as $team)
        echo '<tr><td>'.$team->secondname.' '.$team->firstname.' '.$team->patronymic.'</td><td>'.Html::a('+10', \yii\helpers\Url::to(['site/plus-ten-p', 'id' => $team->id]), ['class' => 'btn btn-success inline']).'</td>'.
            '<td>'.Html::a('+2', \yii\helpers\Url::to(['site/plus-two-p', 'id' => $team->id]), ['class' => 'btn btn-success inline']).'</td>'.
            '<td>'.Html::a('-1', \yii\helpers\Url::to(['site/minus-one-p', 'id' => $team->id]), ['class' => 'btn btn-danger inline']).'</tr>';
    ?>
</table>

<?php ActiveForm::end(); ?>