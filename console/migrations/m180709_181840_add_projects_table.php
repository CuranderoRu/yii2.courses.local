<?php

use yii\db\Migration;

/**
 * Class m180709_181840_add_projects_table
 */
class m180709_181840_add_projects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'responsible_id' => $this->integer(),
            'deadline' => $this->date(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        $this->addForeignKey('fk_responsible', 'project', 'responsible_id', 'user', 'id');
        $this->addColumn('task', 'project_id', 'integer');
        $this->addForeignKey('fk_task_project', 'task', 'project_id', 'project', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('task','project_id');
        $this->dropTable('project');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180709_181840_add_projects_table cannot be reverted.\n";

        return false;
    }
    */
}
