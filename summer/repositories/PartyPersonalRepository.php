<?php
namespace app\repositories;

use app\models\PartyPersonal;
use app\models\PartyTeam;
use app\models\PersonalOffset;
use app\models\SearchPartyPersonal;
use app\models\Team;
use app\models\History;
use http\Exception\RuntimeException;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\SiClick;
use app\services\SiteService;

class PartyPersonalRepository
{
    public function searchPartyPersonal($queryParams)
    {
        $searchModel = Yii::createObject(SearchPartyPersonal::class);
            $dataProvider = $searchModel->search($queryParams);
        return [$searchModel,  $dataProvider];
    }
    public function save($model) {
        /*if (!$model->save()) {
            throw new NotFoundHttpException('The model cannot be saved');
        }*/
        $model->save();
    }
    public function findModel($id)
    {
        if (($model = PartyPersonal::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function findById($id){
        $team = PartyPersonal::find()->where(['id' => $id])->one();
        $this->delete($team);

    }
    public function findByPersonalId($id){
        return \app\models\PartyPersonal::find()->where(['personal_offset_id' => $id])->orderBy(['total_score' => SORT_DESC])->all();
    }
    public function delete(PartyPersonal $team){
        if (!$team->delete($team)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function plusNumb($id, $numb){
        $model = PartyPersonal::find()->where(['id' => $id])->one();
        if($model !== null){
            $model->plus($numb);
            $this->saveModel($model);
            return $model;
        } else {
            return 'PartyTeam not found for id: ' . $id;
        }
    }
    public function minusNumb($id, $numb){
        $model = PartyPersonal::find()->where(['id' => $id])->one();
        if($model !== null){
            $model->minus($numb);
            $this->saveModel($model);
            return $model;
        } else {
            return 'PartyTeam not found for id: ' . $id;
        }
    }
    public function saveModel(PartyPersonal $model)
    {
        if (!$model->save()) {
            throw new NotFoundHttpException('The model 2 cannot be saved');
        }
    }
}