<?php

namespace app\commands;

use app\rules\LeaveOwnerCommentRule;
use yii\console\Controller;

class RbacController extends Controller
{
    private function getAuthManager()
    {
        return \Yii::$app->authManager;
    }

    public function actionInit()
    {
        $authManager = $this->getAuthManager();
        $authManager->removeAll();

        $admin = $authManager->createRole('admin');
        $user = $authManager->createRole('user');

        $authManager->add($admin);
        $authManager->add($user);

        $rule = new LeaveOwnerCommentRule();
        $authManager->add($rule);

        $leaveOwnComment = $authManager->createPermission('leaveOwnComment');
        $leaveOwnComment->description = 'Оставить комментарий';
        $leaveOwnComment->ruleName = $rule->name;
        $authManager->add($leaveOwnComment);

        $leave_comment_to_any_feedback = $authManager->createPermission('leave_comment_to_any_feedback');
        $leave_comment_to_any_feedback->description = 'Оставить комментарий к любому отзыву';
        $authManager->add($leave_comment_to_any_feedback);

        $authManager->addChild($user, $leaveOwnComment);
        $authManager->addChild($admin, $user);
        $authManager->addChild($admin, $leave_comment_to_any_feedback);

        $authManager->assign($admin, 1);
    }
}