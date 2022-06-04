<?php

namespace app\modules\admin;

use Yii;
use yii\web\HttpException;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';
    public function beforeAction($action){

        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->authManager->checkAccess(\Yii::$app->user->id,'admin')){
            return true;
        } else {
            throw new HttpException(403, 'Может заходить только Администратор!');
//            Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
//            //для перестраховки вернем false
//            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
