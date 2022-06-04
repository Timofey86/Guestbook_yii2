<?php

use kartik\date\DatePicker;
use kartik\daterange\DateRangePicker;
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
    <!--    --><?php //print_r($dataProvider) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'message',
            'user.name',
//            [ //FIELDRANGE
//                'attribute' => 'date_add',
//                'format' => 'date',
//                'value' => 'date_add',
//                'filter' => FieldRange::widget([
//                        'label' => 'Введите даты',
//                    'model' => $searchModel,
//                    'type' => FieldRange::INPUT_WIDGET,
//                    'attribute1' => 'date_from',
//                    'attribute2' => 'date_to',
//                    'widgetClass' => DateControl::className(),
//                    'widgetOptions1' => [
//                        'saveFormat' => 'php:U',
//                    ],
//                    'widgetOptions2' => [
//                        'saveFormat' => 'php:U'
//                    ],
//                ])
//            ],
//            [
//                'attribute' => 'date_add',
//                'filter' => kartik\date\DatePicker::widget([
//                    'model' => $searchModel,
//                    'attribute' => 'date_from',
//                    'attribute2' => 'date_to',
//                    'type' => kartik\date\DatePicker::TYPE_RANGE,
//                    'separator' => '-',
//                    'pluginOptions' => [
//                        'todayHighlight' => true,
//                        'weekStart' => 1, //неделя начинается с понедельника
//                        'autoclose' => true,
//                        'format' => 'yyyy-mm-dd',
//                    ],
//                ]),
////                'format' => ['date', 'Y-MM-dd HH:mm:ss'],
//            ],


//            [
//                'attribute' => 'created_at', //value does not need to format time if the timestamp type is datetime
//                'filterType' => GridView::FILTER_DATE_RANGE,
//                'value' => function($model) {
//                    if ($model->created_at) {
//                        return date('Y-m-d H:i:s',$model->created_at);
//                    }
//                    return null;
//                },
//                'filterWidgetOptions' => [
//                    'startAttribute' => 'created_at_c', //Attribute of start time
//                    'endAttribute' => 'created_at_e',   //The attributes of the end time
//                    'convertFormat'=>true, // Importantly, true uses the local - > format time format to convert PHP time format to js time format.
//                    'pluginOptions' => [
//                        'format' => 'yyyy-mm-dd hh:ii:ss',//Date format
//                        'timePicker'=>true, //Display time
////                        'Time Picker Increment'=>5, //min interval
//                        'timePicker24Hour' => true, //24 hour system
//                        'locale'=>['format' => 'Y-m-d H:i:s'], //php formatting time
//                    ]
//                ],
//            ],


//            [
//                'attribute' => 'date_add',
//                'label' => 'Тут будет всякое',
//                'filterType' => \kartik\grid\GridView::FILTER_DATE_RANGE,
//                'filterWidgetOptions' => ([
//                    'attribute' => 'date_range',
//                    'presetDropdown' => true,
//                    'convertFormat' => false,
//                    'pluginOptions' => [
//                        'separator' => ' - ',
//                        'format' => 'YYYY-MM-DD',
//                        'locale' => [
//                            'format' => 'YYYY-MM-DD'
//                        ],
//                    ],
//                ]),
//            ],


//            [
//                'attribute' => 'date_add',
//                'format' => 'datetime',
//                'filter' => DatePicker::widget([
//                    'model' => $searchModel,
//                    'attribute' => 'date_from',
//                    'attribute2' => 'date_to',
//                    'options' => ['placeholder' => 'От'],
//                    'options2' => ['placeholder' => 'До'],
//                    'type' => DatePicker::TYPE_RANGE,
//                    'pluginOptions' => [
//                        'separator' => ' - '    ,
//                        'format' => 'yyyy-mm-dd',
//                        'autoclose' => true,
//                        'locale' => [
//                            'format' => 'YYYY-MM-DD'
//                        ],
//                    ]
//                ])
//            ],
//            [
//                'attribute' => 'date_add',
//                'format' => 'datetime',
//                'filterOptions' => [
//                    'class' => 'date-range-grid'
//                ],
//                'filter' => DateRangePicker::widget(
//                    [
//                        'model' => $searchModel,
//                        'attribute' => 'date_add',
//                        'convertFormat' => true,
//                        'presetDropdown' => true,
//                        'options' => [
//                            'class' => 'form-control',
//                        ],
//                        'pluginOptions' => [
//                            'format' => 'Y-m-d H:i:s',
//                            'dateLimit' => ['months' => 6],
//                            'opens' => 'left'
//                        ],
//                    ]
//                )
//            ],
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
//
//'filter' => DatePicker::widget([
//    'model' => $searchModel,
//    'attribute' => 'date_from',
//    'attribute2' => 'date_to',
//    'separator' => '-',
//    'type' => DatePicker::TYPE_RANGE,
//    'pluginOptions' => ['format' => 'yyyy-mm-dd']]),
////    'options' => ['autocomplete' => 'off'],
////    'options2' => ['autocomplete' => 'off'],
//
//'attribute' => 'date_add',
//               'format' => 'datetime',],

//            [
//                'filter' => DatePicker::widget([
//                    'model' => $searchModel,
//                    'attribute' => 'date_from',
//                    'attribute2' => 'date_to',
//                    'type' => DatePicker::TYPE_RANGE,
//                    'separator' => '-',
//                    'pluginOptions' => ['format' => 'yyyy-mm-dd']
//                ]),
//                'attribute' => 'created_at',
//                'format' => 'datetime',
//            ],

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
