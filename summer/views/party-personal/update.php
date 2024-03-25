<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PartyPersonal */

$this->title = 'Update Party Personal: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Party Personals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="party-personal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelPersonals' => $modelPersonals,
    ]) ?>

</div>
