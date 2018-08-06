<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 01.07.2018
 * Time: 16:59
 */

namespace console\controllers;


use yii\console\Controller;

class RbacController extends Controller
{
    public function actionRun()
    {
        $am = \Yii::$app->authManager;

        /*$admin = $am->createRole('admin');
        $supervisor = $am->createRole('supervisor');
        $user = $am->createRole('user');

        $am->add($admin);
        $am->add($supervisor);
        $am->add($user);

        $operationManageTasks = $am->createPermission('manageTasks');
        $operationManageUsers = $am->createPermission('manageUsers');

        $operationCreateTask = $am->createPermission('createTask');
        $operationUpdateTask = $am->createPermission('updateTask');
        $operationDeleteTask = $am->createPermission('deleteTask');


        $am->add($operationManageTasks);
        $am->add($operationManageUsers);

        $am->add($operationCreateTask);
        $am->add($operationUpdateTask);
        $am->add($operationDeleteTask);

        $am->addChild($admin, $operationManageTasks);
        $am->addChild($admin, $operationManageUsers);

        $am->addChild($supervisor, $operationCreateTask);
        $am->addChild($supervisor, $operationUpdateTask);
        $am->addChild($supervisor, $operationDeleteTask);

        $am->addChild($user, $operationCreateTask);
        $am->addChild($user, $operationUpdateTask);

        $am->assign($admin, 1);
        $am->assign($supervisor, 2);
        $am->assign($user, 3);*/

        $admin = $am->getRole('admin');
        $supervisor = $am->getRole('supervisor');
        $user = $am->getRole('user');

        $operationViewTeams = $am->createPermission('viewTeams');
        $am->add($operationViewTeams);
        $am->addChild($admin, $operationViewTeams);
        $am->addChild($supervisor, $operationViewTeams);
        $am->addChild($user, $operationViewTeams);



    }
}