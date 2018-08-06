<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property int $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id']],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }

    public function assignRole($user_id, $role_name)
    {
        $am = \Yii::$app->authManager;
        $role = $am->getRole($role_name);
        if (is_null($role)){
            return false;
        }
        $am->revokeAll($user_id);
        $am->assign($role, $user_id);
        return true;
    }

    public static function escalateRole($user_id, $role_name)
    {

        $roles_order = [
            'admin' => 0,
            'supervisor' => 1,
            'user' => 2,
            'guest' => 99,
        ];
        $requested_order = (is_null($roles_order[$role_name])) ? 1000 : $roles_order[$role_name];


        $am = \Yii::$app->authManager;
        $roles = $am->getRolesByUser($user_id);
        $current_order = (is_null($roles_order[$roles["user"]->name])) ? 1000 : $roles_order[$roles["user"]->name];
        if ($current_order>$requested_order){
            $role = $am->getRole($role_name);
            if (is_null($role)){
                return false;
            }
            $am->revokeAll($user_id);
            $am->assign($role, $user_id);
        }
        return true;
    }


}
