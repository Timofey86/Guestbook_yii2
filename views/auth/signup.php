<?php


/* @var $this \yii\web\View */
/* @var $model \app\modules\admin\models\Users */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

?>

<div class="row">
    <div class="col-md-6">
        <?php $form = ActiveForm::begin([
            'method' => 'POST'
        ]); ?>
        <?= $form->field($model, 'name'); ?>
        <?= $form->field($model, 'email'); ?>
        <?= $form->field($model, 'password')->passwordInput(); ?>
        <?= $form->field($model, 'password_confirm')->passwordInput(); ?>

        <div class="form-group">
            <?= Html::submitButton('Регистрация', ['class' => 'btn-success']) ?>

            <?php ActiveForm::end(); ?>
            <br>
            <?= 'Уже есть аккаунт? ', Html::a('Авторизоваться', ['auth/sign-in']) ?>
        </div>
    </div>
