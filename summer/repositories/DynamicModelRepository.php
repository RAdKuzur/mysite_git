<?php
namespace app\repositories;

use app\models\DynamicModel;
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
class DynamicModelRepository
{
    public function updateTeams($model, $requestPost) {
        $modelTeams = DynamicModel::createMultiple(PartyTeam::classname());
        DynamicModel::loadMultiple($modelTeams, $requestPost);
        $model->teams = $modelTeams;
        $this->save($model);
    }
    public function save($model) {
        $model->save();
    }

}