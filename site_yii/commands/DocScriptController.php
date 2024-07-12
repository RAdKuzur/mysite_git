<?php
namespace app\commands;

namespace app\commands;
use app\models\common\DocumentOut;
use app\models\File;
use app\models\work\DocumentInWork;
use app\repositories\TransferFileRepository;
use app\services\DocScriptService;
use app\services\TransferFileService;
use Yii;
use yii\console\Controller;
use app\commands;
use app\commands\Generator_helpers\DocHelper;
class DocScriptController extends Controller
{
    public DocScriptService $docScriptService;
    public function  __construct($id, $module, DocScriptService $docScriptService, $config = [])
    {
        $this->docScriptService = $docScriptService;
        parent::__construct($id, $module, $config);
    }
    public function actionDocScript()
    {
        $tableNameFirst = 'files_tmp';
        $tableNameSecond = 'files_tmp_2';
        $tableNameThird = 'files_tmp_3';
        $this->docScriptService->CreateTable($tableNameFirst, DocHelper::$createQueryTableFirst);
        $this->docScriptService->CreateTable($tableNameSecond, DocHelper::$createQueryTableSecond );
        $this->docScriptService->CreateTable($tableNameThird, DocHelper::$createQueryTableThird);
        $this->docScriptService->insertDocIn();
        $this->docScriptService->copyDocIn();
        $this->docScriptService->insertFileDocIn($tableNameThird);
    }
    public function actionDropQuery()
    {

        $tableNameFirst = 'files_tmp';
        $tableNameSecond = 'files_tmp_2';
        $tableNameThird = 'files_tmp_3';
        $this->docScriptService->dropTable($tableNameFirst, DocHelper::$dropTableFirstDocIn);
        $this->docScriptService->dropTable($tableNameSecond, DocHelper::$dropTableSecondDocIn);
        $this->docScriptService->dropTable($tableNameThird, DocHelper::$dropTableThirdDocIn);
        $this->docScriptService->deleteCacheInfo();
    }
    public function actionCopyDocInTable()
    {
        $docInTable = $this->docScriptService->getDocInTable();
        $this->docScriptService->insertDocInTable($docInTable);
    }
    public function actionCache() {
        if(Yii::$app->cache->exists('data')) {
            echo "+";
        } else {
            echo "-";
        }
    }
}

