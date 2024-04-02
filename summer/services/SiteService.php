<?php

namespace app\services;
use app\models\PartyPersonal;
use app\models\PartyTeam;
use app\models\PersonalOffset;
use app\models\Team;
use app\models\History;
use app\repository\SiteRepository;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\SiClick;
class SiteService
{
    public SiteRepository $repository;
    public function __construct(SiteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function SiteSiUser($name){
        Yii::$app->session->set('user', $name);
    }
    public function siteLogout(){
        Yii::$app->user->logout();
    }
    public function siteContact(){
        Yii::$app->session->setFlash('contactFormSubmitted');
    }
    public function userUpdateIdTime($model, $name){
        $model->user_id = $name->id;
        $model->time = date("H:i:s");
    }

    public function siteWriteHistory($history ,$score, $party_team_id){
        $history->score = $score;
        $history->party_team_id = $party_team_id;
        $history->date_time = date('-m-d h:i:s');
        $newRepo = new SiteRepository();
        $newRepo->saveHistory($history);

        //$history->save();

    }


}