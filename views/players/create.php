<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Players $model */

$this->title = 'Create Players';
$this->params['breadcrumbs'][] = ['label' => 'Players', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="players-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
