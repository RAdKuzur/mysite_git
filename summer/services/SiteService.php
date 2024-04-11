<?php

namespace app\services;
use app\models\PartyPersonal;
use app\models\PartyTeam;
use app\models\PersonalOffset;
use app\models\Team;
use app\models\History;
use app\repositories\HistoryRepository;
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
use app\repositories\SiClickRepository;
class SiteService
{
    public SiClickRepository $siClickRepository;
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

    public function saveSiClick(SiClick $model){
        $this->siClickRepository->saveSiClick($model);
    }
    public function findSiClickById($name){
        return $this->siClickRepository->findSiClickById($name);
    }


}