<?php
namespace app\commands;

namespace app\commands;
use app\models\common\DocumentOut;
use app\models\File;
use app\models\work\DocumentInWork;
use app\repositories\DocScriptRepository;
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
    public DocScriptRepository $docScriptRepository;
    public function  __construct(
        $id,
        $module,
        DocScriptService $docScriptService,
        DocScriptRepository $docScriptRepository,
        $config = [])
    {
        $this->docScriptRepository = $docScriptRepository;
        $this->docScriptService = $docScriptService;
        parent::__construct($id, $module, $config);
    }
    public function actionDocInScript()
    {
        $tableNameFirst = 'files_tmp';
        $tableNameSecond = 'files_tmp_2';
        $tableNameThird = 'files_tmp_3';
        $this->docScriptService->CreateTemporaryTables();
        $this->docScriptService->insertDocIn();
        $this->docScriptService->copyDocIn();
        $this->docScriptService->insertFileDoc($tableNameThird);
        $this->docScriptService->addPath();
    }
    public function actionDropQuery()
    {
        $tableNameFirst = 'files_tmp';
        $tableNameSecond = 'files_tmp_2';
        $tableNameThird = 'files_tmp_3';
        $this->docScriptService->DropTemporaryTables();
        $this->docScriptService->deleteCacheInfo();

    }
    public function actionCopyDocInTable()
    {
        $docInTable = $this->docScriptRepository->getDocInTable();
        $this->docScriptService->insertDocInTable($docInTable);
    }
    public function actionDocOutScript()
    {
        $tableNameFirst = 'files_tmp';
        $tableNameSecond = 'files_tmp_2';
        $tableNameThird = 'files_tmp_3';
        $this->docScriptService->CreateTemporaryTables();
        $this->docScriptService->insertDocOut();
        $this->docScriptService->copyDocOut();
        $this->docScriptService->insertFileDoc($tableNameThird);
        $this->docScriptService->addPath();
    }
    public function actionCopyDocOutTable()
    {
        $docInTable = $this->docScriptRepository->getDocOutTable();
        $this->docScriptService->insertDocOutTable($docInTable);
    }
    public function actionCache() {
        $this->docScriptService->addPath();
    }
}

