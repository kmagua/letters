<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\Letter $model */
/** @var yii\widgets\ActiveForm $form */

$orgs = ArrayHelper::map(app\models\Organization::find()->all(), 'id', 'institution_name');
?>

<div class="letter-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
        <div class="col-6 col-md-6 col-sm-12">
            <?= $form->field($model, 'organization_id')->widget(Select2::classname(), [
                'data' => $orgs,
                'language' => 'en',
                'options' => ['placeholder' => 'Select an Organization ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        
        <div class="col-6 col-md-6 col-sm-12">
            <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'en',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'changeYear' => true,
                    'changeMonth' => true,
                    'maxDate' => "+0d",
                    
                ],
            ]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-6 col-md-6 col-sm-12">
            <?= $form->field($model, 'reference_number')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="col-6 col-md-6 col-sm-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-6 col-md-6 col-sm-12">
            <?= $form->field($model, 'date_received')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'en',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'changeYear' => true,
                    'changeMonth' => true,
                    'maxDate' => "+0d",
                    
                ],
            ]) ?>
        </div>
        
        <div class="col-6 col-md-6 col-sm-12">
            <?= $form->field($model, 'letter_upload')->fileInput(['class' => 'form-control']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-6 col-md-6 col-sm-12">
            <?= $form->field($model, 'response_required')->dropDownList([1=> 'Yes', 0=>'No'], ['prompt' => '']) ?>
        </div>
        
        <div class="col-6 col-md-6 col-sm-12">
            
        </div>
    </div>

    <div class="form-group" style="margin-top: 10px">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
