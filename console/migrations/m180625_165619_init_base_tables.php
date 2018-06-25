<?php

use yii\db\Migration;

/**
 * Class m180625_165619_init_base_tables
 */
class m180625_165619_init_base_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'name' => $this->string(250)->notNull(),
            'date' => $this->dateTime()->notNull(),
            'description' => $this->text(),
            'user_id' => $this->integer(),
            'deadline' => $this->dateTime(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),

        ]);

        $this->addForeignKey('fk_task_users', 'task', 'user_id', 'user', 'id');

        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'user_id' => $this->integer(),
            'body' => $this->text(),
            'image_name' => $this->string(250),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->addForeignKey('fk_comment_task', 'comments', 'task_id', 'task', 'id');
        $this->addForeignKey('fk_comment_user', 'comments', 'user_id', 'user', 'id');

        $this->addColumn('user', 'locale', 'VARCHAR(30)');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('task');
        $this->dropTable('comments');
        $this->dropColumn('user','locale');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180625_165619_init_base_tables cannot be reverted.\n";

        return false;
    }
    */
}
