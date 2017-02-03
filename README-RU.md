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
        'tempChunksDirectory' => '@runtime/flow-chunks', // Optional. Path to temp directory
        'callback' => ['andrew72ru\flowjs\Module', 'defaultCallback'], // Optional. default callback for controller action upload
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

- `callbackClass` существует,
- `callbackMethod` существует в этом классе,
- `callbackMethod` – статический, и
- у `callbackClass` задано пространство имен.

Если что-то пошло не так, то вызывается встроенный колбэк, который возвращает строку пути к файлу.

Таким образом, передав в `post`, например, `\DateTime` и статический метод `createFromFormat`, не получится вызывать `\DateTime::createFromFormat`, поскольку класс `DateTime` в корневом пространстве имен.

Однако, вызвать класс с пространством имён и статическим методом всё-таки можно (если обойти проверку `csrf`), и функция класса будет вызвана с параметром из пути к файлу, но как избежать такой угрозы, я не знаю.  
Логичный шаг «передавать контроллеру путь для сохранения на сервере» не сработает, если после загрузки нужно, например, изменить размер картинки, или переименовать файл, или сохранить его в БД, а так же если с серверной стороны используется какая-нибудь абстракция над файловой системой (навроде `thephpleague/flysystem`).

Если вы сейчас это читаете и у вас есть ответ на вопрос «как безопасно вызвать колбэк из контроллера, предварительно его туда передав», то пишите в issues, я буду очень благодарен.

## TODO

- виджеты для загрузки множества файлов или каталога
- **(!!!)** надо определить в настройках приложения пространство имён, из которого можно запускать калбэки, и внутри контроллера проверять вызываемый класс на принадлежность к именно этому пространству имён.  
Притом проверять регулярным выраженим, то есть класс `\common\models\user\someone\Class` при заданном в настройках `\common` можно будет вызывать.

## Ссылки

* Yii – http://www.yiiframework.com
* FlowJs javascript часть – https://github.com/flowjs/flow.js
* FlowJs серверная часть (php) - https://github.com/flowjs/flow-php-server