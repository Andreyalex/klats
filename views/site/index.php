<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <h2><?= \Yii::t('app', 'Свежие'); ?></h2>
    <div class="row">
        <?php foreach ($publicChallenges as $challenge) { ?>
            <div class="challenge preview col-lg-3">
                <a href="<?= Url::to(['challenge/show', 'id' => $challenge->id]); ?>">
                    <span><?= \Yii::t('app', $challenge->title); ?></span>
                </a>
                <div class="desc"><?= \Yii::t('app', $challenge->description); ?></div>
            </div>
        <?php } ?>
    </div>

    <?php if (isset($myChallenges)) { ?>
    <h2><?= \Yii::t('app', 'Мои'); ?></h2>
    <div class="row">
        <?php foreach ($myChallenges as $challenge) { ?>
            <div class="challenge preview col-lg-3">
                <a href="<?= Url::to(['challenge/show', 'id' => $challenge->id]); ?>">
                    <span><?= \Yii::t('app', $challenge->title); ?></span>
                </a>
                <div class="desc"><?= \Yii::t('app', $challenge->description); ?></div>
            </div>
        <?php } ?>
    </div>
    <?php } ?>

    <?php if (isset($takenChallenges)) { ?>
    <h2><?= \Yii::t('app', 'Учавствую'); ?></h2>
    <div class="row">
        <?php foreach ($takenChallenges as $challenge) { ?>
            <div class="challenge preview col-lg-3">
                <a href="<?= Url::to(['challenge/show', 'id' => $challenge->id]); ?>">
                    <span><?= \Yii::t('app', $challenge->title); ?></span>
                </a>
                <div class="desc"><?= \Yii::t('app', $challenge->description); ?></div>
            </div>
        <?php } ?>
    </div>
    <?php } ?>

    <?php if (isset($friends)) { ?>
    <div class="row">
        <?php foreach ($friends as $user) { ?>
            <div class="user preview col-lg-3">
                <a href="<?= Url::to(['user/show', 'id' => $challenge->id]); ?>">
                    <span><?= \Yii::t('app', $user->name); ?></span>
                </a>
                <div class="desc"><?= \Yii::t('app', $user->username); ?></div>
            </div>
        <?php } ?>
    </div>
    <?php } ?>

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
