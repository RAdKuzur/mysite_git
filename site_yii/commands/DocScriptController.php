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
use PHPUnit\Exception;
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

        try {
            $this->docScriptService->compareTables('document_in');
            $tableNameFirst = 'files_tmp';
            $tableNameSecond = 'files_tmp_2';
            $tableNameThird = 'files_tmp_3';
            $this->docScriptService->CreateTemporaryTables();
            $this->docScriptService->insertDocIn();
            $this->docScriptService->copyDocIn();
            $this->docScriptService->insertFileDoc($tableNameThird);
            $this->docScriptService->addPath();
            echo 'Doc-In OK!'."\n";
        }
        catch (Exception $e){
            echo  'Ошибка кэширования'.'\n';
        }

    }
    public function actionDropQuery()
    {
        try {
            $tableNameFirst = 'files_tmp';
            $tableNameSecond = 'files_tmp_2';
            $tableNameThird = 'files_tmp_3';
            $this->docScriptService->DropTemporaryTables();
            $this->docScriptService->deleteCacheInfo();
        }
        catch (Exception $e){
            echo  $e->getMessage().'\n';
        }
        echo 'Drop-Query OK!'."\n";
    }
    public function actionCopyDocInTable()
    {
        $docInTable = $this->docScriptRepository->getDocInTable();
        $this->docScriptService->insertDocInTable($docInTable);
        echo 'Copy Doc-In OK!'."\n";
    }
    public function actionDocOutScript()
    {
        try {
            $this->docScriptService->compareTables('document_out');
            $tableNameFirst = 'files_tmp';
            $tableNameSecond = 'files_tmp_2';
            $tableNameThird = 'files_tmp_3';
            $this->docScriptService->CreateTemporaryTables();
            $this->docScriptService->insertDocOut();
            $this->docScriptService->copyDocOut();
            $this->docScriptService->insertFileDoc($tableNameThird);
            $this->docScriptService->addPath();
        }
        catch (Exception $e){
            echo $e->getMessage().'\n';
        }
        echo 'Doc-Out OK!'."\n";
    }
    public function actionCopyDocOutTable()
    {
        $docInTable = $this->docScriptRepository->getDocOutTable();
        $this->docScriptService->insertDocOutTable($docInTable);
        echo 'Copy Doc-Out OK!'."\n";
    }
    public function actionCache() {
        $this->docScriptService->addPath();
    }
    public function actionTest()
    {
        try {
            $this->docScriptService->compareTables('document_out');
        }
        catch (Exception $e){
            echo $e->getMessage().'\n';
        }

    }
}

