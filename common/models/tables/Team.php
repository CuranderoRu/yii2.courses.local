<?php

namespace common\models\tables;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "tt_team".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $deletion_mark
 *
 * @property TeamAssignment[] $TeamAssignments
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tt_team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['deletion_mark'], 'integer'],
            [['name'], 'string', 'max' => 100],
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
            'description' => 'Description',
            'deletion_mark' => 'Deletion Mark',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamAssignments()
    {
        return $this->hasMany(TeamAssignment::class, ['team_id' => 'id']);
    }

    public static function getMyTeams()
    {

        $subQuery = Team::find()
            ->select('team_id as id')
            ->from('tt_team_assignment')
            ->where(['user_id'=>Yii::$app->user->id]);

        $query = Team::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        $query->andFilterWhere([
            'id' => $subQuery,
            'deletion_mark' => false,
        ]);


        return $dataProvider;
    }


    public static function getAvailableTeams()
    {

        $teams = Team::find()
            ->select(['id', 'name'])
            ->from('tt_team')
            ->where(['deletion_mark'=>false])
            ->all();

        return ArrayHelper::map($teams, 'id', 'name');


    }

    public static function getAvailableTeamMembers()
    {

        $query = new Query();

        $subQuery = (new Query())
            ->select('team_id')
            ->from('tt_team_assignment')
            ->where(['user_id'=>Yii::$app->user->id, 'isSupervisor'=>true])
            ->distinct()
            ;

        $rows = $query->select('u.id, u.username')
            ->from('tt_team_assignment ta')
            ->innerJoin('user u', 'u.id = ta.user_id')
            ->where(['team_id' => $subQuery])
            ->distinct()
            ->all();

        $arr = [];
        foreach ($rows as $row) {
            $arr[$row['id']] = $row['username'];
        }
        if (!array_key_exists(Yii::$app->user->id, $arr)){
            $arr[Yii::$app->user->id] = User::findOne(Yii::$app->user->id)->username;
        }
        return $arr;

    }


    public static function getSupervisor($subordinate_id)
    {
        $sb_assignment = TeamAssignment::find()
            ->where(['user_id' => $subordinate_id])
            ->one();
        $sw_assignment = TeamAssignment::find()
            ->where(['team_id' => $sb_assignment->team_id])
            ->andWhere(['isSupervisor' => true])
            ->one();

        return User::findOne($sw_assignment->user_id);
    }

}
