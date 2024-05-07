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
    public function options($actionID)
    {
        return ['number'];
    }

    public function optionAliases()
    {
        return ['n' => 'number'];
    }
    public function actionDocoutcreate($number)
    {
        for($i = 0; $i < $number; $i++) {
            $FirstRandomKey = array_rand(Helper::$array_name);
            $SecondRandomKey = array_rand(Helper::$array_theme);
            $ThirdRandomKey = array_rand(Helper::$array_keywords);
            $year = date('Y');
            $startDate = strtotime("01 January $year");
            $endDate = strtotime(date("Y-m-d"));
            $randomTimestamp = mt_rand($startDate, $endDate);
            $randomDate = date('Y-m-d', $randomTimestamp);
            $document_number = TestDocumentOutWork::find()
                ->select('document_number')
                ->max('document_number');
            $model = new TestDocumentOutWork($document_number, $randomDate, $FirstRandomKey, $SecondRandomKey, $ThirdRandomKey);
            $model->save(false);
        }
    }
    public function actionDocincreate($number){
        for($i = 0; $i < $number; $i++) {
            $SecondRandomKey = array_rand(Helper::$array_theme);
            $ThirdRandomKey = array_rand(Helper::$array_keywords);
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
}
