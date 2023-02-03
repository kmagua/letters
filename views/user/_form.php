<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
$where = (Yii::$app->user->identity->role == 'AOR')?['id' => app\models\User::getOrgId()]:new yii\db\Expression('1=1');
$orgs = ArrayHelper::map(app\models\Organization::find()->where($where)->all(), 'id', 'institution_name');
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'email_address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'organization_id')->widget(Select2::classname(), [
                'data' => $orgs,
                'language' => 'en',
                'options' => ['placeholder' => 'Select an Organization ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'other_names')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'id_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'personal_number')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'designation')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'id_upload')->fileInput(['class' => 'form-control']) ?>
        </div>
    </div>
    
    <div class="form-group" style="margin-top: 10px">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
