<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = "Password Reset";
$web = Yii::getAlias('@web');
?>

<div style="margin-top:2%;background-color:white;" id="Log">
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
                    <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => false]); ?>  
                    <div class="col-12">
                    <?= $form->field($model, 'email_address')->textInput()->label('Enter your E-Mail Address') ?>       

                    <?= $form->field($model, 'reCaptcha')->widget(\kekaadrenalin\recaptcha3\ReCaptchaWidget::class) ?>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6"  style="margin-top: 10px">
                       <?= Html::submitButton('Reset Password', ['class' => 'btn btn-success', 'style' => 'background-color:#006638']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div> 
    </div>
</div>
