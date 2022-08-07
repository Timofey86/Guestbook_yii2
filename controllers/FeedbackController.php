<?php

namespace app\controllers;


use app\components\FeedbackComponent;
use app\components\LikeComponent;
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

            $liked = [];
            $user_id = \Yii::$app->user->getId();
            $comp = new LikeComponent();

            foreach ($feedbackall as $key => $feedback) {
                $feedback_id = $feedback['id'];
                $isLiked = $comp->isLike($feedback_id, $user_id);
                $liked += [$feedback_id => $isLiked];

            }
            $lenght_feedbacks = count($model::find()->orderBy('id DESC')->asArray()->all());
            if ((count($feedbackall) % 5 == 0) && ((count($feedbackall) + $count)) == $lenght_feedbacks) {
                $data = [
                    'status' => true,
                    'feedback' => $feedbackall,
                    'message' => 'Feedback received',
                    'liked' => $liked,
                    'counts' => false,
                ];
                return Json::encode($data);

            } elseif (count($feedbackall) % 5 == 0) {
                $data = [
                    'status' => true,
                    'feedback' => $feedbackall,
                    'message' => 'Feedback received',
                    'liked' => $liked,
                    'counts' => true,
                ];
                return Json::encode($data);

            } else {
                $data = [
                    'status' => true,
                    'feedback' => $feedbackall,
                    'message' => 'Feedback received',
                    'liked' => $liked,
                    'counts' => false,
                ];
                return Json::encode($data);
            }
        }

        $count = 0;
        $const = 'Model';
        $feedbackall = $component->getFeedbacksAllAsModel($model, $count, $const);
        $lenght_feedbacks = count($component->getCountFeedbacksAll($model));

        if (count($feedbackall) == $lenght_feedbacks) {
            $lastFeedbacks = true;
        } else {
            $lastFeedbacks = false;
        }

        return $this->render('all', ['feedbackall' => $feedbackall, 'lastFeedbacks' => $lastFeedbacks]);
    }
}