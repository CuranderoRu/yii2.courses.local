<?php
namespace frontend\tests;

use common\models\tables\Task;
use common\models\tables\User;

class HighLevelTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    /**
     * @var User
     */
    protected $testUser;
    
    protected function _before()
    {
        $this->testUser = User::findOne(1);
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $this->assertEquals('admin', $this->testUser->username);

        $task = Task::findOne(1);
        $this->assertEquals($this->testUser->id, $task->user_id);

    }
}