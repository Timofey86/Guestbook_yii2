<?php

namespace app\modules\admin\controllers;


use app\components\ImageLoaderComponent;
use app\modules\admin\models\Comments;
use app\modules\admin\models\Feedback;
use app\modules\admin\models\Imgforcomments;
use app\modules\admin\models\search\FeedbackSearch;
use app\modules\admin\models\Images;
use yii\filters\AccessControl;
use yii\helpers\BaseFileHelper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FeedbackController implements the CRUD actions for Feedback model.
 */
class FeedbackController extends Controller
{

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Feedback models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FeedbackSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Feedback model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Feedback model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Feedback();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $model->image = UploadedFile::getInstances($model, 'image');
                $component = \Yii::createObject(['class' => ImageLoaderComponent::class]);
                if ($component->loadImages($model)) {
                    $const = 'Images';
                    $component->saveImages($model->image, $model->id, $const);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Feedback model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Feedback model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $comments = Comments::find()->andWhere(['feedback_id' => $id])->all();
        foreach ($comments as $comment) {
            $img = $comment->imgforcomments;
            foreach ($img as $one) {
                $dir = \Yii::getAlias('@webroot/images/');
                unlink($dir . $one->name);
            }
        }

        $images = Images::find()->andWhere(['feedback_id' => $id])->all();
        foreach ($images as $image) {
            $dir = \Yii::getAlias('@webroot/images/');
            unlink($dir . $image->name);
        }

        $trans = $this->getDb()->beginTransaction();
        try {
            Comments::deleteAll(['feedback_id' => $id]);
            Images::deleteAll(['feedback_id' => $id]);
            $this->findModel($id)->delete();
            $trans->commit();

        } catch (\Exception $e) {
            $trans->rollBack();
        }

        return $this->redirect(['index']);
    }


    /**
     * Finds the Feedback model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Feedback|array|\yii\db\ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feedback::find()->with(['images', 'user', 'comments'])
                ->andWhere(['id' => $id,])->one()) !== null) {

            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    public function getDb()
    {
        return \Yii::$app->db;
    }
}
