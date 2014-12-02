<?php
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="solution-show">
    <div id="solution">
        <h1><?= \Yii::t('app', $solution->title); ?></h1>
        <div class="image"><?=$solution->image?></div>
        <div<?= $solution->description ?></div>
    </div>
</div>