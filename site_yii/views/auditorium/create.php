<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\work\AuditoriumWork */

$this->title = 'Добавить помещение';
$this->params['breadcrumbs'][] = ['label' => 'Помещения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auditorium-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
