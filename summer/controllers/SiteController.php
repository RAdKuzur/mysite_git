<?php

namespace app\controllers;

use app\models\PartyPersonal;
use app\models\PartyTeam;
use app\models\PersonalOffset;
use app\models\Team;
use app\models\History;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\SiClick;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'forgot-password', 'si-index', 'si-user', 'si-admin', 'si-confirm', 'si-table', 'si-unblock'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'index-docs-out', 'create-docs-out', 'add-admin', 'feedback', 'feedback-answer',
                            'temp', 'team-view', 'personal-view', 'index-team', 'choose-color', 'plus-one', 'plus-ten', 'minus-one', 'minus-ten', 'plus', 'minus',
                            'plus-val', 'minus-val',
                            'index-personal', 'plus-one-p', 'plus-ten-p', 'minus-one-p', 'plus-two-p', 'si-index', 'si-user', 'si-admin', 'si-confirm', 'si-table', 'si-unblock'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionSiIndex($name)
    {
        if ($name == 'admin')
            return $this->render('si-admin');
        return $this->redirect('index.php?r=site/si-user&name='.$name);
    }

    public function actionSiUnblock()
    {
        $clicks = SiClick::find()->all();
        foreach ($clicks as $click)
            $click->delete();
        return $this->render('si-admin');
    }

    public function actionSiTable()
    {
        return $this->render('si-table');
    }

    public function actionSiUser($name)
    {
        $model = new SiClick();
        Yii::$app->session->set('user', $name);
        //var_dump($model->load(Yii::$app->request->post()));
        if ($model->load(Yii::$app->request->post())) {
            $this->render('si-admin');
        }
        return $this->render('si-user', ['model' => $model]);
    }

    public function actionSiConfirm()
    {
        $model = new SiClick();
        $name = User::find()->where(['username' => Yii::$app->session->get('user')])->one();
        $model->user_id = $name->id;
        $model->time = date("H:i:s");
        $duplicate = SiClick::find()->where(['user_id' => $name->id])->one();
        if ($duplicate == null)
        {
            $model->save();
        }
        return $this->redirect('index.php?r=site/si-user&name='.Yii::$app->session->get('user'));
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new LoginForm();
        if (Yii::$app->user->isGuest) {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        return $this->render('index');
    }

    public function actionIndexTeam()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('index.php?r=site/login');
        }
        $model = new Team();
        if ($model->load(Yii::$app->request->post()))
        {
            $model = Team::find()->where(['id' => $model->name])->one();
        }
        return $this->render('index-team', [
            'model' => $model,
        ]);
    }

    public function actionIndexPersonal()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('index.php?r=site/login');
        }
        $model = new PersonalOffset();
        if ($model->load(Yii::$app->request->post()))
        {
            $model = PersonalOffset::find()->where(['id' => $model->name])->one();
        }
        return $this->render('index-personal', [
            'model' => $model,
        ]);
    }

    public function actionChooseColor($id = null, $branch = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('index.php?r=site/login');
        }
        $model = new PartyTeam();
        if ($id !== null)
        {
            $model = PartyTeam::find()->where(['id' => $id])->one();
            $model->lastBranch = $branch;
        }
        return $this->render('choose-color', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
            return $this->redirect('index');
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            $user = User::find()->where(['username' => $model->username])->one();
            if ($model->password == '' && $user !== null)
                return $this->redirect('index.php?r=site/si-index&name='.$model->username);
            if ($model->password !== '' && $model->login())
            {
                return $this->render('index');
            }

        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('index.php?r=site/login');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTeamView()
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        return $this->render('team-view');
    }

    public function actionPersonalView()
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        return $this->render('personal-view');
    }

    public function actionPlus($numb, $id = null, $branch = null)
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $model = new PartyTeam();
        if ($id !== null)
        {
            $model = PartyTeam::find()->where(['id' => $id])->one();
            $model->total_score = $model->total_score + $numb;
            $model->lastBranch = $branch;
            $model->save();
            $this->WriteHistory('+'.$numb, $model->id);
            return $this->redirect(['choose-color', 'id' => $model->id, 'branch' => $branch]);
        }
        return $this->render('choose-color', [
            'model' => $model,
        ]);
    }

    public function actionPlusVal()
    {

        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $model = new PartyTeam();
        if ($_POST['PartyTeam']['id'] !== null)
        {
            $model = PartyTeam::find()->where(['id' => $_POST['PartyTeam']['id']])->one();
            $model->total_score = $model->total_score + $_POST['PartyTeam']['score'];
            $model->lastBranch = $_POST['PartyTeam']['lastBranch'];
            $model->save();
            $this->WriteHistory('+'.$_POST['PartyTeam']['score'], $model->id);
            return $this->redirect(['choose-color', 'id' => $model->id, 'branch' => $_POST['PartyTeam']['lastBranch']]);
        }
        return $this->render('choose-color', [
            'model' => $model,
        ]);
    }

    public function actionMinus($numb, $id = null, $branch = null)
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $model = new PartyTeam();
        if ($id !== null)
        {
            $model = PartyTeam::find()->where(['id' => $id])->one();
            $model->total_score = $model->total_score - $numb;
            $model->lastBranch = $branch;
            $model->save();
            $this->WriteHistory('-'.$numb, $model->id);
            return $this->redirect(['choose-color', 'id' => $model->id, 'branch' => $branch]);
        }
        return $this->render('choose-color', [
            'model' => $model,
        ]);
    }

    public function actionMinusVal()
    {

        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $model = new PartyTeam();
        if ($_POST['PartyTeam']['id'] !== null)
        {
            $model = PartyTeam::find()->where(['id' => $_POST['PartyTeam']['id']])->one();
            $model->total_score = $model->total_score - $_POST['PartyTeam']['score'];
            $model->lastBranch = $_POST['PartyTeam']['lastBranch'];
            $model->save();
            $this->WriteHistory('+'.$_POST['PartyTeam']['score'], $model->id);
            return $this->redirect(['choose-color', 'id' => $model->id, 'branch' => $_POST['PartyTeam']['lastBranch']]);
        }
        return $this->render('choose-color', [
            'model' => $model,
        ]);
    }

    public function WriteHistory($score, $party_team_id)
    {
        $history = new History();
        $history->score = $score;
        $history->party_team_id = $party_team_id;
        $history->date_time = date('Y-m-d h:i:s');
        $history->save();
    }


    /*public function actionPlusOne($id = null)
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $model = new PartyTeam();
        if ($id !== null)
        {
            $model = PartyTeam::find()->where(['id' => $id])->one();
            $model->total_score = $model->total_score + 1;
            $model->save();
        }
        return $this->render('choose-color', [
            'model' => $model,
        ]);
    }

    public function actionPlusTen($id = null)
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $model = new PartyTeam();
        if ($id !== null)
        {
            $model = PartyTeam::find()->where(['id' => $id])->one();
            $model->total_score = $model->total_score + 10;
            $model->save();
        }
        return $this->render('choose-color', [
            'model' => $model,
        ]);
    }

    public function actionMinusOne($id = null)
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $model = new PartyTeam();
        if ($id !== null)
        {
            $model = PartyTeam::find()->where(['id' => $id])->one();
            $model->total_score = $model->total_score - 1;
            $model->save();
        }
        return $this->render('choose-color', [
            'model' => $model,
        ]);
    }

    public function actionMinusTen($id = null)
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $model = new PartyTeam();
        if ($id !== null)
        {
            $model = PartyTeam::find()->where(['id' => $id])->one();
            $model->total_score = $model->total_score - 10;
            $model->save();
        }
        return $this->render('choose-color', [
            'model' => $model,
        ]);
    }


    public function actionPlusOneP($id = null)
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $model = new PartyPersonal();
        if ($id !== null)
        {
            $model = PartyPersonal::find()->where(['id' => $id])->one();
            $model->total_score = $model->total_score + 1;
            $model->save();
        }
        return $this->render('index-personal', [
            'model' => PersonalOffset::find()->where(['id' => $model->personal_offset_id])->one(),
        ]);
    }

    public function actionPlusTenP($id = null)
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $model = new PartyPersonal();
        if ($id !== null)
        {
            $model = PartyPersonal::find()->where(['id' => $id])->one();
            $model->total_score = $model->total_score + 10;
            $model->save();
        }
        return $this->render('index-personal', [
            'model' => PersonalOffset::find()->where(['id' => $model->personal_offset_id])->one(),
        ]);
    }

    public function actionMinusOneP($id = null)
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $model = new PartyPersonal();
        if ($id !== null)
        {
            $model = PartyPersonal::find()->where(['id' => $id])->one();
            $model->total_score = $model->total_score - 1;
            $model->save();
        }
        return $this->render('index-personal', [
            'model' => PersonalOffset::find()->where(['id' => $model->personal_offset_id])->one(),
        ]);
    }

    public function actionPlusTwoP($id = null)
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        $model = new PartyPersonal();
        if ($id !== null)
        {
            $model = PartyPersonal::find()->where(['id' => $id])->one();
            $model->total_score = $model->total_score + 2;
            $model->save();
        }
        return $this->render('index-personal', [
            'model' => PersonalOffset::find()->where(['id' => $model->personal_offset_id])->one(),
        ]);
    }*/
}
