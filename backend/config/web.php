<?php

$db = require __DIR__ . '/db.php';

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'your-secret-key-change-in-production',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON,
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $response->headers->set('Access-Control-Allow-Origin', '*');
                $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
                $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
            },
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
];
