<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Users */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(); ?>

    <?= $form->field($model, 'password_confirm')->passwordInput(); ?>

<!--    --><?//= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'date_add')->textInput() ?>

<!--    --><?//= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
