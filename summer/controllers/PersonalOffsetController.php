<?php

namespace app\controllers;

use app\models\DynamicModel;
use app\models\LoginForm;
use app\models\PartyPersonal;
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
        if (Yii::$app->user->isGuest) {
            return $this->redirect('index.php?r=site/login');
        }
        $searchModel = new SearchPersonalOffset();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PersonalOffset model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PersonalOffset();
        $modelTeams = [new PartyPersonal];

        if ($model->load(Yii::$app->request->post())) {
            $modelTeams = DynamicModel::createMultiple(PartyPersonal::classname());
            DynamicModel::loadMultiple($modelTeams, Yii::$app->request->post());
            $model->personals = $modelTeams;
            $model->save();
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
        $model = $this->findModel($id);
        $modelTeams = [new PartyPersonal];

        if ($model->load(Yii::$app->request->post())) {
            $modelTeams = DynamicModel::createMultiple(PartyPersonal::classname());
            DynamicModel::loadMultiple($modelTeams, Yii::$app->request->post());
            $model->personals = $modelTeams;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelTeams' => $modelTeams,
        ]);
    }

    public function actionPersonalView($id)
    {
        $scores = \app\models\PartyPersonal::find()->where(['personal_offset_id' => $id])->orderBy(['total_score' => SORT_DESC])->all();
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeletePartyPersonal($id, $modelId)
    {
        $team = PartyPersonal::find()->where(['id' => $id])->one();
        $team->delete();
        return $this->redirect('index?r=personal-offset/update&id='.$modelId);
    }

    /**
     * Finds the PersonalOffset model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PersonalOffset the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PersonalOffset::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
