<?php

namespace app\controllers;

use app\models\dynamic\PersonalOffsetDynamic;
use app\models\DynamicModel;
use app\models\LoginForm;
use app\models\PartyTeam;
use Yii;
use app\models\Team;
use app\models\SearchTeam;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeamController implements the CRUD actions for Team model.
 */
class TeamController extends Controller
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
     * Lists all Team models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('index.php?r=site/login');
        }
        $searchModel = new SearchTeam();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Team model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Team model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Team();
        $modelTeams = [new PartyTeam];

        if ($model->load(Yii::$app->request->post())) {
            $modelTeams = DynamicModel::createMultiple(PartyTeam::classname());
            DynamicModel::loadMultiple($modelTeams, Yii::$app->request->post());
            $model->teams = $modelTeams;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelTeams' => $modelTeams,
        ]);
    }

    /**
     * Updates an existing Team model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelTeams = [new PartyTeam];

        if ($model->load(Yii::$app->request->post())) {
            $modelTeams = DynamicModel::createMultiple(PartyTeam::classname());
            DynamicModel::loadMultiple($modelTeams, Yii::$app->request->post());
            $model->teams = $modelTeams;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelTeams' => $modelTeams,
        ]);
    }

    public function actionTeamView($id)
    {
        $scores = \app\models\PartyTeam::find()->where(['team_id' => $id])->all();
        $timer = \app\models\Timer::find()->where(['name' => 'Main Timer'])->one();
        return $this->render('team-view', [
            'scores' => $scores,
            'timer' => $timer,
        ]);
    }


    public function actionTimer()
    {
        $timer = \app\models\Timer::find()->where(['name' => 'Main Timer'])->one();
        $timer->seconds = $_POST['sec'];
        $timer->minutes = $_POST['min'];
        $timer->hours = $_POST['h'];
        $timer->save();
    }

    public function actionReset()
    {
        $timer = \app\models\Timer::find()->where(['name' => 'Main Timer'])->one();
        $timer->seconds = 0;
        $timer->minutes = 0;
        $timer->hours = 0;
        $timer->save();
    }

    public function actionTimerVisible($id)
    {
        $currentVisible = Yii::$app->session->get('t_vis');
        if ($currentVisible == null) Yii::$app->session->set('t_vis', 1);
        else Yii::$app->session->set('t_vis', abs($currentVisible - 1));

        $scores = \app\models\PartyTeam::find()->where(['team_id' => $id])->all();
        $timer = \app\models\Timer::find()->where(['name' => 'Main Timer'])->one();
        return $this->render('team-view', [
            'scores' => $scores,
            'timer' => $timer,
        ]);
    }


    /**
     * Deletes an existing Team model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeletePartyTeam($id, $modelId)
    {
        $team = PartyTeam::find()->where(['id' => $id])->one();
        $team->delete();
        return $this->redirect('index?r=team/update&id='.$modelId);
    }

    /**
     * Finds the Team model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Team the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Team::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
