<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;
use app\commands\Generator_helpers\DocHelper;
use app\commands\test_models\TestDocumentInWork;
use app\commands\test_models\TestDocumentOutWork;
use app\controllers\DocsOutController;
use app\models\common\People;
use app\models\common\SendMethod;
use app\commands\test_models\TestDocumentOrderWork;
use Yii;
use app\models\common\DocumentOut;
use app\models\components\Logger;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\web\UploadedFile;
use app\commands;
class GenerateDocsController extends Controller
{
    public $number, $type;
    public function options($actionID)
    {
        return ['number', 'type'];
    }
    public function optionAliases()
    {
        return ['n' => 'number', 't' => 'type'];
    }
    public function actionDocoutcreate($number)
    {
        for($i = 0; $i < $number; $i++) {
            $FirstRandomKey = array_rand(DocHelper::$array_name);
            $SecondRandomKey = array_rand(DocHelper::$array_theme);
            $ThirdRandomKey = array_rand(DocHelper::$array_keywords);
            $year = date('Y');
            $startDate = strtotime("01 January $year");
            $endDate = strtotime(date("Y-m-d"));
            $randomTimestamp = mt_rand($startDate, $endDate);
            $randomDate = date('Y-m-d', $randomTimestamp);
            $document_number = TestDocumentOutWork::find()
                ->select('document_number')
                ->max('document_number')+1;
            $model = new TestDocumentOutWork($document_number, $randomDate, $FirstRandomKey, $SecondRandomKey, $ThirdRandomKey);
            $model->save(false);
        }
    }
    public function actionDocincreate($number){
        for($i = 0; $i < $number; $i++) {
            $SecondRandomKey = array_rand(DocHelper::$array_theme);
            $ThirdRandomKey = array_rand(DocHelper::$array_keywords);
            $real_number = rand(1,10000);
            $local_number = TestDocumentInWork::find()
                ->select('local_number')
                ->max('local_number') + 1;
            $year = date('Y');
            $startDate = strtotime("01 January $year");
            $endDate = strtotime(date("Y-m-d"));
            $randomTimestamp = mt_rand($startDate, $endDate);
            $local_date = date('Y-m-d', $randomTimestamp);
            $real_date = date('Y-m-d', $randomTimestamp);
            $model = new TestDocumentInWork($local_number, $local_date, $real_number, $real_date,
                $SecondRandomKey, $ThirdRandomKey);
            $model->save(false);
        }

    }
    public function actionOrder($number = null, $type = null){
        for($i = 0; $i < $this->number; $i++) {
            $FirstRandomKey = array_rand(DocHelper::$array_name);
            $SecondRandomKey = array_rand(DocHelper::$array_keywords);
            $real_number = TestDocumentOrderWork::find()
                    ->select('order_copy_id')
                    ->max('order_copy_id') + 1;
            $year = date('Y');
            $startDate = strtotime("01 January $year");
            $endDate = strtotime(date("Y-m-d"));
            $randomTimestamp = mt_rand($startDate, $endDate);
            $date = date('Y-m-d', $randomTimestamp);
            $model = new TestDocumentOrderWork($real_number, $date, $FirstRandomKey, $SecondRandomKey, $this->type);
            $model->save(false);
        }
        //$this->prompt();
    }
}
