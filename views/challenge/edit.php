<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use letyii\tinymce\Tinymce as Wysiwyg;

/** @var $model app\models\Challenge */
?>
<div id="challenge-create">

    <h1><?=Yii::t('app', 'Изменить')?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

        <?= $form->field($model, 'title')->input('text'); ?>

        <div class="image"><img src="<?=$model->image->urlPreview ?>"></div>
        <?= $form->field($model, 'file')->fileInput(); ?>

        <?= $form->field($model, 'description')->widget(Wysiwyg::className(), [
            'configs' => [
                'plugins' => [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste jbimages"
                ],
                'toolbar' =>
                    "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fullscreen link image jbimages",

                'pagebreak_separator' => "<!-- pagebreak -->",

                'image_advtab' => true,
                'image_list' => [
                    ['title' => 'My image 1', 'value' => 'http://www.tinymce.com/my1.gif'],
                    ['title' => 'My image 2', 'value' => 'http://www.moxiecode.com/my2.gif']
                ]
            ]
        ]); ?>

        <?= $form->field($model, 'isPublic')->checkbox(); ?>

        <?= Html::activeHiddenInput($model, 'userId', ['value' => $model->userId? $model->userId : Yii::$app->user->id]); ?>
        <?= Html::activeHiddenInput($model, 'id'); ?>

        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
            <span onclick="window.history.back()" class="btn btn-default"><?=Yii::t('app', 'Отмена')?></span>
        </div>

    <?php ActiveForm::end(); ?>
</div>
