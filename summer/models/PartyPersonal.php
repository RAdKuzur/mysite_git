<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "party_personal".
 *
 * @property int $id
 * @property int $personal_offset_id
 * @property int $total_score
 * @property string $secondname
 * @property string $firstname
 * @property string|null $patronymic
 *
 * @property PersonalOffset $personalOffset
 */
class PartyPersonal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'party_personal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['personal_offset_id', 'total_score'], 'integer'],
            [['secondname', 'firstname', 'patronymic'], 'string', 'max' => 1000],
            [['personal_offset_id'], 'exist', 'skipOnError' => true, 'targetClass' => PersonalOffset::className(), 'targetAttribute' => ['personal_offset_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'personal_offset_id' => 'Personal Offset ID',
            'total_score' => 'Total Score',
            'secondname' => 'Secondname',
            'firstname' => 'Firstname',
            'patronymic' => 'Patronymic',
        ];
    }

    /**
     * Gets query for [[PersonalOffset]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonalOffset()
    {
        return $this->hasOne(PersonalOffset::className(), ['id' => 'personal_offset_id']);
    }
}
