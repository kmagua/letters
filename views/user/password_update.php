<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = "Change Password";
$web = Yii::getAlias('@web');
?>


<div class="user-form">
    <div class="user-password-reset-form">
        <div class="row">
        <div class ='col-3 col-md-3 col-sm-12'></div>
    
            <div class="border p-4 rounded col-sm-12 col-md-6 col-6">
                <div class="mb-4 text-center col-md-12 col-12 col-sm-12 bg-light-success">            
                    <img src="<?= $web ?>/logo.png" alt="" width="180">
                </div>
                <div class="mb-4 text-center col-md-12 col-12 col-sm-12">
                    <h5 class="mb-0 text-success"><strong><?= $this->title ?></strong></h5>
                </div>
                <div class="form-body"> 
    
    <?php $form = ActiveForm::begin(); ?>
    <?php
    foreach($model->errors as $k=>$error){
        echo "<h5>Errors</h5>";
        echo $error[0] , "<br>";
    }
    ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
    
    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <div class="form-group" style="margin-top: 10px">
        <div class="col-md-6">
            <?= Html::submitButton('Change Password', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
            </div>
        <?php ActiveForm::end(); ?>
    </div> 
    </div>
</div>