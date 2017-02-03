<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.02.17
 * Time: 17:47
 */

namespace andrew72ru\flowjs\widgets;


use andrew72ru\flowjs\assets\FlowJsAsset;
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
    public $height = 'auto';

    /** @var \andrew72ru\flowjs\Module $module */
    private $module;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->module = \Yii::$app->getModule('flowjs');

        $view = $this->getView();
        FlowJsAsset::register($view);

        $uploadDestination = Url::toRoute($this->module->defaultRoute);

        $js = <<<JS
(function () {
var r = new Flow({
  target: '{$uploadDestination}',
  query: { 
    _csrf: $('meta[name="csrf-token"]').attr("content") 
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
r.assignBrowse($('.flow-browse-image')[0], false, false, {accept: 'image/*'});

r.on('fileAdded', function(file) {
  
  var reader = new FileReader();
  reader.onload = (function(theFile) {
    return function(e) {
      var imageContainer = $('.flow-preview');
      var preview = new Image();
      preview.src = e.target.result;
      preview.style.width = '{$this->width}';
      preview.style.height = '{$this->height}';
      imageContainer.html(preview);
    }
  })(file.file);
  reader.readAsDataURL(file.file);
});

r.on('filesSubmitted', function(file) {
  r.upload();
});

r.on('fileSuccess', function(file, message) {
  console.log(file);
  console.log(message);
});

})();

JS;
        if($this->js === null)
            $this->js = $js;

        $view->registerJs($this->js, $view::POS_READY);

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
        ]);
    }
}