<?php

namespace common\models\tables;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $responsible_id
 * @property string $deadline
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $responsible
 * @property Task[] $tasks
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['responsible_id'], 'integer'],
            [['deadline', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['responsible_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['responsible_id' => 'id']],
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
            'responsible_id' => 'Responsible ID',
            'deadline' => 'Deadline',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsible()
    {
        return $this->hasOne(User::className(), ['id' => 'responsible_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['project_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public static function getAvailableProjects()
    {

        $now = date('Y-m-d H:i:s');

        $query = new Query();
        $rows = $query->select('id, name')->from('project')
            //->where(['<=', 'deadline', $now])
            ->where('deadline>=:now', [':now' => $now])
            ->orWhere('deadline is null')
            ->all();

        $arr = [];
        foreach ($rows as $row) {
            $arr[$row['id']] = $row['name'];
        }
        return $arr;
    }


}
