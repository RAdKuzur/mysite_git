<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "si_click".
 *
 * @property int $id
 * @property int $user_id
 * @property string $time
 */
class SiClick extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'si_click';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'time'], 'required'],
            [['user_id'], 'integer'],
            [['time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'time' => 'Time',
        ];
    }
}
