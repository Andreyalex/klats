<?php

use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Challenge */
$solutions = $model->solutions;
?>
<div class="challenge challenge-show">

    <div id="challenge">
        <?php if ($model->title) { ?>
            <?php if ($model->image) { ?>
                <a href="<?=$model->image->urlFull?>" target="_blank" class="image-title">
                    <img src="<?=$model->image->urlSquare?>">
                </a>
            <?php } ?>
            <h1 class="title"><?=\Yii::t('app', $model->title)?></h1>
        <?php } ?>
        <div class="description"><?=$model->description?></div>
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