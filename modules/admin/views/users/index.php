<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?= Html::a(Yii::t('app', 'Create Users'), ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>


                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'name',
                            'email:email',
                            [//работает с датой пхп а не интеджер
                                'filter' => DatePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'date_from',
                                    'attribute2' => 'date_to',
                                    'options' => ['placeholder' => 'От',
                                        'class' => 'form-control',
                                        'autocomplete' => 'off'],
                                    'options2' => ['placeholder' => 'До',
                                        'class' => 'form-control',
                                        'autocomplete' => 'off'],
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
                           // 'password_hash',
                            //'token',
                            //'auth_key',
                            //'date_add',
                            //'updated_at',

                            ['class' => 'hail812\adminlte3\yii\grid\ActionColumn'],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ]
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>
