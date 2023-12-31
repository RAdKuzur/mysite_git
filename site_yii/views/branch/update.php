<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\work\BranchWork */

$this->title = 'Редактировать отдел: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Отделы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="branch-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelAuditorium' => $modelAuditorium,
    ]) ?>

</div>
