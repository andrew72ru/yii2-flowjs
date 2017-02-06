<?php

return [
    'id' => 'yii2-flowjs-tests',
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
            'dsn' => 'sqlite:' . \Yii::getAlias('@common/tests/_data/temp.db')
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