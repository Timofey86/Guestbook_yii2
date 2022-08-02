<?php

namespace app\components;

use app\modules\admin\models\Comments;
use yii\base\BaseObject;


class CommentComponent extends BaseObject
{

    public function getModel($data = [])
    {
        $model = new Comments();
        if ($data) {
            $model->load($data);
        }
        return $model;
    }

    public function getCommentsAll($model, $count, $feedback_id)
    {
        return $model::find()->andWhere(['feedback_id' => $feedback_id])->with(['user', 'imgforcomments'])
            ->limit(5 + $count)->Offset($count)->asArray()->orderBy('id ASC')->all();
    }
}