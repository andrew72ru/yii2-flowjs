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
 */
use yii\helpers\Html;

?>

<div class="panel panel-default collapse flow-drop">
    <div class="panel-body">
        <?= Yii::t('flowjs', 'Drop files here or {select} files on You computer', [
            'select' => Html::tag('span', Yii::t('flowjs', 'select'), [
                'class' => 'flow-browse-image',
            ])
        ])?>
    </div>
    <div class="panel-body flow-error collapse">
        <?= Yii::t('flowjs', 'Your browser, unfortunately, not support the HTML5 File API.')?>
    </div>
    <div class="panel-body collapse flow-preview <?= $preview ? 'in' : ''?>">
        <?= $preview ? Html::img($preview, [
            'class' => 'flow-thumbnail',
            'style' => [
                'width' => $width,
                'height' => $height
            ],
        ]) : null?>
    </div>
    <div class="panel-body collapse">
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
</div>

