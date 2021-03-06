<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 02.07.2018
 * Time: 23:31
 */

namespace frontend\tests\_support;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;


    public function seeValidationError($message)
    {
        $this->see($message, '.help-block');
    }

    public function dontSeeValidationError($message)
    {
        $this->dontSee($message, '.help-block');
    }

}