<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PersonalOffset */

$this->title = 'Редактировать защиту: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Личные защиты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="personal-offset-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTeams' => $modelTeams,
    ]) ?>

</div>
