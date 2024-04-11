<?php

namespace app\controllers;
use app\models\PersonalOffset;
use app\services\PartyTeamService;
use app\models\dynamic\PersonalOffsetDynamic;
use app\repositories\DynamicModelRepository;
use app\repositories\HistoryRepository;
use app\repositories\PartyPersonalRepository;
use app\repositories\PartyTeamRepository;
use app\repositories\PersonalOffsetRepository;
use app\repositories\SiClickRepository;
use app\repositories\TeamRepository;
use app\repositories\UserRepository;
use app\services\SiteService;
use Yii;
use app\models\PartyTeam;
use app\models\SearchPartyTeam;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartyTeamController implements the CRUD actions for PartyTeam model.
 */
class PartyTeamController extends Controller
{


    public PartyTeamRepository $partyTeamRepository;
    public function __construct(
        $id,
        $module,
        PartyTeamRepository $parTeamRepository,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->partyTeamRepository = $parTeamRepository;
    }
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
     * Lists all PartyTeam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $queryParams = Yii::$app->request->queryParams;
/*
        $searchModel = new SearchPartyTeam();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
*/

        $array = $this->partyTeamRepository->createModel($queryParams);
        return $this->render('index', [
            'searchModel' => $array[0],
            'dataProvider' => $array[1],
        ]);
    }

    /**
     * Displays a single PartyTeam model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->partyTeamRepository->findModel($id),
        ]);
    }

    /**
     * Creates a new PartyTeam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Yii::createObject(PartyTeam::class);
        $modelPersonals = [Yii::createObject(PersonalOffsetDynamic::class)];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelPersonals' => $modelPersonals,
        ]);
    }

    /**
     * Updates an existing PartyTeam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->partyTeamRepository->findModel($id);
        $modelPersonals = [Yii::createObject(PersonalOffsetDynamic::class)];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'modelPersonals' => $modelPersonals,
        ]);
    }

    /**
     * Deletes an existing PartyTeam model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->partyTeamRepository->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    /**
     * Finds the PartyTeam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PartyTeam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

}
