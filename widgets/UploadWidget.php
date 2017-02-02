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
use yii\widgets\InputWidget;

class UploadWidget extends InputWidget
{
    public function init()
    {
        parent::init();

        $view = $this->getView();
        FlowJsAsset::register($view);

        /**
         * @todo get route from module
         */
        $uploadDestination = Url::toRoute(['/flowjs/upload']);

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
  console.log('not support');
  return false;
}

var drop = $('.flow-drop');
drop.collapse('show');
r.assignDrop(drop[0]);
r.assignBrowse($('.flow-browse-image')[0], false, false, {accept: 'image/*'});
r.on('fileAdded', function(file) {
  // console.log(file);
});

r.on('filesSubmitted', function(file) {
  r.upload();
});

r.on('fileSuccess', function(file, message) {
  console.log(file);
  console.log(message);
})
})();

JS;
        $view->registerJs($js, $view::POS_READY);

    }
}