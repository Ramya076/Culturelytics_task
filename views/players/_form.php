<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Players $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="players-form">

    <?php
    $form_id = ($model->isNewRecord) ? 'user-create' : 'user-update';

    $form = ActiveForm::begin([
                'id' => $form_id,
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>

    <div class="row">

        <div class="col-md-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'oninput'=>"return allowOnlyAlphabets(event)"]) ?>
        </div>


        <div class="col-md-12">
            <?= $form->field($model, 'jersey_no')->textInput(['maxlength' => 5, 'class' => 'form-control', 'oninput' => 'return allowOnlynumbers(event)']) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'type')->textInput(['maxlength' => true,'oninput'=>"return allowOnlyAlphabets(event)"]) ?>
        </div>


    </div>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Add Player', ['class' => 'btn btn-primary','style'=>'float:right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    
function allowOnlyAlphabets(event) {
  var inputValue = event.target.value;
  var pattern = /^[a-zA-Z\s]+$/;
  if (!pattern.test(inputValue)) {
    event.target.value = inputValue.replace(/[^a-zA-Z\s]/g, '');
    event.preventDefault();
  }
}

function allowOnlyNumbers(event) {
  var inputValue = event.target.value;
  var pattern = /^[0-9]+$/;
  if (!pattern.test(inputValue)) {
    event.target.value = inputValue.replace(/[^0-9]/g, '');
    event.preventDefault();
  }
}



</script>