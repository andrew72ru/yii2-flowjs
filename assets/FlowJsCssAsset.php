<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.02.17
 * Time: 15:00
 */

namespace andrew72ru\flowjs\assets;

use yii\web\AssetBundle;

class FlowJsCssAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/css';

    public $css = ['flow.css'];
}