<?php
/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'User info';
?>

<div id="user-details">
    <div class="item">
        <span>Id</span><span><?php echo $model->id; ?></span>
    </div>
    <div class="item">
        <span>Login</span><span><?php echo $model->login; ?></span>
    </div>
    <div class="item">
        <span>Name</span><span><?php echo $model->name; ?></span>
    </div>
    <div class="item">
        <span>Created date</span><span><?php echo $model->createdDate; ?></span>
    </div>
    <div class="item">
        <span>Updated date</span><span><?php echo $model->updatedDate; ?></span>
    </div>
</div>

