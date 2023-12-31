<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchPeopleMaterialObject */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список материально ответственных работников';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="people-material-object-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить новую ответственность', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            ['attribute' => 'peopleName', 'format' => 'raw'],
            ['attribute' => 'materialObjectName', 'format' => 'raw'],
            'acceptance_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
