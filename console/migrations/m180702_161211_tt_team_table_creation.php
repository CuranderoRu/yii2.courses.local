<?php

use yii\db\Migration;

/**
 * Class m180702_161211_tt_team_table_creation
 */
class m180702_161211_tt_team_table_creation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tt_team', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'description' => $this->text(),
            'deletion_mark' => $this->boolean()->notNull()->defaultValue(false),
        ]);

        $this->createTable('tt_team_assignment', [
            'id' => $this->primaryKey(),
            'team_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk_team_a_user', 'tt_team_assignment', 'user_id', 'user', 'id');
        $this->addForeignKey('fk_team_a_team', 'tt_team_assignment', 'team_id', 'tt_team', 'id');

        $this->addColumn('task', 'supervisor_id', 'integer');
        $this->addColumn('task', 'completion_date', 'datetime');
        $this->addForeignKey('fk_task_supervisor', 'task', 'supervisor_id', 'user', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180702_161211_tt_team_table_creation cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180702_161211_tt_team_table_creation cannot be reverted.\n";

        return false;
    }
    */
}
