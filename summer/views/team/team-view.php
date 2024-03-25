<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
?>

<?php
$script = <<< JS
$(document).ready(function() {
    setInterval(function(){ $("#refreshButton").click(); }, 300);
});
JS;
$this->registerJs($script);
?>

<style>
    table {
        width: 90%;
        height: 90%;
        alignment: center;
    }
    td {
        width: 33.33%;
        height: 33.33%;
        position: relative;
        color: black;
        text-align: center;
        font-family: digital ;
        font-size: 30px;
    }
    td:after {
        content: '';
        display: block;
    }
    td .content {
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: gold;
    }
</style>


<?php Pjax::begin(); ?>
<?= Html::a("Обновить", ['team/team-view', 'id' => $scores[0]->team_id], ['class' => 'hidden', 'id' => 'refreshButton']) ?>
<br>

<table>
    <tr>
        <?php if (count($scores) > 0) echo '<td style="background: '.$scores[0]->color->code.'">'.$scores[0]->team_name.'<p style="font-size: 100px">'.$scores[0]->total_score.'</p></td>' ?>
        <?php if (count($scores) > 1) echo '<td style="background: '.$scores[1]->color->code.'">'.$scores[1]->team_name.'<p style="font-size: 100px">'.$scores[1]->total_score.'</p></td>' ?>
        <?php if (count($scores) > 2) echo '<td style="background: '.$scores[2]->color->code.'">'.$scores[2]->team_name.'<p style="font-size: 100px">'.$scores[2]->total_score.'</p></td>' ?>
    </tr>
    <tr>
        <?php if (count($scores) > 3) echo '<td style="background: '.$scores[3]->color->code.'">'.$scores[3]->team_name.'<p style="font-size: 100px">'.$scores[3]->total_score.'</p></td>' ?>
        <?php if (count($scores) > 4) echo '<td style="background: '.$scores[4]->color->code.'">'.$scores[4]->team_name.'<p style="font-size: 100px">'.$scores[4]->total_score.'</p></td>' ?>
        <?php if (count($scores) > 5) echo '<td style="background: '.$scores[5]->color->code.'">'.$scores[5]->team_name.'<p style="font-size: 100px">'.$scores[5]->total_score.'</p></td>' ?>
    </tr>
    <tr style="height: 50px"></tr>

</table>



<?php Pjax::end(); ?>

<div style="width: 100%">
    <table>
        <tr>
            <td>
                <b><h1 id="timer" class="number" align="center">Время 00:00:00</h1></b>
            </td>
            <td>
                <button id="startBtn" style="background-color: white; border-radius: 10px"><img src="play.png" style="height: 50px; width: 50px"></button>
                <button id="pauseBtn" style="background-color: white; border-radius: 10px" disabled><img src="pause.png" style="height: 50px; width: 50px"></button>
                <button id="resetBtn" style="background-color: white; border-radius: 10px" disabled><img src="refresh.png" style="height: 50px; width: 50px"></button>
            </td>
        </tr>
    </table>


</div>

<style>
    .number {
        width: 500px;
        font-family: digital, Consolas;
        font-size: 50px;
        background-color: #8dead7;
        padding: 5px 15px 10px 15px;
        border-radius: 10px;
        border-left: 4px solid #1f8c73;
        border-right: 4px solid #1f8c73;
        border-bottom: 4px solid #1f8c73;
    }
    @font-face {
        font-family: 'digital';
        src: url('DS-DIGI.TTF');
    }
</style>

<script>
    let timer = document.getElementById('timer');
    let startBtn = document.getElementById('startBtn');
    let pauseBtn = document.getElementById('pauseBtn');
    let resetBtn = document.getElementById('resetBtn');

    let seconds = 0;
    let minutes = 0;
    let hours = 0;
    let interval;

    function updateTime() {
        seconds++;
        if (seconds === 60) {
            minutes++;
            seconds = 0;
        }
        if (minutes === 60) {
            hours++;
            minutes = 0;
        }
        timer.textContent = 'Время ' + `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    startBtn.addEventListener('click', () => {
        interval = setInterval(updateTime, 1000);
        startBtn.disabled = true;
        pauseBtn.disabled = false;
        resetBtn.disabled = false;
    });

    pauseBtn.addEventListener('click', () => {
        clearInterval(interval);
        startBtn.disabled = false;
        pauseBtn.disabled = true;
    });

    resetBtn.addEventListener('click', () => {
        clearInterval(interval);
        seconds = 0;
        minutes = 0;
        hours = 0;
        timer.textContent = 'Время 00:00:00';
        startBtn.disabled = false;
        pauseBtn.disabled = true;
        resetBtn.disabled = true;
    });
</script>
