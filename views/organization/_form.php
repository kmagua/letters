<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Organization $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="organization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'institution_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organization_type')->dropDownList([ 'Public' => 'Public', 'Non-Governmental' => 'Non-Governmental', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'kra_pin_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'physical_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postal_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registered_by')->textInput() ?>

    <?= $form->field($model, 'request_letter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'aor_appointment_letter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registration_charter_agreement')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_registered')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
