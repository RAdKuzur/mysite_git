<?php

namespace app\services;
use app\commands\Generator_helpers;
use app\commands\Generator_helpers\DocHelper;
use Exception;
use Yii;

class DocScriptService
{
    public function createTable($tableName, $sqlCommand)
    {
        $command = \Yii::$app->db->createCommand("SHOW TABLES LIKE :table", [':table' => $tableName]);
        $result = $command->queryAll();
        if (empty($result)) {
            \Yii::$app->db->createCommand($sqlCommand)->queryAll();
        }
    }
    public function insertDocIn(){
        \Yii::$app->db->createCommand(DocHelper::$insertDocInDoc)->queryAll();
        \Yii::$app->db->createCommand(DocHelper::$insertDocInScan)->queryAll();
        \Yii::$app->db->createCommand(DocHelper::$insertDocInApplication)->queryAll();
    }
    public function insertDocOut(){
        \Yii::$app->db->createCommand(DocHelper::$insertDocOutDoc)->queryAll();
        \Yii::$app->db->createCommand(DocHelper::$insertDocOutScan)->queryAll();
        \Yii::$app->db->createCommand(DocHelper::$insertDocOutApplication)->queryAll();
    }

    public function copyDocIn(){
        \Yii::$app->db->createCommand(DocHelper::$splitDocIn)->queryAll();
        \Yii::$app->db->createCommand(DocHelper::$firstCopyDocIn)->queryAll();
        \Yii::$app->db->createCommand(DocHelper::$deleteEmptyDocIn)->queryAll();
    }
    public function copyDocOut(){
        \Yii::$app->db->createCommand(DocHelper::$splitDocOut)->queryAll();
        \Yii::$app->db->createCommand(DocHelper::$firstCopyDocOut)->queryAll();
        \Yii::$app->db->createCommand(DocHelper::$deleteEmptyDocOut)->queryAll();
    }

