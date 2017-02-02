# yii2-flowjs
Flowjs uploader for Yii2

# ALFA VERSION!

Please, do not use it, development in progress!

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist andrew72ru/yii2-flowjs "dev-master"
```

or add

```
"andrew72ru/yii2-flowjs": "*"
```

to the require section of your `composer.json` file.

## Setup

Set up you application modules:

```php
'modules' => [
    …
    'flowjs' => [
        'class' => 'andrew72ru\flowjs\Module',
        'tempChunksDirectory' => '@runtime/flow-chunks', // Optional. Path to temp directory
    ]
]
```

## Origin

* Yii – http://www.yiiframework.com
* FlowJs javascript part – https://github.com/flowjs/flow.js
* FlowJs php server part - https://github.com/flowjs/flow-php-server