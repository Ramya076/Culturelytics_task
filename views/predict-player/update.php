<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PredictPlayer $model */

$this->title = 'Update Predict Player: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Predict Players', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="predict-player-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
