<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PredictPlayer $model */

$this->title = 'Create Predict Player';
$this->params['breadcrumbs'][] = ['label' => 'Predict Players', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="predict-player-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
