<?php


use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;


/* @var $this \yii\web\View */
/* @var $model */

$this->title = 'Добавить комментарий';
?>
<div class="row">
    <div class="col-md-6">
        <?php Pjax::begin([
            'enablePushState' => false,
        ]); ?>
        <?php $form = ActiveForm::begin([
            'method' => 'POST'
        ]); ?>
        <?= $form->field($model, 'message')->textarea(); ?>
        <?= $form->field($model, 'image[]')->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>
        <div class="form-group">
            <button type="submit">Отправить</button>
        </div>
        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
