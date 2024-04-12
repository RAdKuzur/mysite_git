<?php

namespace app\controllers;
use app\services\PersonalOffsetService;
use app\models\DynamicModel;
use app\models\LoginForm;
use app\models\PartyPersonal;
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
use app\models\PersonalOffset;
use app\models\SearchPersonalOffset;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PersonalOffsetController implements the CRUD actions for PersonalOffset model.
 */
class PersonalOffsetController extends Controller
{
    public PersonalOffsetRepository $personalOffsetRepository;
    public DynamicModelRepository $dynamicModelRepository;
    public PartyPersonalRepository $partyPersonalRepository;
    public function __construct(
        $id,
        $module,
        DynamicModelRepository $dynamicRepository,
        PartyPersonalRepository $partyPersonalRepository,
        PersonalOffsetRepository $perOffsetRepository,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->partyPersonalRepository = $partyPersonalRepository;
        $this->dynamicModelRepository = $dynamicRepository;
        $this->personalOffsetRepository = $perOffsetRepository;
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
     * Lists all PersonalOffset models.
     * @return mixed
     */
    public function actionIndex()
    {
        $queryParams = Yii::$app->request->post();
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
            //return $this->redirect('index.php?r=site/login');
        }
        $array = $this->personalOffsetRepository->createModel($queryParams);
        return $this->render('index', [
            'searchModel' => $array[0],
            'dataProvider' => $array[1],
        ]);
    }

    /**
     * Displays a single PersonalOffset model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->personalOffsetRepository->findModel($id),
        ]);
    }

    /**
     * Creates a new PersonalOffset model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Yii::createObject(PersonalOffset::class);
        $modelTeams = [Yii::createObject(PartyPersonal::class)];
        $requestPost = Yii::$app->request->post();
        if ($model->load($requestPost)) {
            $this->dynamicModelRepository->updatePersonals($model, $requestPost);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelTeams' => $modelTeams,
        ]);
    }

    /**
     * Updates an existing PersonalOffset model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->personalOffsetRepository->findModel($id);
        $modelTeams = [Yii::createObject(PartyPersonal::class)];
        $requestPost = Yii::$app->request->post();
        if ($model->load($requestPost)) {
            $this->dynamicModelRepository->updatePersonals($model, $requestPost);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelTeams' => $modelTeams,
        ]);
    }

    public function actionPersonalView($id)
    {
        $scores = $this->partyPersonalRepository->findByPersonalId($id);
        return $this->render('personal-view', [
            'scores' => $scores,
        ]);
    }

    /**
     * Deletes an existing PersonalOffset model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->personalOffsetRepository->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeletePartyPersonal($id, $modelId)
    {
        $this->partyPersonalRepository->findById($id);
        //$this->redirect('index?r=personal-offset/update&id='.$modelId);
        $this->redirect(['personal-offset/update', 'id' => $modelId]);
    }

    /**
     * Finds the PersonalOffset model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PersonalOffset the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

}
