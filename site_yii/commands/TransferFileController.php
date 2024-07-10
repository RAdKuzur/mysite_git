<?php

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
class TransferFileController extends Controller
{
    public TransferFileService $transferFileService;
    public TransferFileRepository $transferFileRepository;
    public $number;
    public function __construct(
        $id,
        $module,
        TransferFileRepository $repository,
        TransferFileService $service,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->transferFileRepository = $repository;
        $this->transferFileService = $service;
    }
    public function options($actionID)
    {
        return ['number', 'type'];
    }
    public function optionAliases()
    {
        return ['n' => 'number', 't' => 'type'];
    }
    public function actionTransferDocIn()
    {
        $currentDirectory = "/upload/files/document-in";
        $doc_in_model = $this->transferFileRepository->allDocIn();
        foreach ($doc_in_model as $doc_in) {
            if($doc_in->doc != NULL){
                $table = 'document_in';
                $this->transferFileService->insertDoc($currentDirectory, $doc_in, $table);
            }
            if($doc_in->scan != NULL){
                $table = 'document_in';
                $this->transferFileService->insertScan($currentDirectory, $doc_in, $table);
            }
            if($doc_in->applications != NULL){
                $table = 'document_in';
                $this->transferFileService->insertApplication($currentDirectory, $doc_in, $table);
            }
        }
    }
    public function actionTransferDocOut(){
        $currentDirectory = "/upload/files/document-out";
        $doc_in_model = $this->transferFileRepository->allDocOut();
        foreach ($doc_in_model as $doc_in) {
            if($doc_in->doc != NULL){
                $table = 'document_out';
                $this->transferFileService->insertDoc($currentDirectory, $doc_in, $table);
            }
            if($doc_in->Scan != NULL){
                $table = 'document_out';
                $this->transferFileService->insertScanTwo($currentDirectory, $doc_in, $table);
            }
            if($doc_in->applications != NULL){
                $table = 'document_out';
                $this->transferFileService->insertApplication($currentDirectory, $doc_in, $table);
            }
        }
    }

    public function actionCopy()
    {
        $db_files = Yii::$app->db->createCommand("SELECT * FROM files")->queryAll();
        foreach ($db_files as $file) {
            Yii::$app->db2->createCommand()
                ->insert('files', $file)
                ->execute();
        }

    }
}