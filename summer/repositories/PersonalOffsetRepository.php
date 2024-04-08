<?php
namespace app\repositories;

use app\models\PartyPersonal;
use app\models\PartyTeam;
use app\models\PersonalOffset;
use app\models\SearchPersonalOffset;
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
class PersonalOffsetRepository
{

    /**
     * @param PersonalOffset $model
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findPersonalOffsetById(PersonalOffset $model)
    {
        return PersonalOffset::find()->where(['id' => $model->name])->one();
    }
    public function createModel($queryParams){
        $searchModel = new SearchPersonalOffset();
        $dataProvider = $searchModel->search($queryParams);
        return [$searchModel, $dataProvider];
    }
    public function findModel($id)
    {
        if (($model = PersonalOffset::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}