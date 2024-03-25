<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PartyPersonal */

$this->title = 'Create Party Personal';
$this->params['breadcrumbs'][] = ['label' => 'Party Personals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="party-personal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelPersonals' => $modelPersonals,
    ]) ?>

</div>
