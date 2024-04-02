<?php
namespace app\repository;

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

class SiteRepository
{
    public function findSiClickAll()
    {
        return SiClick::find()->all();
    }
    public function deleteSiClickAll($click)
    {
        $click->delete();
    }
    public function saveSiConfirm($model)
    {
        $name = User::find()->where(['username' => Yii::$app->session->get('user')])->one();
        $model->user_id = $name->id;
        $model->time = date("H:i:s");
        $duplicate = SiClick::find()->where(['user_id' => $name->id])->one();
        if ($duplicate == null)
        {
            $model->save();
        }
    }
    public function findIndexTeam($model)
    {
        return Team::find()->where(['id' => $model->name])->one();
    }

    public function findIndexPersonal($model)
    {
        return PersonalOffset::find()->where(['id' => $model->name])->one();
    }
    public function findChooseColor($model, $branch, $id)
    {
        $model = PartyTeam::find()->where(['id' => $id])->one();
        $model->lastBranch = $branch;
        return $model;
    }
    public function findLogin($model)
    {
        return User::find()->where(['username' => $model->username])->one();
    }
    public function updatePlus($model, $numb, $branch, $id){
        $model = PartyTeam::find()->where(['id' => $id])->one();
        $model->total_score = $model->total_score + $numb;
        $model->lastBranch = $branch;
        $model->save();
        return $model;
    }
    public function updatePlusVal($model){
        /*Yii::$app->request->post()*/
        $model = PartyTeam::find()->where(['id' => $_POST['PartyTeam']['id']])->one();
        $model->total_score = $model->total_score + $_POST['PartyTeam']['score'];
        $model->lastBranch = $_POST['PartyTeam']['lastBranch'];
        $model->save();
        return $model;
    }

    public function updateMinus($model, $numb, $branch, $id){
        $model = PartyTeam::find()->where(['id' => $id])->one();
        $model->total_score = $model->total_score - $numb;
        $model->lastBranch = $branch;
        $model->save();
        return $model;
    }
    public function updateMinusVal(){
        $model = PartyTeam::find()->where(['id' => $_POST['PartyTeam']['id']])->one();
        $model->total_score = $model->total_score - $_POST['PartyTeam']['score'];
        $model->lastBranch = $_POST['PartyTeam']['lastBranch'];
        $this->save($model);
        return $model;

    }
    public function saveHistory($history){
        $history->save();
    }

    public function save(PartyTeam $model)
    {
        if (!$model->save())
            throw new RuntimeException('Saving error');

    }
}