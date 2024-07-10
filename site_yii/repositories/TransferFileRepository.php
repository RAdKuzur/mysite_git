<?php

namespace app\repositories;

use app\models\Files;
use app\models\work\DocumentInWork;
use app\models\work\DocumentOutWork;

class TransferFileRepository
{
    public function findByPath($filepath, $file){
        $query = new \yii\db\Query;
        return $query->select('*')
            ->from('files')
            ->where(['filepath' => $filepath.$file])
            ->one();
    }
    public function allDocIn(){
        return DocumentInWork::find()->all();
    }
    public function allDocOut(){
        return DocumentOutWork::find()->all();
    }
    public function insertDoc($table, $doc_in,  $type, $filepath , $file)
    {
        $model = new Files($table , $doc_in->id , $type , $filepath.$file);
        $model->save(false);
    }
}