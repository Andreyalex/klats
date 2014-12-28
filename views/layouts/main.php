<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'CLATTS',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' =>
                    Yii::$app->user->isGuest?
                    [
                        ['label' => 'Login', 'url' => ['/site/login']],
                        ['label' => 'About', 'url' => ['/site/about']],
                    ] :
                    [
                        ['label' => 'Создать челендж', 'url' => ['/challenge/create']],
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                         'url' => ['/site/logout'],
                         'linkOptions' => ['data-method' => 'post']
                        ]
                    ]
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>

<style>
    .navbar-brand {
        color: #aaa !important;
        /*transition: text-shadow 0.1s;*/
    }

    .navbar-brand.highlight {
        text-shadow: 0px 0px 10px #bdf;
    }

</style>
<script>
    $(function(){
        var f = function() {

            var has = $('.navbar-brand').hasClass('highlight'),
                interval = Math.abs(Math.random()* (has? 1000 : 50));

            setTimeout(function(){
                has?
                    $('.navbar-brand').removeClass('highlight'):
                    $('.navbar-brand').addClass('highlight');
                f()
            }, interval);
        }
        f();
    })

</script>

</body>
</html>
<?php $this->endPage() ?>
