<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "tt_team".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $deletion_mark
 *
 * @property TtTeamAssignment[] $ttTeamAssignments
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
    public function getTtTeamAssignments()
    {
        return $this->hasMany(TtTeamAssignment::className(), ['team_id' => 'id']);
    }
}