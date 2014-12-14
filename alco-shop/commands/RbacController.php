<?php
namespace app\commands;
 
use Yii;
use yii\console\Controller;
use app\rbac\UserGroupRule;
 
class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Create roles
        $guest  = $authManager->createRole('guest');
        $user  = $authManager->createRole('user');
        $admin  = $authManager->createRole('admin');
 
        // Add rule, based on UserExt->group === $user->group
        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);
 
        // Add rule "UserGroupRule" in roles
        $guest->ruleName  = $userGroupRule->name;
        $user->ruleName  = $userGroupRule->name;
        $admin->ruleName  = $userGroupRule->name;

        $authManager->addChild($user, $guest);
        $authManager->addChild($admin, $user);

        $authManager->add($user);
        $authManager->add($admin);
        $authManager->add($guest);       
    }
}