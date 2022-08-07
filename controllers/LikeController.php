<?php

namespace app\controllers;

use app\components\LikeComponent;
use app\modules\admin\models\Feedback;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;


class LikeController extends Controller
{
    public function actionAdd()
    {
        if (\Yii::$app->user->isGuest) {
            $this->redirect(['auth/sign-in']);

        } else {

            $comp = new LikeComponent();

            if (\Yii::$app->request->isAjax) {

                $post = \Yii::$app->request->post();
                $feedback_id = ArrayHelper::getValue($post, 'feedback_id');
                $user_id = \Yii::$app->user->getId();

                $islike = $comp->addLike($feedback_id, $user_id);
                $count = Feedback::find()->andWhere(['id' => $feedback_id])->one();
                $result = [
                    'status' => true,
                    'model' => $count,
                    'like' => $islike
                ];
                return Json::encode($result);
            }
        }
    }

    public function actionCheck()
    {
        $comp = new LikeComponent();
        if (\Yii::$app->request->isAjax) {

            $post = \Yii::$app->request->post();
            $feedback_id = ArrayHelper::getValue($post, 'feedback_id');
            $user_id = \Yii::$app->user->getId();
            $isLike = $comp->isLike($feedback_id, $user_id);

            $data = [
                'status' => true,
                'liked' => $isLike
            ];
            return Json::encode($data);
        }
    }
}