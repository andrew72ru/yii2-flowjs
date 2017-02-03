<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.02.17
 * Time: 17:51
 *
 * @var \yii\web\View $this
 * @var string|null $preview
 * @var string $width
 * @var string $height
 * @var string $welcome
 * @var string|null $hint
 */
use yii\helpers\Html;

?>

<div class="panel panel-default collapse flow-drop">
    <div class="panel-body">
        <?= $welcome?>
    </div>
    <div class="panel-body flow-error collapse">
        <?= Yii::t('flowjs', 'Your browser, unfortunately, not support the HTML5 File API.')?>
    </div>
    <div class="panel-body collapse flow-preview <?= $preview ? 'in' : ''?>">
        <?= Html::tag('div', '', [
            'class' => 'flow-preview-frame',
            'style' => [
                'width' => $width,
                'height' => $height,
                'background-color' => '#ccc',
                'background-image' => ($preview ? 'url(' . $preview . ')' : 'none'),
                'background-position' => 'center center',
                'background-size' => 'cover'
            ]
        ])?>
    </div>
    <div class="panel-body collapse flow-progress">
        <div class="progress">
            <?= Html::tag('div', '', [
                'class' => 'progress-bar progress-bar-striped',
                'role' => 'progressbar',
                'aria-valuenow' => 0,
                'aria-valuemin' => 0,
                'aria-valuemax' => 100,
                'style' => ['width' => 0]
            ])?>
        </div>
    </div>
    <div class="panel-body collapse <?= $hint ? 'in' : ''?>">
        <?= $hint?>
    </div>
</div>

