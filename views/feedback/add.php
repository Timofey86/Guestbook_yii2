<?php


/* @var $this \yii\web\View */
/* @var Feedback $model */
/* @var Images $model_images */


use app\modules\admin\models\Feedback;
use app\modules\admin\models\Images;
use yii\widgets\Pjax;
use yii\bootstrap4\ActiveForm;

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
