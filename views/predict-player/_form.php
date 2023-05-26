<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PredictPlayer $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="predict-player-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'player_id')->textInput() ?>

    <?= $form->field($model, 'score')->textInput() ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
