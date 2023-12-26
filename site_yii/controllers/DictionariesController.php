<?php

namespace app\controllers;

use app\models\components\ExcelWizard;
use app\models\components\Logger;
use app\models\components\RoleBaseAccess;
use app\models\components\UserRBAC;
use app\models\extended\ForeignEventReportModel;
use app\models\extended\ReportFormModel;
use app\models\extended\ManHoursReportModel;
use app\models\extended\ResultReportModel;
use app\models\extended\UsefulSideReportModel;
use Yii;
use app\models\work\PositionWork;
use app\models\SearchPosition;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PositionController implements the CRUD actions for Position model.
 */
class DictionariesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Displays a single Position model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionService()
    {
        return $this->render('service');
    }

    public function actionStudies()
    {
        return $this->render('studies');
    }

    public function actionPremises()
    {
        return $this->render('premises');
    }

    public function actionUsers()
    {
        return $this->render('users');
    }

    

    //Проверка на права доступа к CRUD-операциям
    /*public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest)
            return $this->redirect(['/site/login']);
        if (!RoleBaseAccess::CheckAccess($action->controller->id, $action->id, Yii::$app->user->identity->getId(), "group")) {
            return $this->redirect(['/site/error-access']);
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }*/
}
