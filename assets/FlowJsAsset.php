<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.02.17
 * Time: 14:38
 */

namespace andrew72ru\flowjs\assets;


use yii\web\AssetBundle;
use yii\web\View;

class FlowJsAsset extends AssetBundle
{
    public $sourcePath = '@bower/flow.js/dist';

    public $js = ['flow.min.js'];

    public $jsOptions = [
        'position' => View::POS_HEAD
    ];

    public $depends = ['andrew72ru\user\helpers\FlowJsCssAsset'];
}