    public function insertFileDocIn($tableName){
        $array_id = [];
        $files = \Yii::$app->db->createCommand(DocHelper::$secondCopyDocIn)->queryAll();
        $db_files = Yii::$app->db->createCommand("SELECT * FROM $tableName")->queryAll();
        $cache = Yii::$app->cache;
        $cache->flush();
        foreach ($db_files as $file) {
            $filepath = $file['filepath'];
            $result = Yii::$app->db2->createCommand("SELECT * FROM files WHERE filepath = :filepath")
                ->bindValues([':filepath' => $filepath])
                ->queryAll();
            if(!$result) {
                Yii::$app->db2->createCommand("INSERT INTO  docs2_db.files (`table_name`, `table_row_id`, `file_type`, `filepath`)
                    VALUES (:table_name, :table_row_id, :file_type, :filepath)")
                    ->bindValues([
                        ':table_name' => $file['table_name'],
                        ':table_row_id' => $file['table_row_id'],
                        ':file_type' => $file['file_type'],
                        ':filepath' => $file['filepath']
                    ])->execute();
                $result = Yii::$app->db2->createCommand("SELECT * FROM files WHERE filepath = :filepath")
                    ->bindValues([':filepath' => $filepath])
                    ->queryAll();
                array_push($array_id, $result[0]['id']);
            }
        }
        if(Yii::$app->cache->exists('data')) {
            throw new Exception('Ошибка');
        } else {
            $cache->set('data', $array_id, 3600);
        }

        \Yii::$app->db->createCommand(DocHelper::$dropTableDocIn)->queryAll();
    }
    public function insertFileDocOut($tableName){
        $array_id = [];
        $files = \Yii::$app->db->createCommand(DocHelper::$secondCopyDocOut)->queryAll();
        $db_files = Yii::$app->db->createCommand("SELECT * FROM $tableName")->queryAll();
        $cache = Yii::$app->cache;
        $cache->flush();
        foreach ($db_files as $file) {
            $filepath = $file['filepath'];
            $result = Yii::$app->db2->createCommand("SELECT * FROM files WHERE filepath = :filepath")
                ->bindValues([':filepath' => $filepath])
                ->queryAll();
            if(!$result) {
                Yii::$app->db2->createCommand("INSERT INTO  docs2_db.files (`table_name`, `table_row_id`, `file_type`, `filepath`)
                    VALUES (:table_name, :table_row_id, :file_type, :filepath)")
                    ->bindValues([
                    ':table_name' => $file['table_name'],
                    ':table_row_id' => $file['table_row_id'],
                    ':file_type' => $file['file_type'],
                    ':filepath' => $file['filepath']
                    ])->execute();
                $result = Yii::$app->db2->createCommand("SELECT * FROM files WHERE filepath = :filepath")
                    ->bindValues([':filepath' => $filepath])
                    ->queryAll();
                array_push($array_id, $result[0]['id']);
            }
        }
        if(Yii::$app->cache->exists('data')) {
            throw new Exception('Ошибка');
        } else {
            $cache->set('data', $array_id, 3600);
        }

        \Yii::$app->db->createCommand(DocHelper::$dropTableDocOut)->queryAll();
    }
    public function dropTable($tableName, $sqlCommand){

        $command = \Yii::$app->db->createCommand("SHOW TABLES LIKE :table", [':table' => $tableName]);
        $result = $command->queryAll();
        if (!empty($result)) {
            $command = \Yii::$app->db->createCommand($sqlCommand)->queryAll();
        }
    }
    public function deleteCacheInfo()
    {
        $cache = Yii::$app->cache;
        if(Yii::$app->cache->exists('data')) {
            $keys = $cache->get('data');
            foreach ($keys as $file_id) {
                Yii::$app->db2->createCommand("DELETE FROM docs2_db.files WHERE id = :file_id")
                    ->bindValues([':file_id' => $file_id])
                    ->execute();
            }
            $cache->flush();
        }
        else {
            throw new Exception('Ошибка 2');
        }
    }
    public function getDocInTable(){
        return \Yii::$app->db->createCommand(DocHelper::$getDocInTable)->queryAll();;
    }
    public function insertDocInTable($data)
    {
        foreach ($data as $doc){
            $id = $doc['id'];
            $local_number = $doc['local_number'];
            $local_postfix = $doc['local_postfix'];
            $local_date = $doc['local_date'];
            $real_number = $doc['real_number'];
            $real_date = $doc['real_date'];
            $correspondent_id = $doc['correspondent_id'];
            $position_id = $doc['position_id'];
            $company_id = $doc['company_id'];
            $document_theme = $doc['document_theme'];
            $signed_id = $doc['signed_id'];
            $target = $doc['target'];
            $get_id = $doc['get_id'];
            $send_method_id = $doc['send_method_id'];
            $creator_id = $doc['creator_id'];
            $last_edit_id = $doc['last_edit_id'];
            $key_words = $doc['key_words'];
            $needAnswer = $doc['needAnswer'];
            \Yii::$app->db2->createCommand("
    INSERT INTO  docs2_db.document_in (id, local_number, local_postfix, local_date, real_number, real_date, correspondent_id, 
                             position_id, company_id, document_theme, signed_id, target, get_id, send_method, 
                             creator_id, last_edit_id, key_words, need_answer)
                    VALUES (:id, :local_number, :local_postfix, :local_date, :real_number, :real_date, :correspondent_id, 
                            :position_id, :company_id, :document_theme, :signed_id, :target, :get_id, :send_method, 
                            :creator_id, :last_edit_id, :key_words, :need_answer)
")->bindValues([
                ':id' => $id,
                ':local_number' => $local_number,
                ':local_postfix' => $local_postfix,
                ':local_date' => $local_date,
                ':real_number' => $real_number,
                ':real_date' => $real_date,
                ':correspondent_id' => $correspondent_id,
                ':position_id' => $position_id,
                ':company_id' => $company_id,
                ':document_theme' => $document_theme,
                ':signed_id' => $signed_id,
                ':target' => $target,
                ':get_id' => $get_id,
                ':send_method' => $send_method_id,
                ':creator_id' => $creator_id,
                ':last_edit_id' => $last_edit_id,
                ':key_words' => $key_words,
                ':need_answer' => $needAnswer,
            ])->execute();
        }
    }
    public function getDocOutTable(){
        return \Yii::$app->db->createCommand(DocHelper::$getDocOutTable)->queryAll();
    }
    public function insertDocOutTable($data)
    {
        foreach ($data as $doc) {
            $id = $doc['id'];
            $document_number = $doc['document_number'];
            $document_postfix = $doc['document_postfix'];
            $document_date = $doc['document_date'];
            $document_name = $doc['document_name'];
            $document_theme = $doc['document_theme'];
            $correspondent_id = $doc['correspondent_id'];
            $position_id = $doc['position_id'];
            $company_id = $doc['company_id'];
            $signed_id = $doc['signed_id'];
            $executor_id = $doc['executor_id'];
            $send_method_id = $doc['send_method_id'];
            $sent_date = $doc['sent_date'];
            $creator_id = $doc['creator_id'];
            $last_edit_id = $doc['last_edit_id'];
            $key_words = $doc['key_words'];
            $is_answer = $doc['isAnswer'];

            \Yii::$app->db2->createCommand("
        INSERT INTO  docs2_db.document_out (id, document_number, document_postfix, document_date, document_name, document_theme, correspondent_id,
                                           position_id, company_id, signed_id, executor_id, send_method, sent_date,
                                           creator_id, last_edit_id, key_words, is_answer)
        VALUES (:id, :document_number, :document_postfix, :document_date, :document_name, :document_theme, :correspondent_id,
                :position_id, :company_id, :signed_id, :executor_id, :send_method, :sent_date,
                :creator_id, :last_edit_id, :key_words, :is_answer)
    ")->bindValues([
                ':id' => $id,
                ':document_number' => $document_number,
                ':document_postfix' => $document_postfix,
                ':document_date' => $document_date,
                ':document_name' => $document_name,
                ':document_theme' => $document_theme,
                ':correspondent_id' => $correspondent_id,
                ':position_id' => $position_id,
                ':company_id' => $company_id,
                ':signed_id' => $signed_id,
                ':executor_id' => $executor_id,
                ':send_method' => $send_method_id,
                ':sent_date' => $sent_date,
                ':creator_id' => $creator_id,
                ':last_edit_id' => $last_edit_id,
                ':key_words' => $key_words,
                ':is_answer' => $is_answer,
            ])->execute();
        }
    }
}
