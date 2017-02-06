# yii2-flowjs
Flowjs uploader for Yii2

> Development in progress, do not use it in production

[Readme in Russian (with a security question)](README-RU.md)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Add this repository to you `composer.json`:

```json
…
"repositories": [
  …
  {
    "type": "vcs",
    "url": "https://github.com/andrew72ru/yii2-flowjs"
  }
],
…
```

and run

```
php composer.phar require --prefer-dist andrew72ru/yii2-flowjs 
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
        'allowedNamespaces' => ['common', 'frontend'], // Allowed namespace of class with callback method. Default is andrew72ru\\
        'callback' => ['andrew72ru\flowjs\Module', 'defaultCallback'], // Optional. default callback for controller action upload
    ]
]
```

## Usage

Basic widget for upload one image file in `\andrew72ru\flowjs\widgets\UploadImageWidget`.

#### Example call in ActiveForm:

```php
<?= $form->field($model, 'fileAttribute')->widget(\andrew72ru\flowjs\widgets\UploadImageWidget::className(), [
    'preview' => 'path/to/preview/file.jpg',
    'callbackClass' => '\class\with\namespase\Class',
    'callbackMethod' => 'callbackMethodName'
])?>
```

#### How it works

`UploadImageWidget` do not create a file-input field, it is call [Flow](https://github.com/flowjs/flow.js) with `Module::defaultRoute` url, system `_csrf`, `callbackClass` and `callbackMethod` parameters. Flow send a post-requests for controller, controller saves the file and when file is saved, call the `[callbackClass, callbackMethod]` as callable function with server file path.
 
The upload controller checks the `callbackClass` and `callbackMethod` params to:

* `callbackClass` exists,
* `callbackMethod` in this class exists too,
* `callbackMethod` is static, and
* `callbackClass` in namespace listed in `allowedNamespaces` array of module configuration.  
For example, `common\models\MyModel::myUpload` method will work with configuration parameter `allowedNamespaces => ['common']`, but `frontend\models\SomeClass::someMethod` will not.

If there conditions are not met, controller calls a default module method `defaultCallback`.

## TODO

- create widgets for upload many files / directory
- Acceptance / functional tests with JS support

## Origin

* Yii – http://www.yiiframework.com
* FlowJs javascript part – https://github.com/flowjs/flow.js
* FlowJs php server part - https://github.com/flowjs/flow-php-server
