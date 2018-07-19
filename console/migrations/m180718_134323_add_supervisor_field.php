<?php

use yii\db\Migration;

/**
 * Class m180718_134323_add_supervisor_field
 */
class m180718_134323_add_supervisor_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tt_team_assignment', 'isSupervisor', 'boolean');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180718_134323_add_supervisor_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180718_134323_add_supervisor_field cannot be reverted.\n";

        return false;
    }
    */
}
