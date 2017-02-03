<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.02.17
 * Time: 17:47
 */

namespace andrew72ru\flowjs\widgets;


use andrew72ru\flowjs\assets\FlowJsAsset;
use andrew72ru\flowjs\Module;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

/**
 * Simple widget to upload one image file
 *
 * Class UploadImageWidget
 * @package andrew72ru\flowjs\widgets
 */
class UploadImageWidget extends InputWidget
{
    /** @var null|string|JsExpression $js Variable to set you own Javascript function */
    public $js = null;

    /** @var string $viewName */
    public $viewName = 'main';

    /** @var bool|string $preview Url to show in initial preview */
    public $preview = false;

    /** @var string $width preview width */
    public $width = '300px';

    /** @var string $height preview height */
    public $height = '300px';

    /** @var \andrew72ru\flowjs\Module $module */
    private $module;

    /**
     * @var null|string callback class for upload controller
     */
    public $callbackClass = null;

    /**
     * @var null|string $callbackMethod method of callback class
     */
    public $callbackMethod = null;

    /**
     * @var null|string String to show in upload field header
     */
    public $welcome = null;

    /**
     * @var null|string String to show in upload field footer
     */
    public $hint = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if($this->welcome === null)
            $this->welcome = Yii::t('flowjs', 'Drop files here or {select} files on You computer', [
                'select' => Html::tag('span', Yii::t('flowjs', 'select'), [
                    'class' => 'flow-browse-image',
                ])
            ]);

        if($this->hint === null)
            $this->hint = Yii::t('flowjs', 'File will send to server immediately');

        $this->module = Yii::$app->getModule('flowjs');
        if(!($this->module instanceof Module))
            throw new \BadMethodCallException();

        $view = $this->getView();
        FlowJsAsset::register($view);

        $uploadDestination = Url::toRoute($this->module->defaultRoute);
        $escapedClass = addslashes($this->callbackClass);

        $js = <<<JS
(function () {
var r = new Flow({
  target: '{$uploadDestination}',
  query: { 
    _csrf: $('meta[name="csrf-token"]').attr("content"),
    callback_class: '{$escapedClass}',
    callback_method: '{$this->callbackMethod}'
  },
  chunkSize: 1024 * 1024,
  testChunks: false
});

if (!r.support) {
  $('.flow-error').collapse('show');
  return false;
}

var drop = $('.flow-drop');
drop
  .collapse('show')
  .on('dragenter', function() {
    $(this).addClass('flow-dragover');
  })
  .on('dragend drop mouseover mouseout dragout', function() {
    $(this).removeClass('flow-dragover');
  });
r.assignDrop(drop[0]);
r.assignBrowse($('.flow-browse-image')[0], false, false, {accept: '.png,.jpg,.jpeg,.gif'});

r.on('fileAdded', function(file) {
  
  var reader = new FileReader();
  reader.onload = (function(theFile) {
    return function(e) {
      $('.flow-preview-frame').css({
        'background-image': 'url(' + e.target.result + ')'
      });
    }
  })(file.file);
  reader.readAsDataURL(file.file);
});

r.on('uploadStart', function() {
  $(".flow-progress").collapse('show');
});

r.on('fileProgress', function(file) {
  $(".flow-progress").find('.progress-bar')
    .text(Math.floor(file.progress()*100) + '%')
    .css({width: Math.floor(r.progress()*100) + '%'});
});

r.on('filesSubmitted', function(file) {
  r.upload();
});

r.on('fileSuccess', function(file, message) {
  $(".flow-progress").collapse('hide');
});

})();

JS;
        if($this->js === null)
            $this->js = $js;

        $view->registerJs($this->js, $view::POS_READY);

        $this->field->enableClientValidation = false;

    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render($this->viewName, [
            'preview' => $this->preview,
            'width' => $this->width,
            'height' => $this->height,
            'welcome' => $this->welcome,
            'hint' => $this->hint
        ]);
    }
}