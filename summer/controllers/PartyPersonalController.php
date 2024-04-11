<?php

namespace app\controllers;
use app\services\PartyPersonalService;
use app\models\DynamicModel;
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
use app\models\PartyPersonal;
use app\models\dynamic\PersonalOffsetDynamic;
use app\models\SearchPartyPersonal;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartyPersonalController implements the CRUD actions for PartyPersonal model.
 */
class PartyPersonalController extends Controller
{
    public DynamicModelRepository $dynamicModelRepository;

    public PartyPersonalRepository $partyPersonalRepository;
    public function __construct(
        $id,
        $module,
        DynamicModelRepository $dynamicRepository,
        PartyPersonalRepository $partyPersonalRepository,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->partyPersonalRepository = $partyPersonalRepository;
        $this->dynamicModelRepository = $dynamicRepository;
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
     * Lists all PartyPersonal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $queryParams = Yii::$app->request->queryParams;
        $array = $this->partyPersonalRepository->searchPartyPersonal($queryParams);
        return $this->render('index', [
            'searchModel' => $array[0],
            'dataProvider' => $array[1],
        ]);
    }

    /**
     * Displays a single PartyPersonal model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->partyPersonalRepository->findModel($id),
        ]);
    }
    /**
     * Creates a new PartyPersonal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PartyPersonal();
        $modelPersonals = [new PersonalOffsetDynamic];
        $requestPost = Yii::$app->request->post();
        if ($model->load($requestPost)) {

            $this->dynamicModelRepository->updatePersonals($model, $requestPost);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        //$this->service->PartyPersonalCreateService();
        return $this->render('create', [
            'model' => $model,
            'modelPersonals' => $modelPersonals,
        ]);
    }

    /**
     * Updates an existing PartyPersonal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->partyPersonalRepository->findModel($id);
        $modelPersonals = [new PersonalOffsetDynamic];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'modelPersonals' => $modelPersonals,
        ]);
    }

    /**
     * Deletes an existing PartyPersonal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->partyPersonalRepository->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    /**
     * Finds the PartyPersonal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PartyPersonal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
}
