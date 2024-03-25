<?php

use yii\helpers\Html;
use app\models\History;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model app\models\PartyTeam */

?>

<style type="text/css">
    .score {
        position: fixed;
        background-color: #f5f8f9;
        width: 90%;
        padding-left: 1%;
        padding-top: 1%;
        padding-right: 1%;
        padding-bottom: 1%; /*104.5px is half of the button width*/
        border: 3px solid <?php echo $model->color->code; ?>;
        border-radius: 10px;
    }

    .plus-button{
        background-color: #3b8c3b;
        color: white;
        font-weight: 400;
        font-size: 30px;
        height: 50px;
        width: 50px;
        margin-left: 10px;
        border: 1px solid #2f752f;
        border-radius: 5px;
        margin-top: 10px;
    }

    .minus-button{
        background-color: #b24747;
        color: white;
        font-weight: 400;
        font-size: 30px;
        height: 50px;
        width: 50px;
        margin-left: 10px;
        border: 1px solid #a14141;
        border-radius: 5px;
        margin-top: 10px;
    }
</style>

<div class="form-group" style="margin-bottom: 80px; margin-top: -10px;">
    <div class="score">
    	<span style="font-size: 20px; font-family: Tahoma; color: <?php echo $model->color->code; ?>"><b>Счет: <?php echo $model->total_score; ?></b></span>
    </div>
</div>

<?php

$visibleQ = $model->lastBranch == 1 ? 'block' : 'none';
$visibleT = $model->lastBranch == 2 ? 'block' : 'none';
$visibleTimer = $model->lastBranch == -1 ? 'block' : 'none';


echo '<button class="btn btn-primary" onclick="OpenBlock(\'quant\')"><span style="font-size: 30px"><b>Кванториум</b></span></button>';

echo '<div id="quant" style="display: '.$visibleQ.'">';
echo '<h3>Голосование в <b>'.$model->team->name.'</b> за команду <b><font style="color: '.$model->color->code.'">'.$model->team_name.' ('.$model->color->name.')</font></b></h3>';
echo '<br>';
echo '<table class="table">';
echo '<tr>';
echo '<td>';
echo Html::a('+5 баллов', \yii\helpers\Url::to(['site/plus', 'numb' => 5, 'id' => $model->id, 'branch' => 1]), ['class' => 'btn btn-success inline']);
echo '</td>';
echo '<td>';
echo Html::a('-5 баллов', \yii\helpers\Url::to(['site/minus', 'numb' => 5, 'id' => $model->id, 'branch' => 1]), ['class' => 'btn btn-danger inline']);
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo Html::a('+3 баллов', \yii\helpers\Url::to(['site/plus', 'numb' => 3, 'id' => $model->id, 'branch' => 1]), ['class' => 'btn btn-success inline']);
echo '</td>';
echo '<td>';
echo Html::a('-3 баллов', \yii\helpers\Url::to(['site/minus', 'numb' => 3, 'id' => $model->id, 'branch' => 1]), ['class' => 'btn btn-danger inline']);
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo Html::a('+1 баллов', \yii\helpers\Url::to(['site/plus', 'numb' => 1, 'id' => $model->id, 'branch' => 1]), ['class' => 'btn btn-success inline']);
echo '</td>';
echo '<td>';
echo Html::a('-1 баллов', \yii\helpers\Url::to(['site/minus', 'numb' => 1, 'id' => $model->id, 'branch' => 1]), ['class' => 'btn btn-danger inline']);
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '</table>';
echo '<br><br>';
echo '<hr>';
echo '</div>';


echo '<hr>';


echo '<button class="btn btn-primary" onclick="OpenBlock(\'techno\')"><span style="font-size: 30px"><b>Технопарк</b></span></button>';
echo '<div id="techno" style="display: '.$visibleT.'">';
echo '<h3>Голосование в <b>'.$model->team->name.'</b> за команду <b><font style="color: '.$model->color->code.'">'.$model->team_name.' ('.$model->color->name.')</font></b></h3>';
echo '<br>';

$form = ActiveForm::begin();

