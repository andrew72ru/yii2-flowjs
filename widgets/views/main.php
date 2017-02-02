<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.02.17
 * Time: 17:51
 *
 * @var \yii\web\View $this
 */
use yii\helpers\Html;

?>

<div class="panel panel-default">
    <div class="panel-body flow-drop collapse">
        <?= Yii::t('flowjs', 'Drop files here or {select} files on You computer', [
            'select' => Html::tag('span', Yii::t('flowjs', 'select'), [
                'class' => 'flow-browse-image',
            ])
        ])?>
    </div>
</div>

