<?php

namespace app\models\work;

use app\models\File;

class FileWork extends File
{
    public function __construct(
        $tablename, $table_row_id, $file_type, $filepath
    ){
        parent::__construct($tablename, $table_row_id, $file_type, $filepath);
    }
}