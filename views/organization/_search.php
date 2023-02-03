<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\OrganizationSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="organization-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'institution_name') ?>

    <?= $form->field($model, 'organization_type') ?>

    <?= $form->field($model, 'kra_pin_number') ?>

    <?= $form->field($model, 'physical_address') ?>

    <?php // echo $form->field($model, 'email_address') ?>

    <?php // echo $form->field($model, 'postal_address') ?>

    <?php // echo $form->field($model, 'phone_number') ?>

    <?php // echo $form->field($model, 'registered_by') ?>

    <?php // echo $form->field($model, 'request_letter') ?>

    <?php // echo $form->field($model, 'aor_appointment_letter') ?>

    <?php // echo $form->field($model, 'registration_charter_agreement') ?>

    <?php // echo $form->field($model, 'date_registered') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
