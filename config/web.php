<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

return [
    'id' => 'sidang-uaj',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],

    // Tambahkan konfigurasi ini
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],

    'defaultRoute' => 'site/index',

    'components' => [
        'request' => [
            'cookieValidationKey' => 'GANTI-DENGAN-KUNCI-RAHASIA-ANDA'
        ],

        'cache' => [
            'class' => 'yii\\caching\\FileCache'
        ],

        'user' => [
            'identityClass' => 'yii\\web\\User',
            'enableAutoLogin' => false
        ],

        'errorHandler' => [
            'errorAction' => 'site/error'
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false
        ],

        'db' => $db,

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\\log\\FileTarget',
                    'levels' => ['error', 'warning']
                ]
            ]
        ],
    ],

    'params' => $params,
];