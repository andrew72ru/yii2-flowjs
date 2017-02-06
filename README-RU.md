# yii2-flowjs

[FlowJs](https://github.com/flowjs)-аплоадер для Yii2

> Внимание! Модуль в процессе разработки, не рекомендую использовать его в действующих приложениях!

## Установка

Устанавливайте с помощью [composer](http://getcomposer.org/download/)

В консоли

```
php composer.phar require --prefer-dist andrew72ru/yii2-flowjs 
```

или добавьте `"andrew72ru/yii2-flowjs": "*"` в `composer.json`

## Настройка приложения

В секции `modules` приложения:

```php
'modules' => [
    …
    'flowjs' => [
        'class' => 'andrew72ru\flowjs\Module',
        'tempChunksDirectory' => '@runtime/flow-chunks', // Необязательно. Путь к директории с временными файлами, для кранения переданных кусочков
        'allowedNamespaces' => ['common', 'frontend'], // Допустимые namespace-ы для класса, который содержит callback
        'callback' => ['andrew72ru\flowjs\Module', 'defaultCallback'], // Необязательно. Callback-метод, выполняемый по-умолчанию
    ]
]
```

## Использование

Пока существует только один (базовый) виджет для подключения в форму – `\andrew72ru\flowjs\widgets\UploadImageWidget`.

#### Вызов в ActiveForm:

```php
<?= $form->field($model, 'fileAttribute')->widget(\andrew72ru\flowjs\widgets\UploadImageWidget::className(), [
    'preview' => 'path/to/preview/file.jpg',
    'callbackClass' => '\class\with\namespase\Class',
    'callbackMethod' => 'callbackMethodName'
])?>
```

#### Как это работает

`UploadImageWidget` не создает поля для ввода файла напрямую, он вызывает [Flow](https://github.com/flowjs/flow.js) с `Module::defaultRoute` в качестве `url` для загрузки файлов, системный `_csrf` и параметрами `callbackClass` и `callbackMethod`. Flow отправляет в адрес контроллера `post`-запрос с частями файла и `callbackClass` + `callbackMethod` для вызова калбэка после успешной загрузки. Калбэк получает путь к файлу на сервере.

Есть некоторые сомнения в безопасности работы модуля, потому что теоретически можно отправить `post` вручную и передать в `callbackClass` и `callbackMethod` любой вызов. Однако, функция контроллера проверяет, что:

Прежде чем вызвать калбэк-функцию, контроллер проверяет:

- `callbackClass` существует,
- `callbackMethod` существует в этом классе,
- `callbackMethod` – статический, и
- пространство имен `callbackClass` содержится в разрешенных (`allowedNamespaces`) нэймспэйсах.  
Например, `common\models\MyModel::myUpload` при конфигурации модуля `allowedNamespaces => ['common']` сработает, а `frontend\models\SomeClass::someMethod` – нет.

Если что-то пошло не так, то вызывается встроенный колбэк, который возвращает строку пути к файлу.

## TODO

- виджеты для загрузки множества файлов или каталога

## Ссылки

* Yii – http://www.yiiframework.com
* FlowJs javascript часть – https://github.com/flowjs/flow.js
* FlowJs серверная часть (php) - https://github.com/flowjs/flow-php-server
