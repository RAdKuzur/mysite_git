<?php
namespace app\models;

use app\commands\Generator_helpers\DocHelper;
use yii\db\ActiveRecord;

/**
 *
 *
 * @property int $id
 * @property string $table_name
 * @property int $table_row_id
 * @property string $file_type
 *
 * @property string $filepath
 *
 *
 *
 *
 * */

class File extends ActiveRecord
{

    public function __construct(
        $tablename, $table_row_id, $file_type, $filepath
    ){
        $this->table_name = $tablename;
        $this->table_row_id = $table_row_id;
        $this->filepath = $filepath;
        $this->file_type = $file_type;
        parent::__construct();
    }
    public static function tableName()
    {
        return 'files';
    }

    public function rules()
    {
        return [
            [['table_name', 'table_row_id', 'file_type', 'filepath'], 'required'],
            [['table_row_id'], 'integer'],
            [['table_name', 'file_type', 'filepath'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_name' => 'Table Name',
            'table_row_id' => 'Table Row ID',
            'file_type' => 'File Type',
            'filepath' => 'Filepath',
        ];
    }



}