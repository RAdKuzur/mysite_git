<?php

use app\models\Team;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Team */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?php

$branch = \app\models\Team::find()->all();
$items = \yii\helpers\ArrayHelper::map($branch,'id','name');
$params = [
    'prompt' => '',
];
echo $form->field($model, 'name')->dropDownList($items,$params)->label('Командная защита');
?>

<div class="form-group">
    <?= Html::submitButton('ОК', ['class' => 'btn btn-success']) ?>
</div>

<?php
    $teams = \app\models\PartyTeam::find()->where(['team_id' => $model->id])->all();
?>
<h3><?php echo $model->name; ?></h3>
<table class="table table-bordered">
    <?php
    foreach ($teams as $team)
        echo '<tr><td style="color: '.$team->color->code.'"><b>'.$team->team_name.' ('.$team->color->name.')'.'</b></td><td>'.Html::a('Выбрать', \yii\helpers\Url::to(['site/choose-color', 'id' => $team->id]), ['class' => 'btn btn-primary']).'</td></tr>';
    ?>
</table>

<?php ActiveForm::end(); ?>