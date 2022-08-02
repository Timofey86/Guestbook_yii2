<?php


/* @var $this \yii\web\View */

/* @var $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
$this->title = 'Авторизация';
?>

<div class="row">
    <div class="col-md-6">
        <?php $form = ActiveForm::begin([
            'method' => 'POST'
        ]); ?>
        <?= $form->field($model, 'email'); ?>
        <?= $form->field($model, 'password')->passwordInput(); ?>

        <div class="form-group">
            <?= Html::submitButton('Авторизация', ['class' => 'btn-success']) ?>

            <?php ActiveForm::end(); ?>
            <br>
            <div>
                <?= 'Хотите зарегистрироваться? ', Html::a('Регистрация', ['auth/sign-up']) ?>
            </div>
            <br>
            <p><b>admin1@mail.ru / 123man</b></p>
        </div>
    </div>