<?php

namespace app\controllers;


use app\components\FeedbackComponent;
use app\modules\admin\models\Comments;
use app\modules\admin\models\Feedback;
use app\modules\admin\models\Like;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;


class FeedbackController extends Controller
{

    public function actionAdd()
    {
        $component = new FeedbackComponent();
        if (\Yii::$app->user->isGuest) {
            throw new HttpException('Требуется авторизация');
        }
        $model = $component->getModel();

        if (\Yii::$app->request->isPost) {
            $model = $component->getModel(\Yii::$app->request->post());
            $variable = 'Feedback';
            if ($component->addFeedback($model, $variable)) {
                return $this->redirect(Url::to(['feedback/all']));
            }
        }
        return $this->render('add', ['model' => $model]);
    }

    /**
     * @var ActiveRecord $model
     */
    public function actionView($id)
    {
        $model = Feedback::find()->andWhere(['id' => $id])->with('images', 'user')->asArray()->one();
        $model['comments'] = Comments::find()->andWhere(['feedback_id' => $id])->with('user', 'imgforcomments')->limit(5)->asArray()->all();

        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $this->render('view', ['model' => $model]);
    }

    public function actionAll()
    {
        $component = new FeedbackComponent();
        $model = $component->getModel();

        if (\Yii::$app->request->isAjax) {
            $count = \Yii::$app->request->post();
            $count = ArrayHelper::getValue($count, 'count');
            $const = 'Array';

            $feedbackall = $component->getFeedbacksAllAsModel($model, $count, $const);
            if ((count($feedbackall) % 5 == 0) && (count($feedbackall) > 0)) {
                $data = [
                    'status' => true,
                    'feedback' => $feedbackall,
                    'message' => 'Feedback received',
                    'counts' => true,
                ];
                return Json::encode($data);
            } else {
                $data = [
                    'status' => true,
                    'feedback' => $feedbackall,
                    'message' => 'Feedback received',
                    'counts' => false,
                ];
                return Json::encode($data);
            }
        }

        $count = 0;
        $const = 'Model';
        $feedbackall = $component->getFeedbacksAllAsModel($model, $count, $const);
        $isLike = Like::find()->andWhere(['user_id' => $user_id, 'feedback_id' => $feedback_id])->one();
        $x = 0;
        return $this->render('all', ['feedbackall' => $feedbackall,'isLike' => $isLike] );
    }

//    public function isLike($user_id, $feedback_id){
//        $isLike = Like::find()->andWhere(['user_id' => $user_id, 'feedback_id' => $feedback_id])->one();
//        return $isLike;
//
//    }
}