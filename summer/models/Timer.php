<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "timer".
 *
 * @property int $id
 * @property string $name
 * @property int $hours
 * @property int $minutes
 * @property int $seconds
 * @property string $check_time
 */
class Timer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['hours', 'minutes', 'seconds'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['check_time'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'hours' => 'Hours',
            'minutes' => 'Minutes',
            'seconds' => 'Seconds',
            'check_time' => 'Check Time',
        ];
    }
}
