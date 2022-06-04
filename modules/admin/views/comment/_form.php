<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Comments */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="comments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->dropdownList(\app\modules\admin\models\Users::getListName()) ?>

    <?= $form->field($model, 'feedback_id')->dropdownList(\app\modules\admin\models\Feedback::getListFeedback()) ?>

<!--    --><?//= $form->field($model, 'date_add')->textInput() ?>

<!--    --><?//= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
