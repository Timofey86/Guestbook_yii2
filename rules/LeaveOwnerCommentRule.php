<?php

namespace app\rules;

use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\rbac\Rule;

class LeaveOwnerCommentRule extends Rule
{
    public $name = 'isAuthor';

    public function execute($user, $item, $params)
    {
        $model = ArrayHelper::getValue($params, 'model');
        return $model['user_id'] == $user;
    }
}