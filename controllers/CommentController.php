<?php

namespace app\controllers;


use app\components\CommentComponent;
use app\components\FeedbackComponent;
use app\modules\admin\models\Feedback;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;

class CommentController extends Controller
{
    public function actionAdd($id)
    {
        $component = new CommentComponent();
        if (\Yii::$app->user->isGuest) {
            throw new HttpException(401, 'Требуется авторизация');
        }
        $feedback = Feedback::find()->andFilterWhere(['id' => $id])->asArray()->one();

        if (!\Yii::$app->rbac->canLeaveComment($feedback)) {
            throw new HttpException(403, 'Вы не можете оставлять комментарий к чужому отзыву!');
        }

        $model = $component->getModel();
        if (\Yii::$app->request->isPost) {
            $model = $component->getModel(\Yii::$app->request->post());
            $model->feedback_id = $id;
            $comp = new FeedbackComponent();
            $variable = 'Comment';

            if ($comp->addFeedback($model, $variable)) {
                return $this->redirect(Url::to(['/feedback/view', 'id' => $model->feedback_id]));
            }
        }
        return $this->render('add', ['model' => $model]);
    }

    public function actionAllcomments()
    {
        $component = new CommentComponent();
        $model = $component->getModel();

        if (\Yii::$app->request->isAjax) {
            $post = \Yii::$app->request->post();
            $count = ArrayHelper::getValue($post, 'count');

            $feedback_id = ArrayHelper::getValue($post, 'feedback_id');
            $allcomments = $component->getCommentsAll($model, $count, $feedback_id);

            if ((count($allcomments) % 5 == 0) && (count($allcomments) > 0)) {
                $data = [
                    'status' => false,
                    'comment' => null,
                    'message' => 'An error occurred',
                    'counts' => true,
                ];
                return Json::encode($data);

            } else {
                $data = [
                    'status' => true,
                    'comment' => $allcomments,
                    'message' => 'Comments received',
                    'counts' => false,
                ];
                return Json::encode($data);
            }
        }
    }
}