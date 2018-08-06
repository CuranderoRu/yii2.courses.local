<?php

namespace common\models\tables;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "tt_team_assignment".
 *
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 * @property boolean $isSupervisor
 * @property boolean $isUser
 *
 * @property Team $team
 * @property User $user
 */
class TeamAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tt_team_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['team_id', 'user_id'], 'integer'],
            [['isSupervisor', 'isUser'], 'boolean'],

            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::class, 'targetAttribute' => ['team_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamName()
    {
        return $this->hasOne(Team::class, ['id' => 'team_id'])->all()[0]['name'];
    }

    public function getTeam()
    {
        return $this->hasOne(Team::class, ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getUserName()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->all()[0]['username'];
    }

    public static function getTeamMembers($team_id)
    {

        $query = TeamAssignment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->andFilterWhere([
            'team_id' => $team_id,
        ]);


        return $dataProvider;
    }


}
