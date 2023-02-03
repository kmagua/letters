<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LetterSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="letter-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'organization_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'reference_number') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'date_received') ?>

    <?php // echo $form->field($model, 'letter') ?>

    <?php // echo $form->field($model, 'response_required') ?>

    <?php // echo $form->field($model, 'response_letter') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'last_modified') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