echo $form->field($model, 'id')->hiddenInput()->label(false);
echo $form->field($model, 'lastBranch')->hiddenInput(['value' => 2])->label(false);

echo '<div style="display: inline-block; vertical-align: bottom">';
echo $form->field($model, 'score')->textInput(['id' => 'score-input', 'style' => 'height: 50px; width: 170px', 'type' => 'number'])->label('Кол-во баллов');
echo '</div>';
echo '<div style="display: inline-block; vertical-align: bottom; padding-bottom: 16px"><button onclick="AddAtribute(1)" formaction="index.php?r=site/plus-val" class="plus-button">+</button></div>';
echo '<div style="display: inline-block; vertical-align: bottom; padding-bottom: 16px"><button onclick="AddAtribute(2)" formaction="index.php?r=site/minus-val" class="minus-button">-</button></div>';
ActiveForm::end();

/*echo '<table class="table">';

echo '<tr>';
echo '<td>';
echo Html::a('+8 баллов', \yii\helpers\Url::to(['site/plus', 'numb' => 8, 'id' => $model->id, 'branch' => 2]), ['class' => 'btn btn-success inline']);
echo '</td>';
echo '<td>';
echo Html::a('-8 баллов', \yii\helpers\Url::to(['site/minus', 'numb' => 8, 'id' => $model->id, 'branch' => 2]), ['class' => 'btn btn-danger inline']);
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>';
echo Html::a('+6 баллов', \yii\helpers\Url::to(['site/plus', 'numb' => 6, 'id' => $model->id, 'branch' => 2]), ['class' => 'btn btn-success inline']);
echo '</td>';
echo '<td>';
echo Html::a('-6 баллов', \yii\helpers\Url::to(['site/minus', 'numb' => 6, 'id' => $model->id, 'branch' => 2]), ['class' => 'btn btn-danger inline']);
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo Html::a('+5 баллов', \yii\helpers\Url::to(['site/plus', 'numb' => 5, 'id' => $model->id, 'branch' => 2]), ['class' => 'btn btn-success inline']);
echo '</td>';
echo '<td>';
echo Html::a('-5 баллов', \yii\helpers\Url::to(['site/minus', 'numb' => 5, 'id' => $model->id, 'branch' => 2]), ['class' => 'btn btn-danger inline']);
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>';
echo Html::a('+1 баллов', \yii\helpers\Url::to(['site/plus', 'numb' => 1, 'id' => $model->id, 'branch' => 2]), ['class' => 'btn btn-success inline']);
echo '</td>';
echo '<td>';
echo Html::a('-1 баллов', \yii\helpers\Url::to(['site/minus', 'numb' => 1, 'id' => $model->id, 'branch' => 2]), ['class' => 'btn btn-danger inline']);
echo '</td>';
echo '</tr>';
echo '</table>';*/
echo '</div>';
echo '<hr>';

?>

<button class="btn btn-link" style="font-size: 18px" onclick="ShowHistory()"><u>Показать историю</u></button>

<div id="his1" style="display: none; margin-top: 10px">
	<table class="table table-bordered" style="max-width: 50%">
		<tr>
			<td style="max-width: 20%;"><b>№</b></td>
			<td style="max-width: 80%;"><b>Баллы</b></td>
		</tr>
		<?php 

		$histories = History::find()->where(['party_team_id' => $model->id])->orderBy(['id' => SORT_DESC])->all();
		$c = 0;

		foreach ($histories as $history)
		{
			$numb = count($histories) - $c;
			echo '<tr><td>'.$numb.'</td><td>'.$history->score.'</td></tr>';
			$c++;
		}

		?>
	</table>
</div>


<script type="text/javascript">
	function ShowHistory()
	{
		let elem = document.getElementById("his1");
		if (elem.style.display == "none")
			elem.style.display = "block"
		else
			elem.style.display = "none";
	}

	function OpenBlock(id)
	{
		let elem = document.getElementById(id);
		if (elem.style.display == "none") elem.style.display = "block";
		else elem.style.display = "none";
	}


</script>