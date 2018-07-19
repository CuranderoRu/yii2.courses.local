<?php

namespace common\models\tables;
use yii\helpers\ArrayHelper;
use \yii\db\Query;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $name
 * @property string $date
 * @property string $description
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $deadline
 * @property int $supervisor_id
 * @property int $project_id
 * @property string $completion_date
 *
 * @property User $user
 */
class Task extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date', 'user_id'], 'required'],
            [['date', 'deadline', 'completion_date'], 'safe'],
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['supervisor_id'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['project_id'],  'safe'],
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
            'name' => 'Название',
            'date' => 'Дата создания',
            'deadline' => 'Срок исполнения',
            'description' => 'Описание',
            'user_id' => 'Исполнитель',
            'project_id' => 'Проект',
            'supervisor_id' => 'Супервайзер',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTaskResponsibleName()
    {
        return User::findOne($this->user_id)->full_name;
    }


    public static function getByDeadline($days)
    {

        $now = date('Y-m-d H:i:s');
        $stop_date = new \DateTime();
        $stop_date->add(new \DateInterval('P' . $days . 'D'));
        $stop_date = $stop_date->format('Y-m-d H:i:s');
        return static::find()
            ->where('deadline >= :now', [':now' => $now])
            ->andWhere('deadline <= :stop_date', [':stop_date' => $stop_date])
            ->all();
    }

    public static function getByCurrentMonth($userId)
    {

        return static::find()
                ->where(['user_id' => $userId])
                ->andWhere(['MONTH(date)' => date('n')])
                ->all();

    }

    public static function getByUserAndDate($userId, $date)
    {
        $timestamp = strtotime($date);
        return static::find()
            ->where(['user_id' => $userId])
            ->andWhere(['YEAR(date)' => date('Y', $timestamp)])
            ->andWhere(['MONTH(date)' => date('n', $timestamp)])
            ->andWhere(['DAY(date)' => date('j', $timestamp)])
            ->all();
    }

    public static function getAvailableProjects()
    {

        $subQuery = (new Query())->from('project');
        $query = new Query();
        $query->select(['p.id', 'p.name'])
            ->distinct()
            ->from(['t' => 'task'])
            ->innerJoin(['p' => $subQuery], 'p.id = t.project_id')
            ->where(['t.user_id' => \Yii::$app->user->id]);

        return ArrayHelper::toArray($query->all());
    }

    public function StoreAccessedTask()
    {
        // Пробуем извлечь $data из кэша.
        $cache = \Yii::$app->cacheTask;
        $key = \Yii::$app->user->id;
        $data = $cache->get($key);

        if ($data === false) {
            $data = array();
        }
        $data[$this->id] = $this->name;
        if (count($data)>5){
            array_shift($data);
        }
        $cache->set($key, $data);
    }

    public static function GetAccessedTasks()
    {
        $data = \Yii::$app->cacheTask->get(\Yii::$app->user->id);
        if ($data === false) {
            return [];
        }else{
            return $data;
        }

    }


}
