<?php

namespace app\repositories;
use app\models\PartyPersonal;
use app\models\PartyTeam;
use app\models\PersonalOffset;
use app\models\Team;
use app\models\History;
use http\Exception\RuntimeException;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\SiClick;
use app\services\SiteService;
class TimerRepository
{
    public function findByName()
    {
        return \app\models\Timer::find()->where(['name' => 'Main Timer'])->one();
    }
    public function updateTime($seconds,$minutes,$hours)
    {
        $timer = \app\models\Timer::find()->where(['name' => 'Main Timer'])->one();
        $timer->seconds = $seconds;
        $timer->minutes = $minutes;
        $timer->hours = $hours;
        $this->save($timer);
    }
    public function resetTime(){
        $timer = \app\models\Timer::find()->where(['name' => 'Main Timer'])->one();
        $timer->seconds = 0;
        $timer->minutes = 0;
        $timer->hours = 0;
        $this->save($timer);
    }

    public function save($model)
    {
        $model->save();
    }
}