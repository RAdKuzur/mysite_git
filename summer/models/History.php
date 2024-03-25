<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property string $score
 * @property string $date_time
 * @property int $party_team_id
 *
 * @property PartyTeam $partyTeam
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['score', 'date_time', 'party_team_id'], 'required'],
            [['date_time'], 'safe'],
            [['party_team_id'], 'integer'],
            [['score'], 'string', 'max' => 100],
            [['party_team_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartyTeam::className(), 'targetAttribute' => ['party_team_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'score' => 'Score',
            'date_time' => 'Date Time',
            'party_team_id' => 'Party Team ID',
        ];
    }

    /**
     * Gets query for [[PartyTeam]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartyTeam()
    {
        return $this->hasOne(PartyTeam::className(), ['id' => 'party_team_id']);
    }
}
