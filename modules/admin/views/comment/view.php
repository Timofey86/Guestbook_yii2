<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Comments */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'message',
                            'user.name',
                            ['attribute' => 'feedback',
                                'value' => function ($model) {
                                return $model->feedback->message;
                                }
                            ],
//                            'feedback.message',
                            [
                                'attribute' => 'images',
                                'value' => function ($model) {
                                    $images = '';
                                    foreach ($model->imgforcomments as $image) {
                                        $images .= Html::img('/images/' . $image->name, ['width' => 50, 'height' => 40]);
                                    }
                                    if (empty($images)) {
                                        return 'Изображения отсутствуют';
                                    }
                                    return $images;
                                },
                                'format' => 'raw'

                            ],
                            'date_add',
                            'updated_at',
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>