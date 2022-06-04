<?php

namespace app\components;

use yii\base\BaseObject;


class RbacComponent extends BaseObject
{
    public function canLeaveComment($model): bool
    {
        if (\Yii::$app->user->can('leave_comment_to_any_feedback')) {
            return true;
        }
        if (\Yii::$app->user->can('leaveOwnComment', ['model' => $model])) {
            return true;
        }
        return false;
    }
}