<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;
use app\commands\Generator_helpers\Helper;
use app\controllers\DocsOutController;
use app\models\common\People;
use app\models\common\SendMethod;
use Yii;
use app\models\common\DocumentOut;
use app\models\components\Logger;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\web\UploadedFile;
use app\commands;
class HelloController extends Controller
{
    /**
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public $number;
    public TestDocumentOutWork $model;
    public function __construct(
        $id, $module,
        TestDocumentOutWork $model,
        $config = []
    )
    {
        $this->model = $model;
        $document_number = TestDocumentOutWork::find()
            ->select('document_number')
            ->max('document_number');
        $FirstRandomKey = array_rand(Helper::$array_name);
        $SecondRandomKey = array_rand(Helper::$array_theme);
        $ThirdRandomKey = array_rand(Helper::$array_keywords);
        $year = date('Y');
        $startDate = strtotime("01 January $year");
        $endDate = strtotime(date("Y-m-d"));
        $randomTimestamp = mt_rand($startDate, $endDate);
        $randomDate = date('Y-m-d', $randomTimestamp);
        $this->model->document_number = $document_number + 1;
        $this->model->document_postfix = null;
        $this->model->document_date = $randomDate;
        $this->model->document_name = Helper::$array_name[$FirstRandomKey];
        $this->model->document_theme = Helper::$array_theme[$SecondRandomKey];
        $this->model->correspondent_id = 1;
        $this->model->company_id = 1;
        $this->model->position_id = 1;
        $this->model->signed_id = 1;
        $this->model->executor_id = 1;
        $this->model->send_method_id = 2;
        $this->model->sent_date = $randomDate;
        $this->model->creator_id = 1;
        $this->model->last_edit_id = 1;
        $this->model->key_words = Helper::$array_keywords[$ThirdRandomKey];
        $this->model->save(false);
        parent::__construct($id, $module, $config);

    }

    public function options($actionID)
    {
        return ['number'];
    }

    public function optionAliases()
    {
        return ['n' => 'number'];
    }
    public function actionIndex($number)
    {
        for($i = 0; $i < $number; $i++) {
            //Yii::createObject(TestDocumentOutWork::class);
            $model = new TestDocumentOutWork();
            /*
            $document_number = TestDocumentOutWork::find()
                ->select('document_number')
                ->max('document_number');
            $FirstRandomKey = array_rand(Helper::$array_name);
            $SecondRandomKey = array_rand(Helper::$array_theme);
            $ThirdRandomKey = array_rand(Helper::$array_keywords);
            $year = date('Y');
            $startDate = strtotime("01 January $year");
            $endDate = strtotime(date("Y-m-d"));
            $randomTimestamp = mt_rand($startDate, $endDate);
            $randomDate = date('Y-m-d', $randomTimestamp);
            $model->document_number = $document_number + 1;
            $model->document_postfix = null;
            $model->document_date = $randomDate;
            $model->document_name = Helper::$array_name[$FirstRandomKey];
            $model->document_theme = Helper::$array_theme[$SecondRandomKey];
            $model->correspondent_id = 1;
            $model->company_id = 1;
            $model->position_id = 1;
            $model->signed_id = 1;
            $model->executor_id = 1;
            $model->send_method_id = 2;
            $model->sent_date = $randomDate;
            //$model->Scan = 'Test Scan';
            //$model->doc = 'Test Document';
            //$model->applications = 'Test Applications';
            $model->creator_id = 1;
            $model->last_edit_id = 1;
            $model->key_words = Helper::$array_keywords[$ThirdRandomKey];
           */
            $counter = $i + 1;
            /*if ($model->save(false)) {
                echo 'Запись '.$counter.' добавлена' . "\n";
            } else {
                echo 'Запись '.$counter.' не добавлена' . "\n";
            }*/
        }
    }
}
