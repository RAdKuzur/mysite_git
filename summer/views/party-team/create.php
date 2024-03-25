<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PartyTeam */

$this->title = 'Create Party Team';
$this->params['breadcrumbs'][] = ['label' => 'Party Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="party-team-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelPersonals' => $modelPersonals,
    ]) ?>

</div>
