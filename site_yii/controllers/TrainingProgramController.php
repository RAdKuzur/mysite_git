<?php

namespace app\controllers;

use app\models\components\RoleBaseAccess;
use app\models\strategies\FileDownloadStrategy\FileDownloadServer;
use app\models\strategies\FileDownloadStrategy\FileDownloadYandexDisk;
use app\models\work\AuthorProgramWork;
use app\models\work\ProgramErrorsWork;
use app\models\work\ThematicPlanWork;
use app\models\components\Logger;
use app\models\components\UserRBAC;
use app\models\DynamicModel;
use app\models\extended\Author;
use app\models\work\TrainingGroupWork;
use Yii;
use app\models\work\TrainingProgramWork;
use app\models\SearchTrainingProgram;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TrainingProgramController implements the CRUD actions for TrainingProgram model.
 */
class TrainingProgramController extends Controller
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
     * Lists all TrainingProgram models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchTrainingProgram();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TrainingProgram model.
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
     * Creates a new TrainingProgram model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrainingProgramWork();
        $modelAuthor = [new AuthorProgramWork];
        $modelThematicPlan = [new ThematicPlanWork];

        if ($model->load(Yii::$app->request->post())) {
            $modelAuthor = DynamicModel::createMultiple(AuthorProgramWork::classname());
            DynamicModel::loadMultiple($modelAuthor, Yii::$app->request->post());
            $modelThematicPlan = DynamicModel::createMultiple(ThematicPlanWork::classname());
            DynamicModel::loadMultiple($modelThematicPlan, Yii::$app->request->post());
            $model->authors = $modelAuthor;
            $model->thematicPlan = $modelThematicPlan;
            $model->docFile = UploadedFile::getInstance($model, 'docFile');
            $model->editDocs = UploadedFile::getInstances($model, 'editDocs');
            $model->fileUtp = UploadedFile::getInstance($model, 'fileUtp');
            $model->contractFile = UploadedFile::getInstance($model, 'contractFile');
            if ($model->docFile !== null)
                $model->uploadDocFile();
            if ($model->editDocs !== null)
                $model->uploadEditFiles();
            if ($model->fileUtp !== null)
                $model->uploadExcelUtp();
            if ($model->contractFile !== null)
                $model->uploadContractFile();
            $model->creator_id = Yii::$app->user->identity->getId();
            $model->save(false);
            Logger::WriteLog(Yii::$app->user->identity->getId(), 'Добавлена образовательная программа '.$model->name);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelAuthor' => $modelAuthor,
            'modelThematicPlan' => $modelThematicPlan,
        ]);
    }

    /**
     * Updates an existing TrainingProgram model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelAuthor = [new AuthorProgramWork];
        $modelThematicPlan = [new ThematicPlanWork];

        if ($model->load(Yii::$app->request->post())) {
            $modelAuthor = DynamicModel::createMultiple(AuthorProgramWork::classname());
            DynamicModel::loadMultiple($modelAuthor, Yii::$app->request->post());
            $modelThematicPlan = DynamicModel::createMultiple(ThematicPlanWork::classname());
            DynamicModel::loadMultiple($modelThematicPlan, Yii::$app->request->post());
            $model->authors = $modelAuthor;
            $model->thematicPlan = $modelThematicPlan;
            $model->docFile = UploadedFile::getInstance($model, 'docFile');
            $model->editDocs = UploadedFile::getInstances($model, 'editDocs');
            $model->fileUtp = UploadedFile::getInstance($model, 'fileUtp');
            $model->contractFile = UploadedFile::getInstance($model, 'contractFile');
            if ($model->docFile !== null)
                $model->uploadDocFile();
            if ($model->editDocs !== null)
                $model->uploadEditFiles(10);
            if ($model->fileUtp !== null)
                $model->uploadExcelUtp();
            if ($model->contractFile !== null)
                $model->uploadContractFile(10);

            $model->save(false);
            
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'modelAuthor' => $modelAuthor,
            'modelThematicPlan' => $modelThematicPlan,
        ]);
    }

    public function actionUpdatePlan($id, $modelId)
    {
        $model = ThematicPlanWork::find()->where(['id' => $id])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            $group = TrainingProgramWork::find()->where(['id' => $modelId])->one();
            $modelAuthor = [new AuthorProgramWork];
            $modelThematicPlan = [new ThematicPlanWork];
            Logger::WriteLog(Yii::$app->user->identity->getId(), 'Изменен тематический план образовательной программы '.$model->trainingProgram->name);
            return $this->render('update', [
                'model' => $group,
                'modelAuthor' => $modelAuthor,
                'modelThematicPlan' => $modelThematicPlan,
            ]);
        }
        return $this->render('update-plan', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TrainingProgram model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $name = $model->name;
        $model->delete();
        Logger::WriteLog(Yii::$app->user->identity->getId(), 'Удалена образовательная программа '.$name);

        return $this->redirect(['index']);
    }

    public function actionSaver()
    {
        $checks = Yii::$app->request->post('selection');
        $allTps = TrainingProgramWork::find()->all();
        foreach ($allTps as $allTp)
        {
            $allTp->actual = 0;
            $allTp->save(false);
        }
        if ($checks !== null)
            foreach ($checks as $check)
            {
                $tp = TrainingProgramWork::find()->where(['id' => $check])->one();
                $tp->actual = 1;
                $tp->save(false);

            }
        return $this->redirect(['/training-program/index']);
    }

    public function actionActual($id)
    {
        $tag = TrainingProgramWork::findOne($id);
        $tag->actual === 1 ? $tag->actual = 0 : $tag->actual = 1;
        $tag->save(false);
        if ($tag->actual === 0)
            Yii::$app->session->setFlash("warning", "Программа ".$tag->name." больше не актуальна");
        else
            Yii::$app->session->setFlash("success", "Программа ".$tag->name." теперь актуальна");
        return $this->redirect(['/training-program/index']);
    }

    /**
     * Finds the TrainingProgram model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TrainingProgramWork the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrainingProgramWork::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetFile($fileName = null, $modelId = null, $type = null)
    {
        Logger::WriteLog(Yii::$app->user->identity->getId(), 'Загружен файл '.$fileName);
        //$path = \Yii::getAlias('@upload') ;

        $filePath = '/upload/files/'.Yii::$app->controller->id;
        $filePath .= $type == null ? '/' : '/'.$type.'/';
        //Logger::WriteLog(Yii::$app->user->identity->getId(), $filePath . ' -- ' . $fileName);
        $downloadServ = new FileDownloadServer($filePath, $fileName);
        $downloadYadi = new FileDownloadYandexDisk($filePath, $fileName);


        $downloadServ->LoadFile();
        if (!$downloadServ->success) $downloadYadi->LoadFile();
        else return \Yii::$app->response->sendFile($downloadServ->file);

        if (!$downloadYadi->success) throw new \Exception('File not found');
        else {
            $fp = fopen('php://output', 'r+');

            //header('Content-Description: File Transfer');
            //header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $downloadYadi->filename);
            //header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . $downloadYadi->file->size);

            $downloadYadi->file->download($fp, true);
            exit;
        }
    }

    public function actionDeleteFile($fileName = null, $modelId = null, $type = null)
    {

        $model = TrainingProgramWork::find()->where(['id' => $modelId])->one();

        if ($type == 'doc')
        {
            $model->doc_file = '';
            $model->save(false);
            return $this->redirect('index?r=training-program/update&id='.$model->id);
        }

        if ($type == 'contract')
        {
            $model->contract = '';
            $model->save(false);
            return $this->redirect('index?r=training-program/update&id='.$model->id);
        }


        if ($fileName !== null && !Yii::$app->user->isGuest && $modelId !== null) {

            $result = '';
            $split = explode(" ", $model->edit_docs);
            $deleteFile = '';
            for ($i = 0; $i < count($split) - 1; $i++) {
                if ($split[$i] !== $fileName) {
                    $result = $result . $split[$i] . ' ';
                } else
                    $deleteFile = $split[$i];
            }
            $model->edit_docs = $result;
            $model->save(false);
            Logger::WriteLog(Yii::$app->user->identity->getId(), 'Удален файл ' . $deleteFile);
        }
        return $this->redirect('index?r=training-program/update&id='.$model->id);
    }

    public function actionDeleteAuthor($peopleId, $modelId)
    {
        $resp = AuthorProgramWork::find()->where(['author_id' => $peopleId])->andWhere(['training_program_id' => $modelId])->one();
        $name = $resp->authorWork->shortName;
        $program = $resp->trainingProgram->name;
        if ($resp != null)
            $resp->delete();
        $model = $this->findModel($modelId);
        Logger::WriteLog(Yii::$app->user->identity->getId(), 'Удален автор ' . $name . ' образовательной программы ' . $program);

        return $this->redirect('index.php?r=training-program/update&id='.$modelId);
    }

    public function actionDeletePlan($id, $modelId)
    {
        $plan = ThematicPlanWork::find()->where(['id' => $id])->one();
        $name = $plan->trainingProgram->name;
        $plan->delete();
        Logger::WriteLog(Yii::$app->user->identity->getId(), 'Удалена тема УТП образовательной программы ' . $name);

        return $this->redirect('index?r=training-program/update&id='.$modelId);
    }

    public function actionAmnesty ($id)
    {
        $errorsAmnesty = new ProgramErrorsWork();
        $errorsAmnesty->ProgramAmnesty($id);
        return $this->redirect('index?r=training-program/view&id='.$id);
    }

    public function actionArchive($arch, $unarch)
    {
        $arch = explode(',', $arch);
        $unarch = explode(',', $unarch);
        
        for ($i = 0; $i < count($arch) && $arch[0] != ''; $i++)
        {
            $tag = TrainingProgramWork::findOne($arch[$i]);
            if ($tag->actual != 1)
            {
                $tag->actual = 1;
                $tag->save(false);
                Logger::WriteLog(Yii::$app->user->identity->getId(), 'Программа '.$tag->name.' (id: '.$tag->id.') теперь актуальна');
                Logger::WriteLog(Yii::$app->user->identity->getId(), 'Изменена образовательная программа '.$model->name);
            }
            
        }

        for ($i = 0; $i < count($unarch) && $unarch[0] != ''; $i++)
        {
            $tag = TrainingProgramWork::findOne($unarch[$i]);
            if ($tag->actual != 0)
            {
                $tag->actual = 0;
                $tag->save(false);
                Logger::WriteLog(Yii::$app->user->identity->getId(), 'Программа '.$tag->name.' (id: '.$tag->id.') больше не актуальна');
                Logger::WriteLog(Yii::$app->user->identity->getId(), 'Изменена образовательная программа '.$model->name);
            }
            
        }
/*
        $selections = explode(',', $ids);
        $flashStr = "";
        $allPrograms = TrainingProgramWork::find()->all();
        //$errors = new GroupErrorsWork();
        foreach ($allPrograms as $program) {
            if (!$this->InArray($program->id, $selections) && $program->actual == 1)
                Logger::WriteLog(Yii::$app->user->identity->getId(), 'Программа '.$program->name.' (id: '.$program->id.') больше не актуальна');
            if ($this->InArray($program->id, $selections) && $program->actual == 0)
                Logger::WriteLog(Yii::$app->user->identity->getId(), 'Программа '.$program->name.' (id: '.$program->id.') теперь актуальна');
            $program->actual = 0;
            $program->isCod = 2;
            $program->save(false);
            //var_dump($program->getErrors());
        }
        if ($ids !== "")
            for ($i = 0; $i < count($selections); $i++)
            {
                $tag = TrainingProgramWork::findOne($selections[$i]);
                $tag->archStat = 1;
                $tag->actual === 1 ? $tag->actual = 0 : $tag->actual = 1;
                $tag->save(false);
                if ($tag->actual === 0)
                    $flashStr .= "Программа ".$tag->name." больше не актуальна\n";
                else
                    $flashStr .= "Программа ".$tag->name." теперь актуальна\n";

                //$errors->CheckArchiveTrainingGroup($tag->id);
            }*/
        Yii::$app->session->setFlash("success", 'Изменение статуса программ произведено успешно');
        return $this->redirect(['/training-program/index']);
    }

    private function InArray($id, $array)
    {
        for ($i = 0; $i < count($array); $i++)
            if ($id == $array[$i])
                return true;
        return false;
    }

    //Проверка на права доступа к CRUD-операциям
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest)
            return $this->redirect(['/site/login']);
        if (!RoleBaseAccess::CheckAccess($action->controller->id, $action->id, Yii::$app->user->identity->getId())) {
            return $this->redirect(['/site/error-access']);
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }
}
