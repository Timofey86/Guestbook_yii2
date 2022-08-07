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

    public function addFeedback($model, $variable): bool
    {
        $model->user_id = \Yii::$app->user->identity->getId();
        if ($variable === 'Feedback') {

            if ($model->validate()) {
                $model->save();
            }

            $model->image = UploadedFile::getInstances($model, 'image');
            $component = \Yii::createObject(['class' => ImageLoaderComponent::class]);
            if ($component->loadImages($model)) {
                $const = 'Images';
                $component->saveImages($model->image, $model->id, $const);
            }

        } elseif ($variable === 'Comment') {
            if ($model->validate()) {
                $model->save();
            }

            $model->image = UploadedFile::getInstances($model, 'image');
            $component = \Yii::createObject(['class' => ImageLoaderComponent::class]);
            if ($component->loadImages($model)) {
                $const = 'IMG';
                $component->saveImages($model->image, $model->id, $const);
            }
        }
        return true;
    }

    public function getFeedbacksAllAsModel($model, $count, $const)
    {
        if ($const === 'Model') {
            return $model::find()->with(['user', 'images', 'comments', 'imgforcomments'])
                ->limit(5 + $count)->Offset(0 + $count)->orderBy('id DESC')->all();
        } elseif ($const === 'Array') {
            return $model::find()->with(['user', 'comments', 'images', 'imgforcomments'])
                ->limit(5)->Offset($count)->orderBy('id DESC')->asArray()->all();
        }
    }

    public function getCountFeedbacksAll($model)
    {
        return $model::find()->orderBy('id DESC')->asArray()->all();
    }

}