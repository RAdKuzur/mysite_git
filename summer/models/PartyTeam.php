<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "party_team".
 *
 * @property int $id
 * @property int $team_id
 * @property int $color_id
 * @property string $team_name
 * @property int $total_score
 *
 * @property Team $team
 * @property Color $color
 */
class PartyTeam extends \yii\db\ActiveRecord
{
    public $lastBranch; //последний отдел из которого голосовали [0 - Кванториум, 1 - Технопарк]

    public $score; //количество баллов
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'party_team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['team_id', 'color_id', 'total_score', 'lastBranch', 'score'], 'integer'],
            [['team_name'], 'string', 'max' => 1000],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team_id' => 'Team ID',
            'color_id' => 'Color ID',
            'team_name' => 'Team Name',
            'total_score' => 'Total Score',
        ];
    }

    /**
     * Gets query for [[Team]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

    /**
     * Gets query for [[Color]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id']);
    }
}
