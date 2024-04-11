<?php


namespace app\services;

use app\models\PartyPersonal;
use app\models\PartyTeam;
use app\models\PersonalOffset;
use app\models\Team;
use app\models\History;
use app\repositories\HistoryRepository;
use app\repositories\PartyTeamRepository;
use app\repositories\TimerRepository;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\SiClick;

class TeamService
{

    public PartyTeamRepository $partyTeamRepository;
    public TimerRepository $timerRepository;


    public function findByTeamId($id):array
    {
        return $this->partyTeamRepository->findByTeamId($id);
    }
    public function findByName()
    {
        return $this->timerRepository->findByName();
    }
    public function currentVisible()
    {
        $currentVisible = Yii::$app->session->get('t_vis');
        if ($currentVisible == null) Yii::$app->session->set('t_vis', 1);
        else Yii::$app->session->set('t_vis', abs($currentVisible - 1));
    }
}