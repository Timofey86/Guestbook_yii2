<?php

namespace app\components;

use app\modules\admin\models\Feedback;
use app\modules\admin\models\Like;


class LikeComponent
{
    public function getModel($data = [])
    {
        $model = new Like();
        if ($data) {
            $model->load($data);
        }
        return $model;
    }

    public function isLike($feedback_id, $user_id)
    {
        $isLike = Like::find()->andWhere(['user_id' => $user_id, 'feedback_id' => $feedback_id])->one();
        if ($isLike == !null) {
            return true;
        } else {
            return false;
        }
    }

    public function addLike($feedback_id, $user_id)
    {
        $model = Like::find()->andWhere(['user_id' => $user_id, 'feedback_id' => $feedback_id])->one();
        $feedback_model = Feedback::find()->andWhere(['id' => $feedback_id])->one();

        if (!$model) {
            $model = new Like();
            $model->user_id = $user_id;
            $model->feedback_id = $feedback_id;
            $model->save();
            $feedback_model->count += 1;
            $feedback_model->save();
            return true;

        } else {
            $feedback_model->count -= 1;
            $feedback_model->save();
            $model->delete();
            return false;
        }

    }

}