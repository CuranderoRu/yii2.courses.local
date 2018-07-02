<?php

use yii\db\Migration;

/**
 * Class m180702_173853_add_fullname_column
 */
class m180702_173853_add_fullname_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'full_name', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180702_173853_add_fullname_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180702_173853_add_fullname_column cannot be reverted.\n";

        return false;
    }
    */
}
