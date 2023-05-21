<?php

use app\models\Players;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\PlayersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Predicted YOUR Playing X1';
?>
<div class="players-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <?php Pjax::begin(['enablePushState' => false, 'id' => 'pjax-grid-view']); ?>

        <div class="row ">
            <div class="col-sm-3">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped table_squad'],
                    'summary' => '', // Disable the summary section
                    'columns' => [
                        [
                            'attribute' => 'name',
                            'label' => 'Our Squad',
                            'headerOptions' => ['class' => 'custom-header-class'],
                            'contentOptions' => function ($model, $key, $index, $column) {
                                return ['data-id' => $model->id, 'draggable' => 'true'];
                            },
                        ],
                    ],
                ]);
                ?>
            </div>
            <div class="col-sm-3">
            <?= Html::beginForm(['store-predictions'], 'post', ['id' => 'prediction-form']) ?>

            
            <?= GridView::widget([
                'dataProvider' => $predict,
                'tableOptions' => ['class' => 'table table-striped table_predict'],
                'summary' => '', // Disable the summary section
                'columns' => [
                    [
                        'attribute' => 'name',
                        'label' => 'Predicted your Playing X1',
                        'headerOptions' => ['class' => 'custom-header-class'],
                        'contentOptions' => ['class' => 'column-name'],
                    ],
                    [
                        'attribute' => 'score',
                        'label' => 'Score',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'custom-header-class'],
                        'contentOptions' => ['class' => 'column-score'],
                        'value' => function ($model) {
                            $score = $model->score; // Assuming 'score' is the attribute name in the database
                            return '<input type="text" class="form-control" name="input_' . $model->id . '" value="' . $score . '" onkeypress="return /[0-9\s]/i.test(event.key)" maxlength="5">';
                        },
                    ],
                ],
            ]); 
            ?>
            
            </div>
        </div>
  
    <?= Html::endForm() ?>  

    <div class="btnrow">

        <?= Html::a('Add', yii\helpers\Url::to(['create']), ['data-bs-toggle' => 'tooltip', 'data-bs-original-title' => 'Add player to Squad', 'class' => 'btn viewModallgBtn', 'data-title' => "Add player to Squad"]) ?>
        <?= Html::Button('Predict', ['class' => 'btn submit_btn', 'name' => 'predict-button', 'style'=>'margin-right: 10px;']) ?>
        <?= Html::a('View', ['view'], ['class' => 'btn ']) ?>

    </div>
</div>
<?php Pjax::end(); ?>
<script>

$(document).ready(function () {
    function initializeDraggableElements() {
        $('td[draggable="true"]').draggable({
            revert: 'invalid'
        });

        $('.table_predict tbody tr').droppable({
            drop: function (event, ui) {
                var draggedTd = ui.helper;
                var draggedDataId = draggedTd.data('id');

                $(this).append(draggedTd);

                draggedTd.removeClass('ui-draggable ui-draggable-handle ui-droppable');
                draggedTd.removeAttr('style');

                $.ajax({
                    url: '<?php echo yii\helpers\Url::to(['players/drag-player']) ?>',
                    method: 'POST',
                    data: {
                        draggedId: draggedDataId,
                    },
                    success: function (response) {
                        $.pjax.reload({
                            container: "#pjax-grid-view",
                            timeout: false
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Error saving changes:', error);
                    }
                });
            }
        });
    }

    initializeDraggableElements();

    $(document).on('click', '.submit_btn', function (e) {
        e.preventDefault();

        var formData = $('#prediction-form').serialize();

        $.ajax({
            url: '<?php echo Url::to(['store-predictions']); ?>',
            method: 'POST',
            data: formData,
            success: function (response) {
                alert('Prediction added successfully!');
                $.pjax.reload({
                    container: "#pjax-grid-view",
                    timeout: false
                });
            },
            error: function (xhr, status, error) {
                console.error('Error storing predictions:', error);
            }
        });
    });

    $(document).on('pjax:success', function () {
        initializeDraggableElements();
    });
});

</script>
