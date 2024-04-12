<?php

namespace app\repositories;
use app\models\PartyPersonal;
use app\models\PartyTeam;
use app\models\PersonalOffset;
use app\models\Team;
use app\models\History;
use http\Exception\RuntimeException;
use Yii;
use app\models\SearchTeam;
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
class TeamRepository
{
    public function findTeamById(Team $model){
        return Team::find()->where(['id' => $model->name])->one();;
    }
    public function findTeamByQuery()
    {
        $searchModel = Yii::createObject(SearchTeam::class);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $array = [$dataProvider, $searchModel];
        return $array;
    }
    public function findModel($id)
    {
        if (($model = Team::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function delete($team){
        if (!$team->delete()) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return true;
    }

}