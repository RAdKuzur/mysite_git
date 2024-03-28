<?php

namespace app\services;
use app\models\PartyPersonal;
use app\models\PartyTeam;
use app\models\PersonalOffset;
use app\models\Team;
use app\models\History;
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
    public function siteIndexPersonal($model){
        $model = PersonalOffset::find()->where(['id' => $model->name])->one();
            return $model;
    }
    public function siteSiUnblock(){
        $clicks = SiClick::find()->all();
        foreach ($clicks as $click)
            $click->delete();
    }
    public function SiteSiUser($name){
        Yii::$app->session->set('user', $name);
    }
    public function siteSiConfirm($model){
        $name = User::find()->where(['username' => Yii::$app->session->get('user')])->one();
        $model->user_id = $name->id;
        $model->time = date("H:i:s");
        $duplicate = SiClick::find()->where(['user_id' => $name->id])->one();
        if ($duplicate == null)
        {
            $model->save();
        }
    }
    public function siteIndexTeam($model){
        $model = Team::find()->where(['id' => $model->name])->one();
    }
    public function siteChooseColor($model, $branch, $id){

        $model = PartyTeam::find()->where(['id' => $id])->one();
        $model->lastBranch = $branch;
        return $model;
    }
    public function siteLogin($model){
        $user = User::find()->where(['username' => $model->username])->one();
        return $user;
    }
    public function siteLogout(){
        Yii::$app->user->logout();
    }
    public function siteContact(){
        Yii::$app->session->setFlash('contactFormSubmitted');
    }
    public function sitePlus($model, $numb, $branch, $id){
        $model = PartyTeam::find()->where(['id' => $id])->one();
        $model->total_score = $model->total_score + $numb;
        $model->lastBranch = $branch;
        $model->save();
        return $model;
    }
    public function siteVal($model)
    {
        $model = PartyTeam::find()->where(['id' => $_POST['PartyTeam']['id']])->one();
        $model->total_score = $model->total_score + $_POST['PartyTeam']['score'];
        $model->lastBranch = $_POST['PartyTeam']['lastBranch'];
        $model->save();
        return $model;
    }


    public function siteMinus($model, $numb, $branch, $id){
        $model = PartyTeam::find()->where(['id' => $id])->one();
        $model->total_score = $model->total_score - $numb;
        $model->lastBranch = $branch;
        $model->save();
        return $model;
    }
    public function siteMinusVal($model){
        $model = PartyTeam::find()->where(['id' => $_POST['PartyTeam']['id']])->one();
        $model->total_score = $model->total_score - $_POST['PartyTeam']['score'];
        $model->lastBranch = $_POST['PartyTeam']['lastBranch'];
        $model->save();
        return $model;
    }
    public function siteWriteHistory($history ,$score, $party_team_id){
        $history->score = $score;
        $history->party_team_id = $party_team_id;
        $history->date_time = date('Y-m-d h:i:s');
        $history->save();
    }


}