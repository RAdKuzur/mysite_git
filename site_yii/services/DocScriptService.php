<?php

namespace app\services;
use app\commands\Generator_helpers;
use app\commands\Generator_helpers\DocHelper;
use app\repositories\DocScriptRepository;
use Exception;
use Yii;

class DocScriptService
{
    public DocScriptRepository $docScriptRepository;
    public function  __construct(
        $id,
        $module,
        DocScriptRepository $docScriptRepository,
        $config = [])
    {
        $this->docScriptRepository = $docScriptRepository;
    }
    public function createTemporaryTables()
    {
        $tableNameFirst = 'files_tmp';
        $tableNameSecond = 'files_tmp_2';
        $tableNameThird = 'files_tmp_3';
        $this->docScriptRepository->CreateTemporaryTable($tableNameFirst, DocHelper::$createQueryTableFirst);
        $this->docScriptRepository->CreateTemporaryTable($tableNameSecond, DocHelper::$createQueryTableSecond );
        $this->docScriptRepository->CreateTemporaryTable($tableNameThird, DocHelper::$createQueryTableThird);
    }
    public function insertDocIn(){
        $this->docScriptRepository->InsertDocIn();
    }
    public function insertDocOut(){
        $this->docScriptRepository->InsertDocOut();
    }
    public function copyDocIn(){
        $this->docScriptRepository->CopyDocIn();
    }
    public function copyDocOut(){
        $this->docScriptRepository->CopyDocOut();
    }

    public function insertFileDoc($tableName){
        $array_id = [];
        $db_files = $this->docScriptRepository->selectFromTable($tableName);
        $cache = Yii::$app->cache;
        $cache->flush();
        foreach ($db_files as $file) {
            $filepath = $file['filepath'];
            $result = $this->docScriptRepository->findUniqueFilesByFilepath($filepath);
            if(!$result) {
                $result = $this->docScriptRepository->insertFiles($file, $filepath);
                array_push($array_id, $result[0]['id']);
            }
        }
        if(Yii::$app->cache->exists('data')) {
            throw new Exception('Ошибка');
        } else {
            $cache->set('data', $array_id, 3600);
        }
        $this->docScriptRepository->dropAllTemporaryTables();
    }
    public function dropTemporaryTables(){
        $tableNameFirst = 'files_tmp';
        $tableNameSecond = 'files_tmp_2';
        $tableNameThird = 'files_tmp_3';
        $this->docScriptRepository->dropTable($tableNameFirst, DocHelper::$dropTableFirstDocIn);
        $this->docScriptRepository->dropTable($tableNameSecond, DocHelper::$dropTableSecondDocIn);
        $this->docScriptRepository->dropTable($tableNameThird, DocHelper::$dropTableThirdDocIn);
    }
    public function deleteCacheInfo()
    {
        $cache = Yii::$app->cache;
        if(Yii::$app->cache->exists('data')) {
            $keys = $cache->get('data');
            foreach ($keys as $file_id) {
                $this->docScriptRepository->deleteFiles($file_id);
            }
            $cache->flush();
        }
        else {
            throw new Exception('Ошибка кэширования');
        }
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
    public function addPath()
    {
        $files = $this->docScriptRepository->selectFiles();
        foreach ($files as $file) {
            $filepath = '/uploads/files/'.$file['table_name'].'/'.$file['file_type'].'/'.$file['filepath'];
            $result = $this->docScriptRepository->findByFilepath($filepath);
            if(!$result && $file['filepath'][0]!= '/'){
                $this->docScriptRepository->updateFilepath($file, $filepath);
            }
        }

    }

}
