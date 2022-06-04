<?php

namespace app\components;

use app\modules\admin\models\Comments;
use yii\base\BaseObject;
use yii\web\UploadedFile;

class CommentComponent extends BaseObject
{

    public function getModel($data = [])
    {
        /** @var Comments $model */
        $model = new Comments();
        if ($data) {
            $model->load($data);
        }
        return $model;
    }

    public function addComment(Comments $model)
    {
        $model->user_id = \Yii::$app->user->identity->getId();

        if (!$model->validate()) {
            return false;
        }

        if (!$model->save()) {
            return false;
        }
        $model->image = UploadedFile::getInstances($model, 'image');
        $component = \Yii::createObject(['class' => ImageLoaderComponent::class]);
        if ($component->loadImages($model)) {
            $const = 'IMG';
            $component->saveImages($model->image, $model->id, $const);
        }
        return true;
    }

    public function getCommentsAll($model, $count, $feedback_id)
    {
        return $model::find()->andWhere(['feedback_id' => $feedback_id])->with(['user', 'imgforcomments'])
            ->limit(5 + $count)->Offset($count)->asArray()->orderBy('id ASC')->all();
    }
}