<?php

use kartik\date\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\datecontrol\DateControl;
use kartik\field\FieldRange;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'Feedbacks');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="feedback-index">

    <!--    <h1>--><? //= Html::encode($this->title) ?><!--</h1>-->

    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'message',
            'user.name',
            [//работает с датой пхп а не интеджер
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_from',
                    'attribute2' => 'date_to',
                    'options' => ['placeholder' => 'От'],
                    'options2' => ['placeholder' => 'До'],
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '-',
                    'pluginOptions' => ['format' => 'yyyy-mm-dd',
                        'locale'=>['format' => 'Y-m-d H:i:s'],
                        'autoclose' => true,
                        'todayHighlight' => true,
                        'weekStart' => 1, //неделя начинается с понедельника
                    ]
                ]),
                'attribute' => 'date_add',
                'format' => ['date', 'Y-MM-dd HH:mm:ss']
            ],

//            'date_add',
            [
                'attribute' => 'images',
                'value' => function ($model) {
                    $images = '';
                    foreach ($model->images as $image) {
                        $images .= Html::img('/images/' . $image->name, ['width' => 50, 'height' => 40]);
                    }
                    if (empty($images)) {
                        return 'Изображения отсутствуют';
                    }
                    return $images;
                },
                'format' => 'raw'

            ],
            [
                'class' => ActionColumn::className(),
//                'urlCreator' => function ($action, Feedback $model, $key, $index, $column) {
//                    return Url::toRoute([$action, 'id' => $model->id]);
//                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
