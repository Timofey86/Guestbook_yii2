<?php

namespace app\controllers;

use app\components\AuthComponent;
use yii\web\Controller;

class AuthController extends Controller
{
    public function actionSignUp()
    {
        $component = new AuthComponent();
        $model = $component->getModel();

        if (\Yii::$app->request->isPost) {
            $model = $component->getModel(\Yii::$app->request->post());

            if ($component->createUser($model)) {
                return $this->redirect(['/auth/sign-in']);
            }
        }
        return $this->render('signup', ['model' => $model]);
    }

    public function actionSignIn()
    {
        $component = new AuthComponent();
        $model = $component->getModel();

        if (\Yii::$app->request->isPost) {
            $model = $component->getModel(\Yii::$app->request->post());

            if ($component->authUser($model)) {
                $this->redirect(['feedback/all']);
            }
        }
        return $this->render('signin', ['model' => $model]);
    }
}