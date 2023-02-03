<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\widgets\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Sign In';
$this->params['breadcrumbs'][] = $this->title;
$web = Yii::getAlias('@web');
?>
<div class="site-login">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'class' => 'row g-3',
        
    ]); ?>
    
    <div class="row">
        <div class ='col-3 col-md-3 col-sm-12'></div>
    
    <div class="border p-4 rounded col-sm-12 col-md-6 col-6">
        <div class="mb-4 text-center col-md-12 col-12 col-sm-12 bg-light-success">
            
            <img src="<?= $web ?>/logo.png" alt="" width="180">
            <?php if(Yii::$app->session->hasFlash('user_confirmation')): ?>
            <div class="alert alert-success alert-dismissable col-lg-12 col-md-12">
                <h6><?php echo Yii::$app->session->getFlash('user_confirmation'); ?></h6>
            </div>
            <?php endif; ?>
        </div>
        <div class="mb-4 text-center col-md-12 col-12 col-sm-12">
            <h5 class="mb-0 text-success"><strong><?= $this->title ?></strong></h5>
        </div>
        <div class="form-body">
        <div class="col-12">
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        </div>
        <div class="col-12">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-md-6">
            <div class="form-check form-switch">
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => "<div class=\"offset-lg-1 col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                ]) ?>
            </div>
        </div>
        <div class="col-12">
            <div class="d-grid">
                <?= Html::submitButton('Login', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>            
            </div>
            <p style="margin-top: 10px">Forgot your password? Kindly reset below</p>
            <div class="d-grid">
                <?= Html::a('Reset Password', ['user/reset-password'], ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>           
            </div>           
        </div>

        </div>
    </div>
    <div class ='col-3 col-md-3 col-sm-12'></div>
    <?php ActiveForm::end(); ?>
    </div>
    
</div>
