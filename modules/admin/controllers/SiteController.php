<?php

namespace app\modules\admin\controllers;

use app\models\LoginForm;
use app\modules\admin\models\Users;
use yii\web\Controller;
use Yii;

class SiteController extends Controller

{
    public function actionIndex()
    {
        return $this->render('index');

    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Users();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }


}