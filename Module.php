<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.02.17
 * Time: 16:51
 */

namespace andrew72ru\flowjs;


use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;

class Module extends \yii\base\Module
{
    /** @var string $controllerNamespace */
    public $controllerNamespace = 'andrew72ru\flowjs\controllers';

    /**
     * @var string $tempChunksDirectory directory to store chunks
     */
    public $tempChunksDirectory = '@runtime/flow-chunks';

    /**
     * @var string $urlPrefix prefix to Url Group rule.
     * @see \yii\web\GroupUrlRule
     */
    public $urlPrefix = 'flowjs';

    /**
     * @var array $urlRules Rules
     * @see \yii\web\UrlManager
     */
    public $urlRules = [
        'upload' => 'upload/upload'
    ];

    /**
     * @var string $defaultRoute
     */
    public $defaultRoute = '/flowjs/upload';

    /**
     * @var array|string $callback
     * Callback method for controller
     */
    public $callback = ['andrew72ru\flowjs\Module', 'defaultCallback'];

    public function init()
    {
        parent::init();

        if(!is_dir(Yii::getAlias($this->tempChunksDirectory)))
            FileHelper::createDirectory(Yii::getAlias($this->tempChunksDirectory));
    }

    /**
     * Default module callback
     * Fired from @see \andrew72ru\flowjs\controllers\UploadController, if $_POST have no parameters callback_class and callback_method
     * or it parameters is not a callable
     *
     * @param $file
     * @return string
     */
    public static function defaultCallback($file)
    {
        return Json::encode(Yii::t('flowjs', 'File successfully uploaded to {place}', [
            'place' => $file
        ]));
    }
}