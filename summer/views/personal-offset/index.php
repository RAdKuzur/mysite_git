<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchPersonalOffset */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Личные защиты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personal-offset-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить защиту', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            ['attribute' => 'teamsList', 'format' => 'raw'],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
