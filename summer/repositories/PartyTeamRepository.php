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
class PartyTeamRepository
{
    public function findChooseColor($branch,$id)
    {
        $model = PartyTeam::find()->where(['id' => $id])->one();
        $model->lastBranch = $branch;
        return $model;
    }
    public function plusNumb($id, $numb, $branch){
        $model = PartyTeam::find()->where(['id' => $id])->one();
        $model->total_score = $model->total_score + $numb;
        $model->lastBranch = $branch;
        //$model->save();
        $this->saveModel($model);
        return $model;
    }
    public function plusScore($id, $score,$lastBranch)
    {
        $model = PartyTeam::find()->where(['id' => $id])->one();
        $model->total_score = $model->total_score + $score;
        $model->lastBranch = $lastBranch;
        $this->saveModel($model);
        return $model;
    }
    public function minusNumb($id, $numb, $branch){
        $model = PartyTeam::find()->where(['id' => $id])->one();
        $model->total_score = $model->total_score - $numb;
        $model->lastBranch = $branch;
        //$model->save();
        $this->saveModel($model);
        return $model;
    }
    public function minusScore($id, $score,$lastBranch){

        $model = PartyTeam::find()->where(['id' => $id])->one();
        $model->total_score = $model->total_score - $score;
        $model->lastBranch = $lastBranch;

        $this->saveModel($model);
        return $model;
    }
    public function saveModel(PartyTeam $model)
    {
        $model->save();
    }

}