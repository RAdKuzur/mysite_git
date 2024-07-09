<?php

namespace app\commands;
use app\models\common\DocumentOut;
use app\models\Files;
use app\models\work\DocumentInWork;
use yii\console\Controller;
use app\commands;
use app\commands\Generator_helpers\DocHelper;
class TransferFileController extends Controller
{
    public $number;
    public function options($actionID)
    {
        return ['number', 'type'];
    }
    public function optionAliases()
    {
        return ['n' => 'number', 't' => 'type'];
    }
    public function actionTransfer()
    {
        $filename = 'name';
        $doc_in_model = DocumentInWork::find()->all();
        foreach ($doc_in_model as $doc_in) {
            if($doc_in->doc != NULL){
                $filepath = '\uploads\\files\\document-in\\doc';
                //$model = new Files('document_in', $doc_in->id , doc , $filepath);
            }
            if($doc_in->scan != NULL){
                $filepath = '\uploads\\files\\document-in\\scan';
                //$model = new Files('document_in', $doc_in->id , scan , $filepath);
            }
            if($doc_in->applications != NULL){
                $filepath = '\uploads\\files\\document-in\\applications';
                //$model = new Files('document_in', $doc_in->id , applications , $filepath);
            }
            $filepath = (new Generator_helpers\DocHelper)->ParseName($filename);
            $type = 'doc';
            //$model->save(false);
        }
    }

}