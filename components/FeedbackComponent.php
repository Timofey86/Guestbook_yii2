<?php

namespace app\components;

use app\modules\admin\models\Feedback;
use yii\base\BaseObject;
use yii\web\UploadedFile;

class FeedbackComponent extends BaseObject
{

    public function getModel($data = [])
    {
        $model = new Feedback();
        if ($data) {
            $model->load($data);
        }
        return $model;
    }

    public function addFeedback(Feedback $model):bool
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
            $const = 'Images';
            $component->saveImages($model->image, $model->id, $const);
        }
        return true;
    }

    public function getFeedbacksAllAsModel($model, $count)
    {
        return $model::find()->with(['user', 'images', 'comments', 'imgforcomments'])
            ->limit(5 + $count)->Offset(0 + $count)->orderBy('id DESC')->all();
    }

    public function getFeedbacksAllAsArray($model, $count)
    {
        return $model::find()->with(['user', 'comments', 'images', 'imgforcomments'])
            ->limit(5 + $count)->Offset($count)->orderBy('id DESC')->asArray()->all();
    }
}