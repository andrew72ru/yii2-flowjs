<?php

return [
    'id' => 'yii2-flowjs-tests',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'aliases' => [
        '@andrew72ru/flowjs' => dirname(dirname(dirname(__DIR__))),
        '@tests' => dirname(dirname(__DIR__)),
        '@vendor' => VENDOR_DIR,
        '@bower' => VENDOR_DIR . '/bower-asset'
    ],
    'bootstrap' => ['andrew72ru\flowjs\Bootstrap'],
    'modules' => [
        'flowjs' => [
            'class' => 'andrew72ru\flowjs\Module',
            'tempChunksDirectory' => '/tmp/flowjs'
        ]
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlite:' . __DIR__ . '/../../_data/temp.db'
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
    ],
    'params' => []
];