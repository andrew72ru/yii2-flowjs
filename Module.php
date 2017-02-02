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

class Module extends \yii\base\Module
{
    /** @var string $controllerNamespace */
    public $controllerNamespace = 'andrew72ru\flowjs\controllers';

    /** @var string $tempChunksDirectory directory to store chunks */
    public $tempChunksDirectory = '@runtime/flow-chunks';

    public $urlPrefix = 'flowjs';

    public $urlRules = [
        'upload' => 'upload/upload'
    ];

    public function init()
    {
        parent::init();

        if(!is_dir(Yii::getAlias($this->tempChunksDirectory)))
            FileHelper::createDirectory(Yii::getAlias($this->tempChunksDirectory));
    }
}