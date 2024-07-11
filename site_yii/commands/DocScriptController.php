<?php
namespace app\commands;

namespace app\commands;
use app\models\common\DocumentOut;
use app\models\File;
use app\models\work\DocumentInWork;
use app\repositories\TransferFileRepository;
use app\services\TransferFileService;
use Yii;
use yii\console\Controller;
use app\commands;
use app\commands\Generator_helpers\DocHelper;
class DocScriptController extends Controller
{
    public function actionDocScript()
    {
        $tableNameFirst = 'files_tmp';
        $command = \Yii::$app->db->createCommand("SHOW TABLES LIKE :table", [':table' => $tableNameFirst]);
        $result = $command->queryAll();
        if (empty($result)) {
            $command = \Yii::$app->db->createCommand(DocHelper::$createQueryTableFirst)->queryAll();
        }
        $tableNameSecond = 'files_tmp_2';
        $command = \Yii::$app->db->createCommand("SHOW TABLES LIKE :table", [':table' => $tableNameSecond]);
        $result = $command->queryAll();
        if (empty($result)) {
            $command = \Yii::$app->db->createCommand(DocHelper::$createQueryTableSecond)->queryAll();
        }
        $tableNameThird = 'files_tmp_3';
        $command = \Yii::$app->db->createCommand("SHOW TABLES LIKE :table", [':table' => $tableNameThird]);
        $result = $command->queryAll();
        if (empty($result)) {
            $command = \Yii::$app->db->createCommand(DocHelper::$createQueryTableThird)->queryAll();
        }
        $command = \Yii::$app->db->createCommand(DocHelper::$insertDocInDoc)->queryAll();
        $command = \Yii::$app->db->createCommand(DocHelper::$insertDocInScan)->queryAll();
        $command = \Yii::$app->db->createCommand(DocHelper::$insertDocInApplication)->queryAll();
        $command = \Yii::$app->db->createCommand(DocHelper::$splitDocIn)->queryAll();
        $command = \Yii::$app->db->createCommand(DocHelper::$firstCopyDocIn)->queryAll();
        $command = \Yii::$app->db->createCommand(DocHelper::$deleteEmptyDocIn)->queryAll();
        $files = \Yii::$app->db->createCommand(DocHelper::$secondCopyDocIn)->queryAll();
        $db_files = Yii::$app->db->createCommand("SELECT * FROM $tableNameThird")->queryAll();
        foreach ($db_files as $file) {
            Yii::$app->db2->createCommand()
                ->insert('files', $file)
                ->execute();
        }
        $command = \Yii::$app->db->createCommand(DocHelper::$dropTableDocIn)->queryAll();

    }
}

