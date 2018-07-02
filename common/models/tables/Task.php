<?php

namespace common\models\tables;

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

}