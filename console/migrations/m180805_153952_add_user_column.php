<?php

use yii\db\Migration;

/**
 * Class m180805_153952_add_user_column
 */
class m180805_153952_add_user_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tt_team_assignment', 'isUser', 'boolean');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tt_team_assignment', 'isUser');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180805_153952_add_user_column cannot be reverted.\n";

        return false;
    }
    */
}
