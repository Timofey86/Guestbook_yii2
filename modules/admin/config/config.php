<?php
$params = require __DIR__ . '/params.php';
return [
    'components' => [
        'aliases'=>[
            ],
        'errorHandler' => [
            'errorAction' => 'site/error',
            ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/hail812/yii2-adminlte3/src/views'
                ],
            ],
        ],

    ],
    'params' => [
        $params
    ],
];