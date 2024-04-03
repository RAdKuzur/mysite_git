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
class HistoryRepository
{
    public function siteWriteHistory($score, $party_team_id){
        $history = new History();
        $history->score = $score;
        $history->party_team_id = $party_team_id;
        $history->date_time = date('-m-d h:i:s');
        $this->saveModel($history);

        //$history->save();

    }


    public function saveModel(History $model)
    {
        $model->save();
    }
}