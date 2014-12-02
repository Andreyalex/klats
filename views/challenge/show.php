<?php

use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Challenge */
$solutions = $model->solutions;
?>
<div class="challenge-show">

    <div id="challenge">
        <h2><?= \Yii::t('app', $model->title); ?></h2>
        <div><?= $model->description ?></div>
    </div>

    <div class="controls">
        <a href="<?= Url::to(['challenge/edit', 'id' => $model->id])?>" class="btn btn-primary">
            <?= \Yii::t('app', 'Изменить'); ?>
        </a>
    </div>

    <div id="solutions">
        <h2><?= \Yii::t('app', 'Работьі'); ?></h2>
        <?= include 'solutions.php'; ?>
    </div>
</div>