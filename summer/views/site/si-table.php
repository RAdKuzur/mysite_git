<div class="company-form" style="height: 400px">


	<?php
	use app\models\SiClick;
	use app\models\User;

	$answers = SiClick::find()->orderBy(['time' => SORT_ASC, 'id' => SORT_ASC])->all();
	echo '<table class="table table-bordered">';
	foreach ($answers as $answer)
	{
		$name = User::find()->where(['id' => $answer->user_id])->one();
		echo '<tr><td>'.$name->username.'</td><td>'.$answer->time.'</td></tr>';
	}
	echo '</table>';
	?>


</div>