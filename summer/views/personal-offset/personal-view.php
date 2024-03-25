<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
?>

<?php
$script = <<< JS
$(document).ready(function() {
    setInterval(function(){ $("#refreshButton").click(); }, 1000);
});
JS;
$this->registerJs($script);
?>
<body background="back2.png" style="background-size: 100% 100%;">
<?php Pjax::begin(); ?>
<?= Html::a("Обновить", ['personal-offset/personal-view', 'id' => $scores[0]->personal_offset_id], ['class' => 'hidden', 'id' => 'refreshButton']) ?>
<br>
<h1 style="padding-left: 30px"><b><?php echo 'Команда '.$scores[0]->personalOffset->name ?></b></h1>
<div style="box-sizing: border-box; padding: 30px 30px 10px 30px;">
    <table class="table table-bordered" style="">
        <tr style="background: white">
            <td style="font-family: Century Gothic; font-size: 35px;"><b>№</b></td>
            <td style="font-family: Century Gothic; font-size: 35px;"><b>ФАМИЛИЯ ИМЯ ОТЧЕСТВО</b></td>
            <td style="font-family: Century Gothic; font-size: 35px;"><b>ОЧКИ</b></td>
        </tr>
        <tr>
            <?php
            $i = 1;
            $color1 = '';
            $color2 = '';
            foreach ($scores as $score) {
                if ($i < 4)
                {
                    $color1 = '#ccff33';
                    $color2 = '#cc0000';
                    echo '<tr style="background: #A8D4AF;"><td style="font-family: Century Gothic; font-size: 35px; color: black; text-align: center">' . $i . '</td>'
                        .'<td style="font-family: Century Gothic; font-size: 35px; color: black; text-align: left">' . $score->secondname . ' ' . $score->firstname . ' ' . $score->patronymic . '</td>' .
                        '<td style="font-family: Century Gothic; font-size: 40px; color: black;"><b>' . $score->total_score . '</b></td></tr>';
                }
                else
                    echo '<tr style="background: white;"><td style="border: 1px solid #A2D9F7; font-family: Century Gothic; font-size: 35px; color: black; text-align: center">' . $i . '</td>'
                        .'<td style="border: 1px solid #A2D9F7; font-family: Century Gothic; font-size: 35px; color: black; text-align: left">' . $score->secondname . ' ' . $score->firstname . ' ' . $score->patronymic . '</td>' .
                        '<td style="border: 1px solid #A2D9F7; font-family: Century Gothic; font-size: 40px; color: black;"><b>' . $score->total_score . '</b></td></tr>';
                $i = $i + 1;
            }
            ?>
        </tr>
    </table>
</div>

<style>
    table {
        border-spacing: 1px;
        border-collapse: separate;
        width: 400px;
        border: 1px solid red;
    }
    td {
        border: 1px solid red;
        text-align: center;
    }
</style>

<?php Pjax::end(); ?>
</body>