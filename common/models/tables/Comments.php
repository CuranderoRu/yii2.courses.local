<?php

namespace common\models\tables;


/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property string $body
 * @property string $image_name
 * @property int $created_at
 *
 * @property Task $task
 * @property User $user
 */
class Comments extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id'], 'integer'],
            [['body'], 'string'],
            [['image_name'], 'string', 'max' => 250],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
            'body' => 'Body',
            'image_name' => 'Image Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function getByTask($taskId)
    {

            $val = static::find()
                ->where(['task_id' => $taskId])
                ->all();

            return $val;
    }

    public function fields()
    {
        return [
            'id',
            'task_id',
            'text' => 'body',
            /*'user' => function(){
                return $this->user;
            },*/

        ];
    }

    public function extraFields()
    {
        //http://yii2.courses.local/frontend/web/rests?expand=user
        return [
            'user',
            'timestamp' => function(){
                return new \DateTime();
            }
        ];
    }


}
