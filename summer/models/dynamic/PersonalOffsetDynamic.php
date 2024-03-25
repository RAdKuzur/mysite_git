<?php

namespace app\models\dynamic;

use yii\base\Model;

class PersonalOffsetDynamic extends Model
{
    public $personal_offset_id;

    public function rules()
    {
        return [
            [['personal_offset_id'], 'integer'],
        ];
    }
}