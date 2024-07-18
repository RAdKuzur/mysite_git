<?php

namespace app\repositories;

use app\commands\Generator_helpers\DocHelper;

class DocScriptRepository
{
    public function countCompareTable($tablename)
    {
        $number = \Yii::$app->db->createCommand("SELECT COUNT(*) FROM $tablename")->queryScalar();
        $number2 = \Yii::$app->db2->createCommand("SELECT COUNT(*) FROM $tablename")->queryScalar();
        if ($number == $number2) {
            return true;
        }else {
            return false;
        }
    }
    public function createTemporaryTable($tableName, $sqlCommand)
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
    public function getDocInTable(){
        return \Yii::$app->db->createCommand(DocHelper::$getDocInTable)->queryAll();;
    }
    public function getDocOutTable(){
        return \Yii::$app->db->createCommand(DocHelper::$getDocOutTable)->queryAll();
    }
    public function getThirdTemporaryTable(){
        return \Yii::$app->db->createCommand(DocHelper::$secondCopyDocIn)->queryAll();
    }
    public function selectFromTable($tableName)
    {
        return \Yii::$app->db->createCommand("SELECT * FROM $tableName")->queryAll();
    }
    public function dropTable($tableName, $sqlCommand){
        $command = \Yii::$app->db->createCommand("SHOW TABLES LIKE :table", [':table' => $tableName]);
        $result = $command->queryAll();
        if (!empty($result)) {
            $command = \Yii::$app->db->createCommand($sqlCommand)->queryAll();
        }
    }
    public function dropAllTemporaryTables()
    {
        \Yii::$app->db->createCommand(DocHelper::$dropTableDocIn)->queryAll();
    }
    public function findUniqueFilesByFilepath($filepath)
    {
        return \Yii::$app->db2->createCommand("SELECT * FROM files WHERE filepath = :filepath")
            ->bindValues([':filepath' => $filepath])
            ->queryAll();
    }
    public function insertFiles($file, $filepath){
        \Yii::$app->db2->createCommand("INSERT INTO  docs2_db.files (`table_name`, `table_row_id`, `file_type`, `filepath`)
                    VALUES (:table_name, :table_row_id, :file_type, :filepath)")
            ->bindValues([
                ':table_name' => $file['table_name'],
                ':table_row_id' => $file['table_row_id'],
                ':file_type' => $file['file_type'],
                ':filepath' => $file['filepath']
            ])->execute();
        return \Yii::$app->db2->createCommand("SELECT * FROM files WHERE filepath = :filepath")
            ->bindValues([':filepath' => $filepath])
            ->queryAll();
    }
    public function selectFiles(){
        return \Yii::$app->db2->createCommand("SELECT * FROM files")
            ->queryAll();
    }
    public function updateFilepath($file, $filepath){
        \Yii::$app->db2->createCommand("UPDATE files SET filepath = :filepath WHERE filepath = :old_filepath")->
        bindValues([
            ':filepath' => $filepath,
            ':old_filepath' => $file['filepath']
        ])->execute();
    }
    public function deleteFiles($file_id){
        \Yii::$app->db2->createCommand("DELETE FROM docs2_db.files WHERE id = :file_id")
            ->bindValues([':file_id' => $file_id])
            ->execute();
    }
    public function findByFilepath($filepath){
        return \Yii::$app->db2->createCommand("SELECT * FROM files WHERE filepath = :filepath")->
        bindValues([
            ':filepath' => $filepath
        ])->execute();
    }
}