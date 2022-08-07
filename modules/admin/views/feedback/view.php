<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Feedback */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Feedbacks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="feedback-view">

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->

    <p>
        <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'feedback',
            'user.name',
            'user.email',
            [
                'attribute' => 'images',
                'value' => function ($model) {
                    $images = '';
                    foreach ($model->images as $image) {
                        $images .= Html::img('/images/' . $image->name, ['width' => 70, 'height' => 50]);
                    }
                    if (empty($images)) {
                        return 'Изображения отсутствуют';
                    }
                    return $images;
                },
                'format' => 'raw'

            ],
//            'commentsAsString',
//            [
//                'attribute' => 'Comments',
//                'value ' => 'commentsAsString'
//            ],
            'date_add',
            'updated_at',


        ],
    ]) ?>
</div>
