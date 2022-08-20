<?php

namespace app\components;

use app\modules\admin\models\Users;


class AuthComponent
{
    /**
     * @param $data
     * @return Users
     */

    public function getModel($data = [])
    {
        $model = new Users();
        if ($data) {
            $model->load($data);
        }
        return $model;
    }

    /**
     * @param $model Users
     * @return bool
     */
    public function authUser(&$model): bool
    {
        $model->setAuthScenario();
        if (!$model->validate(['email', 'password'])) {
            return false;
        }
        $password = $model->password;

        $model = $model::findOne(['email' => $model->email]);
        $model->auth_key = \Yii::$app->security->generateRandomString();
        $model->save(false);

        if (!\Yii::$app->security->validatePassword($password, $model->password_hash)) {
            $model->addError('password', 'Пароль не верный');
            return false;
        }
        if (!\Yii::$app->user->login($model, 3600)) {
            return false;
        }
        return true;
    }

    /**
     * @param $model Users
     * @return bool
     */
    public function createUser(&$model): bool
    {
        $model->setRegisterScenario();
        if (!$model->validate(['password', 'email'])) {
            return false;
        }

        $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password);
        if (!$model->save()) {
            return false;
        }
        $this->setUserRole($model);
        return true;
    }

    private function setUserRole($model)
    {
        $authManager = \Yii::$app->authManager;
        $userRole = $authManager->getRole('user');
        $authManager->assign($userRole, $model->getId());
    }
}