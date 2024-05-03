<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;
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
    public $message;
    public $message2;
    public function options($actionID)
    {
        return ['message','message2'];
    }

    public function optionAliases()
    {
        return ['m' => 'message', 'd' => 'message2'];
    }
    public function actionIndex()
    {

        $model = new TestDocumentOutWork();
        $model->document_number = 1;
        $model->document_postfix = null;
        $model->document_date = date("Y-m-d");
        $model->document_name = "Test Document Name";
        $model->document_theme = "Test Document Theme";
        $model->correspondent_id = 1;
        $model->company_id = 1;
        $model->position_id = 1;
        $model->signed_id = 1;
        $model->executor_id = 1;
        $model->send_method_id = 2;
        $model->sent_date = date("Y-m-d");
        $model->Scan = 'Test Scan';
        $model->doc = 'Test Document';
        $model->applications = 'Test Applications';
        $model->creator_id = 1;
        $model->last_edit_id = 1;
        $model->key_words = 'Test Key Words';

        if($model->save(false)) {
            echo 'Запись добавлена' . "\n";
        }
        else {
            echo 'Запись не добавлена' . "\n";
        }
    }
}
