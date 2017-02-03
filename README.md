# yii2-flowjs
Flowjs uploader for Yii2

> Development in progress, do not use it in production

[Readme in Russian (with a security question)](README-RU.md)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

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

`UploadImageWidget` do not create a file-input field, it is call [Flow](https://github.com/flowjs/flow.js) with `Module::defaultRoute` url, system `_csrf`, `callbackClass` and `callbackMethod` parameters. Flow send a post-requests for controller, controller save file and when file is saved, call the `[callbackClass, callbackMethod]` as callable function with server file path.
 
I have some doubts about this, but in my mind it work consistently and safely, because of private function in controller check `callbackClass` and `callbackMethod` params to:

* `callbackClass` exists,
* `callbackMethod` in this class exists too,
* `callbackMethod` is static, and
* `callbackClass` in namespace

If there conditions are not met, controller calls a default module method `defaultCallback`, it return a string with server file path.

If controller calls from web with post request and get a (for example) class name `\DateTime` and static method `createFromFormat` in this request, `\Datetime::createFromFormat` will not be called, because `\Datetime` class in root namespace. Anyway, some static methods of namespaced classes may be called, and this is a security risk, but I don't know, how to avoid it.

To avoid this threats, may pass to controller a path to store ready files, but this is not will work if wee need a resize image, rename file or store file in database, for example.

Well, I have no idea about this.

## Origin

* Yii – http://www.yiiframework.com
* FlowJs javascript part – https://github.com/flowjs/flow.js
* FlowJs php server part - https://github.com/flowjs/flow-php-server