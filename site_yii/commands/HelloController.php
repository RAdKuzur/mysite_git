<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;
use Yii;
use app\models\common\DocumentOut;
use app\models\components\Logger;
use app\models\work\DocumentOutWork;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\web\UploadedFile;

class HelloController extends Controller
{
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
    public function actionIndex($message = ' ', $message2 = ' ')
    {
        $model = new DocumentOutWork();
        $model->document_name = "default";

        if ($model->load(Yii::$app->request->post())) {
            $model->applications = '';
            $model->doc = '';
            $model->getDocumentNumber();
            $model->Scan = '';

            $model->creator_id = Yii::$app->user->identity->getId();
            $model->scanFile = UploadedFile::getInstance($model, 'scanFile');
            $model->applicationFiles = UploadedFile::getInstances($model, 'applicationFiles');
            $model->docFiles = UploadedFile::getInstances($model, 'docFiles');


            if ($model->validate(false)) {
                if ($model->scanFile != null)
                    $model->uploadScanFile();
                if ($model->applicationFiles != null)
                    $model->uploadApplicationFiles();
                if ($model->docFiles != null)
                    $model->uploadDocFiles();
                $model->save(false);
                Logger::WriteLog(Yii::$app->user->identity->getId(), 'Добавлен исходящий документ ' . $model->document_theme);

            }
            echo $this->message . $this->message2 . "\n";


            return ExitCode::OK;
        }
    }
}
